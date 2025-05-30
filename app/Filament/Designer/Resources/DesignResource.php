<?php

namespace App\Filament\Designer\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Design;
use Nette\Utils\Image;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\View;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Designer\Resources\DesignResource\Pages;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Filament\Designer\Resources\DesignResource\RelationManagers;

class DesignResource extends Resource
{
    protected static ?string $model = Design::class;
    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    protected static ?string $modelLabel = 'تصميم';
    protected static ?string $pluralModelLabel = 'التصاميم';
    protected static ?string $navigationLabel = 'التصاميم';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('product_selection')
                        ->label('المنتج والشعارات')
                        ->schema([
                            Radio::make('product_id')
                                ->label('اختر المنتج')
                                ->options(
                                    Product::query()
                                        ->select('id', 'name', 'image_front')
                                        ->get()
                                        ->mapWithKeys(function ($product) {
                                            return [
                                                $product->id => new HtmlString(
                                                    '<div class="flex flex-col items-center gap-2 p-2  rounded-md hover:border-primary-500 cursor-pointer">' .
                                                        '<img src="' . asset('storage/' . $product->image_front) . '" class="w-12 h-18 object-contain" alt="' . e($product->name) . '">' .
                                                        '<span>' . e($product->name) . '</span>' .
                                                        '</div>'
                                                )
                                            ];
                                        })->toArray()
                                )
                                ->columns(3)
                                ->live()
                                ->afterStateUpdated(function ($state, Set $set) {
                                    $product = Product::find($state);
                                    $set('is_double_sided', $product?->is_double_sided ?? false);
                                    $set('background_image_front', $product?->image_front ?? '');
                                    $set('background_image_back', $product?->image_back ?? '');
                                    $set('sale_price', null);
                                    $set('profit', 0);
                                    Log::info("Product selected: ID {$state}, Double-sided: " . ($product?->is_double_sided ? 'Yes' : 'No'));
                                })
                                ->required()
                                ->inlineLabel(false)
                                ->columnSpanFull(),
                            // Grid::make()->schema([
                            //     FileUpload::make('logo_front')
                            //         ->label('الشعار الأمامي')
                            //         ->image()
                            //         ->directory('designs/logos')
                            //         ->maxSize(2048) // 2MB
                            //         ->acceptedFileTypes(['image/png', 'image/jpeg'])
                            //         ->imageResizeMode('cover')
                            //         ->imageResizeTargetHeight('500')
                            //         ->getUploadedFileNameForStorageUsing(
                            //             fn(TemporaryUploadedFile $file): string => self::generateLogoFilename($file)
                            //         )
                            //         ->imageEditor()
                            //         ->live()
                            //         ->required()
                            //         ->multiple(false)
                            //         ->disk('public')
                            //         ->columnSpan(1)
                            //         ->helperText('ارفع الشعار الأمامي للمنتج (PNG أو JPEG، الحجم الأقصى 2MB)'),

                            //     FileUpload::make('logo_back')
                            //         ->label('الشعار الخلفي')
                            //         ->image()
                            //         ->directory('designs/logos')
                            //         ->maxSize(2048) // 2MB
                            //         ->acceptedFileTypes(['image/png', 'image/jpeg'])
                            //         ->imageResizeMode('cover')
                            //         ->imageResizeTargetHeight('500')
                            //         ->getUploadedFileNameForStorageUsing(
                            //             fn(TemporaryUploadedFile $file): string => self::generateLogoFilename($file)
                            //         )
                            //         ->imageEditor()
                            //         ->live()
                            //         ->required()
                            //         ->multiple(false)
                            //         ->disk('public')
                            //         ->columnSpan(1)
                            //         ->visible(fn(Get $get) => $get('is_double_sided'))
                            //         ->helperText('ارفع الشعار الخلفي للمنتج (PNG أو JPEG، الحجم الأقصى 2MB)'),

                            // ])->columnSpan(2),
                            Hidden::make('is_double_sided')->default(false),
                            Hidden::make('background_image_front'),
                            Hidden::make('background_image_back'),
                            Hidden::make('image_front')->id('data.image_front'),
                            Hidden::make('image_back')->id('data.image_back'),
                            Hidden::make('logo_front'),
                            Hidden::make('logo_back'),

                        ]),

