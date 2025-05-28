<?php

namespace App\Filament\Designer\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Design;
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
                        ->label('الخطوة 1: اختيار المنتج والشعارات')
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
                                                    '<div class="flex flex-col items-center gap-2 p-2 border rounded-md hover:border-primary-500 cursor-pointer">' .
                                                        '<img src="' . asset('storage/' . $product->image_front) . '" class="w-24 h-36 object-contain" alt="' . e($product->name) . '">' .
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

                            FileUpload::make('logo_front')
                                ->label('الشعار الأمامي')
                                ->image()
                                ->directory('designs/logos')
                                ->maxSize(2048) // 2MB
                                ->acceptedFileTypes(['image/png', 'image/jpeg'])
                                ->imageResizeMode('cover')
                                ->imageResizeTargetHeight('500')
                                ->getUploadedFileNameForStorageUsing(
                                    fn(TemporaryUploadedFile $file): string => self::generateLogoFilename($file)
                                )
                                ->imageEditor()
                                ->live()
                                ->required()
                                ->multiple(false)
                                ->disk('public')
                                ->columnSpan(1)
                                ->helperText('ارفع الشعار الأمامي للمنتج (PNG أو JPEG، الحجم الأقصى 2MB)'),

                            FileUpload::make('logo_back')
                                ->label('الشعار الخلفي')
                                ->image()
                                ->directory('designs/logos')
                                ->maxSize(2048) // 2MB
                                ->acceptedFileTypes(['image/png', 'image/jpeg'])
                                ->imageResizeMode('cover')
                                ->imageResizeTargetHeight('500')
                                ->getUploadedFileNameForStorageUsing(
                                    fn(TemporaryUploadedFile $file): string => self::generateLogoFilename($file)
                                )
                                ->imageEditor()
                                ->live()
                                ->required()
                                ->multiple(false)
                                ->disk('public')
                                ->columnSpan(1)
                                ->visible(fn(Get $get) => $get('is_double_sided'))
                                ->helperText('ارفع الشعار الخلفي للمنتج (PNG أو JPEG، الحجم الأقصى 2MB)'),

                            Hidden::make('is_double_sided')->default(false),
                            Hidden::make('background_image_front'),
                            Hidden::make('background_image_back'),
                            Hidden::make('image_front')->id('data.image_front'),
                            Hidden::make('image_front')->id('data\.image_front'),
                            Hidden::make('image_back')->id('data.image_back'),
                        ]),

                    Step::make('front_design')
                        ->label('الخطوة 2: التصميم الأمامي')
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
                        ->label('الخطوة 3: التصميم الخلفي')
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
                        ->label('الخطوة 4: التفاصيل والنشر')
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
        $newFilename = "designs/logos/logo_{$filename}_" . now()->timestamp . ".{$extension}";
        Log::info("Generated logo filename: {$newFilename}");
        return $newFilename;
    }

    /**
     * Process form data before creation
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Handle logo front
        if (isset($data['logo_front'])) {
            $logo_front = is_array($data['logo_front']) ? reset($data['logo_front']) : $data['logo_front'];
            if ($logo_front && str_starts_with($logo_front, 'designs/logos/')) {
                Log::info("Processing logo_front: {$logo_front}");
                $data['logo_front'] = $this->processUploadedLogo($logo_front);
            } else {
                Log::error("Invalid or empty logo_front: " . json_encode($logo_front));
                $data['logo_front'] = null;
            }
        }

        // Handle logo back
        if (isset($data['logo_back']) && $data['is_double_sided']) {
            $logo_back = is_array($data['logo_back']) ? reset($data['logo_back']) : $data['logo_back'];
            if ($logo_back && str_starts_with($logo_back, 'designs/logos/')) {
                Log::info("Processing logo_back: {$logo_back}");
                $data['logo_back'] = $this->processUploadedLogo($logo_back);
            } else {
                Log::error("Invalid or empty logo_back: " . json_encode($logo_back));
                $data['logo_back'] = null;
            }
        }

        // Save design images
        $data['image_front'] = $this->saveBase64Image($data['image_front'] ?? null, 'designs/final');
        if ($data['is_double_sided'] ?? false) {
            $data['image_back'] = $this->saveBase64Image($data['image_back'] ?? null, 'designs/final');
        }

        return $data;
    }

    /**
     * Process uploaded logo file
     */
    protected function processUploadedLogo(string $path): string
    {
        $newPath = 'designs/logos/' . basename($path);
        Log::info("Attempting to move logo from: {$path} to {$newPath}");

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->move($path, $newPath);
            Log::info("Logo successfully moved to: {$newPath}");
        } else {
            Log::error("Logo file not found at: {$path}");
            $newPath = $path; // Fallback to original path if move fails
        }

        return $newPath;
    }

    /**
     * Save base64 image to storage
     */
    protected function saveBase64Image(?string $base64Data, string $directory): ?string
    {
        if (empty($base64Data) || !str_contains($base64Data, 'base64')) {
            Log::warning("No valid base64 data provided for saving in {$directory}");
            return null;
        }

        try {
            $imageData = base64_decode(
                preg_replace('#^data:image/\w+;base64,#i', '', $base64Data)
            );
            $filename = rtrim($directory, '/') . '/' . Str::uuid() . '.png';
            Storage::disk('public')->put($filename, $imageData);
            Log::info("Base64 image saved: {$filename}");
            return $filename;
        } catch (\Exception $e) {
            Log::error("Failed to save base64 image in {$directory}: " . $e->getMessage());
            return null;
        }
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