                    Step::make('front_design')
                        ->label('التصميم الأمامي')
                        ->schema([
                            View::make('components.design-editor')
                                ->label('محرر التصميم الأمامي')
                                ->viewData(function (Get $get) {
                                    $logo_front = $get('logo_front');
                                    Log::info('logo_front value: ' . json_encode($logo_front));

                                    $logo_path = is_array($logo_front) ? (reset($logo_front) ?: null) : $logo_front;
                                    if ($logo_path && !str_starts_with($logo_path, 'designs/logos/')) {
                                        Log::warning("Invalid logo_front path: {$logo_path}");
                                        $logo_path = null;
                                    }

                                    $logo_url = $logo_path ? asset('storage/' . $logo_path) : null;
                                    Log::info('logo_front URL: ' . ($logo_url ?? 'null'));

                                    return [
                                        'background' => $get('background_image_front')
                                            ? asset('storage/' . $get('background_image_front'))
                                            : null,
                                        'logo' => $logo_url,
                                        'targetInputId' => 'data.image_front',
                                        'canvasId' => 'front-canvas',
                                    ];
                                })
                                ->columnSpanFull(),
                        ]),

                    Step::make('back_design')
                        ->label('التصميم الخلفي')
                        ->schema([
                            View::make('components.design-editor')
                                ->label('محرر التصميم الخلفي')
                                ->viewData(function (Get $get) {
                                    $logo_back = $get('logo_back');
                                    Log::info('logo_back value: ' . json_encode($logo_back));

                                    $logo_path = is_array($logo_back) ? (reset($logo_back) ?: null) : $logo_back;
                                    if ($logo_path && !str_starts_with($logo_path, 'designs/logos/')) {
                                        Log::warning("Invalid logo_back path: {$logo_path}");
                                        $logo_path = null;
                                    }

                                    $logo_url = $logo_path ? asset('storage/' . $logo_path) : null;
                                    Log::info('logo_back URL: ' . ($logo_url ?? 'null'));

                                    return [
                                        'background' => $get('background_image_back')
                                            ? asset('storage/' . $get('background_image_back'))
                                            : null,
                                        'logo' => $logo_url,
                                        'targetInputId' => 'data.image_back',
                                        'canvasId' => 'back-canvas',
                                    ];
                                })
                                ->columnSpanFull(),
                        ])
                        ->visible(fn(Get $get) => $get('is_double_sided')),

                    Step::make('design_details')
                        ->label('النشر')
                        ->schema([
                            Grid::make(2)->schema([
                                TextInput::make('title')
                                    ->label('عنوان التصميم')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                TextInput::make('sale_price')
                                    ->label('سعر البيع المقترح')
                                    ->required()
                                    ->numeric()
                                    ->prefix('ر.س')
                                    ->minValue(0)
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        $product = Product::find($get('product_id'));
                                        $productPrice = $product?->price ?? 0;
                                        $set('profit', (float)$state - (float)$productPrice);
                                        Log::info("Sale price updated: {$state}, Profit: " . ((float)$state - (float)$productPrice));
                                    })
                                    ->columnSpan(1),

                                Placeholder::make('price')
                                    ->label('سعر التكلفة')
                                    ->content(
                                        fn(Get $get) => number_format(Product::find($get('product_id'))?->price ?? 0, 2) . ' ر.س'
                                    )
                                    ->columnSpan(1),

                                Placeholder::make('profit')
                                    ->label('إجمالي المكسب المتوقع')
                                    ->content(
                                        fn(Get $get) => number_format(max(($get('sale_price') ?? 0) - (Product::find($get('product_id'))?->price ?? 0), 0), 2) . ' ر.س'
                                    )
                                    ->columnSpan(1),
                            ]),

                            MarkdownEditor::make('description')
                                ->label('وصف التصميم')
                                ->columnSpanFull(),

                            Toggle::make('is_published')
                                ->label('نشر التصميم؟')
                                ->helperText('عند التفعيل، سيظهر التصميم في المتجر.')
                                ->required()
                                ->default(false),

                            Hidden::make('designer_id')
                                ->default(Auth::id()),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    /**
     * Generate unique filename for logo upload
     */
    protected static function generateLogoFilename(TemporaryUploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $dateFolder = now()->format('Y/m/d');

        return "designs/logos/{$dateFolder}/logo_{$filename}_" . now()->timestamp . ".{$extension}";
    }

    protected function normalizeLogoData($input): string
    {
        try {
            $decoded = is_string($input) ? json_decode($input, true) : $input;
            return json_encode(array_values((array) $decoded)); // تأكد أنها قائمة مرتبة
        } catch (\Throwable $e) {
            Log::warning("Invalid logo data format: " . $e->getMessage());
            return '[]';
        }
    }

    /**
     * Process form data before creation
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Handle front design
        if (!empty($data['image_front'])) {
            $data['image_front'] = $this->processDesignImage(
                $data['image_front'],
                'front',
                $data['product_id']
            );
        }

        // Handle back design
        if (!empty($data['is_double_sided']) && !empty($data['image_back'])) {
            $data['image_back'] = $this->processDesignImage(
                $data['image_back'],
                'back',
                $data['product_id']
            );
        }

        return $data;
    }

    protected function processDesignImage(string $base64, string $type, int $productId): string
    {
        try {
            $product = Product::findOrFail($productId);
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));

            $path = "designs/{$type}/" . now()->format('Y/m/d') . '/' . Str::uuid() . '.png';

            Storage::disk('public')->put($path, $imageData);

            return $path;
        } catch (\Exception $e) {
            Log::error("Design image save failed: " . $e->getMessage());
            throw new \Exception("فشل حفظ التصميم، الرجاء المحاولة مرة أخرى");
        }
    }


    protected function saveDesignImage(string $base64Data, string $type): string
    {
        try {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Data));
            $datePath = now()->format('Y/m/d');
            $filename = "designs/{$type}/{$datePath}/" . Str::uuid() . '.png';
            Storage::disk('public')->put($filename, $imageData);
            return $filename;
        } catch (\Exception $e) {
            Log::error("Failed to save {$type} design image: " . $e->getMessage());
            throw $e;
        }
    }


    protected function mutateFormDataBeforeUpdate(array $data): array
    {
        // إذا تم تعديل التصميم الأمامي
        if (!empty($data['image_front']) && str_starts_with($data['image_front'], 'data:image/')) {
            $data['image_front'] = $this->saveDesignImage($data['image_front'], 'front');
        }

        // إذا تم تعديل التصميم الخلفي
        if (!empty($data['is_double_sided']) && !empty($data['image_back']) && str_starts_with($data['image_back'], 'data:image/')) {
            $data['image_back'] = $this->saveDesignImage($data['image_back'], 'back');
        }

        // تأكيد حفظ أسماء الشعارات بصيغة JSON
        $data['logo_front'] = $this->normalizeLogoData($data['logo_front'] ?? null);
        $data['logo_back'] = $this->normalizeLogoData($data['logo_back'] ?? null);

        return $data;
    }



    /**
     * Filter designs by authenticated designer
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('designer_id', Auth::id());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_front')
                    ->label('صورة التصميم')
                    ->size(60),

                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان التصميم')
                    ->searchable(),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('اسم المنتج')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sale_price')
                    ->label('سعر البيع')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('منشور؟')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(false),
                Tables\Actions\DeleteAction::make()->label(false),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDesigns::route('/'),
            'create' => Pages\CreateDesign::route('/create'),
            'edit' => Pages\EditDesign::route('/{record}/edit'),

        ];
    }
}
