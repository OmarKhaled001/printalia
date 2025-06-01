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
                    // الخطوة 1: اختيار المنتج والشعارات
                    Step::make('product_selection')
                        ->label('المنتج والشعارات')
                        ->schema([
                            Radio::make('product_id')
                                ->label('اختر المنتج')
                                ->options(function () {
                                    return Product::query()
                                        ->select('id', 'name', 'image_front', 'is_double_sided', 'image_back')
                                        ->get()
                                        ->mapWithKeys(function ($product) {
                                            return [
                                                $product->id => new HtmlString(
                                                    '<div class="flex flex-col items-center gap-2 p-2 rounded-md hover:border-primary-500 cursor-pointer">' .
                                                        '<img src="' . asset('storage/' . $product->image_front) . '" class="w-12 h-18 object-contain" alt="' . e($product->name) . '">' .
                                                        '<span>' . e($product->name) . '</span>' .
                                                        '</div>'
                                                )
                                            ];
                                        })->toArray();
                                })
                                ->columns(3)
                                ->live()
                                ->afterStateUpdated(function ($state, Forms\Set $set) {
                                    if ($state) {
                                        $product = Product::find($state);
                                        $set('is_double_sided', $product?->is_double_sided ?? false);
                                        $set('background_image_front', $product?->image_front ?? null);
                                        $set('background_image_back', $product?->image_back ?? null);
                                        $set('sale_price', null); // يمكنك تعيين قيمة افتراضية من المنتج
                                        $set('profit', 0);
                                        Log::info("Product selected: ID {$state}, Double-sided: " . ($product?->is_double_sided ? 'Yes' : 'No') . ", Front: " . $product?->image_front . ", Back: " . $product?->image_back);
                                    } else {
                                        $set('is_double_sided', false);
                                        $set('background_image_front', null);
                                        $set('background_image_back', null);
                                        $set('sale_price', null);
                                        $set('profit', 0);
                                        Log::info("Product selection cleared.");
                                    }
                                })
                                ->required()
                                ->inlineLabel(false)
                                ->columnSpanFull(),

                            // الحقول المخفية التي يتم تحديثها بواسطة Radio
                            Hidden::make('is_double_sided')->default(false),
                            Hidden::make('background_image_front'),
                            Hidden::make('background_image_back'),

                            // هذه الحقول ستستقبل البيانات من مكون design-editor
                            Hidden::make('image_front')->id('data.image_front'), // Data URL للصورة المدمجة
                            Hidden::make('image_back')->id('data.image_back'),   // Data URL للصورة المدمجة

                            // هذه الحقول ستستقبل قائمة مسارات الشعارات كـ JSON string array
                            Hidden::make('logo_front'),
                            Hidden::make('logo_back'),
                        ]),

                    // الخطوة 2: التصميم الأمامي
                    Step::make('front_design')
                        ->label('التصميم الأمامي')
                        ->schema([
                            View::make('components.design-editor')
                                ->viewData(function (Forms\Get $get, ?Design $record) {
                                    $bgFrontPath = $get('background_image_front');
                                    // عند التعديل، حاول جلب الشعارات المحفوظة من النموذج
                                    $initialLogos = [];
                                    if ($record && $record->logo_front) {
                                        try {
                                            $decodedLogos = json_decode($record->logo_front, true);
                                            if (is_array($decodedLogos)) {
                                                $initialLogos = $decodedLogos;
                                            }
                                        } catch (\Throwable $e) {
                                            Log::warning("Failed to decode initial logo_front for design {$record->id}: " . $e->getMessage());
                                        }
                                    }

                                    Log::info("Front design editor: Background='{$bgFrontPath}', Initial Logos: " . json_encode($initialLogos));

                                    return [
                                        'background' => $bgFrontPath ? asset('storage/' . $bgFrontPath) : null,
                                        'targetInputId' => 'data.image_front',
                                        'canvasId' => 'front-canvas',
                                        'initialLogos' => $initialLogos, // تمرير الشعارات الأولية كـ array
                                    ];
                                })
                                ->columnSpanFull(),
                        ]),

                    // الخطوة 3: التصميم الخلفي (يظهر مشروطًا)
                    Step::make('back_design')
                        ->label('التصميم الخلفي')
                        ->schema([
                            View::make('components.design-editor')
                                ->viewData(function (Forms\Get $get, ?Design $record) {
                                    $bgBackPath = $get('background_image_back');
                                    $initialLogos = [];
                                    if ($record && $record->logo_back) {
                                        try {
                                            $decodedLogos = json_decode($record->logo_back, true);
                                            if (is_array($decodedLogos)) {
                                                $initialLogos = $decodedLogos;
                                            }
                                        } catch (\Throwable $e) {
                                            Log::warning("Failed to decode initial logo_back for design {$record->id}: " . $e->getMessage());
                                        }
                                    }

                                    Log::info("Back design editor: Background='{$bgBackPath}', Initial Logos: " . json_encode($initialLogos));

                                    return [
                                        'background' => $bgBackPath ? asset('storage/' . $bgBackPath) : null,
                                        'targetInputId' => 'data.image_back',
                                        'canvasId' => 'back-canvas',
                                        'initialLogos' => $initialLogos, // تمرير الشعارات الأولية كـ array
                                    ];
                                })
                                ->columnSpanFull(),
                        ])
                        ->visible(fn(Forms\Get $get) => $get('is_double_sided')), // يظهر فقط إذا كان المنتج ذا وجهين

                    // الخطوة 4: تفاصيل التصميم والنشر
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
                                    ->afterStateUpdated(function ($state, Forms\Get $get, Forms\Set $set) {
                                        $product = Product::find($get('product_id'));
                                        $productPrice = $product?->price ?? 0;
                                        $set('profit', (float)$state - (float)$productPrice);
                                        Log::info("Sale price updated: {$state}, Profit: " . ((float)$state - (float)$productPrice));
                                    })
                                    ->columnSpan(1),

                                Placeholder::make('product_price')
                                    ->label('سعر التكلفة')
                                    ->content(
                                        fn(Forms\Get $get) => number_format(Product::find($get('product_id'))?->price ?? 0, 2) . ' ر.س'
                                    )
                                    ->columnSpan(1),

                                Placeholder::make('profit')
                                    ->label('إجمالي المكسب المتوقع')
                                    ->content(
                                        fn(Forms\Get $get) => number_format(max(($get('sale_price') ?? 0) - (Product::find($get('product_id'))?->price ?? 0), 0), 2) . ' ر.س'
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان التصميم')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image_front')
                    ->label('صورة الواجهة الأمامية')
                    ->disk('public')
                    ->size(50),
                Tables\Columns\ImageColumn::make('image_back')
                    ->label('صورة الواجهة الخلفية')
                    ->disk('public')
                    ->size(50)
                    ->toggleable(isToggledHiddenByDefault: true), // يمكن إخفاؤها افتراضياً
                Tables\Columns\TextColumn::make('product.name')
                    ->label('المنتج')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('sale_price')
                    ->label('سعر البيع')
                    ->money('SAR') // تنسيق العملة
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('منشور')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('حالة النشر')
                    ->boolean()
                    ->trueLabel('المنشورة')
                    ->falseLabel('غير المنشورة')
                    ->placeholder('الكل'),
                // يمكن إضافة فلاتر أخرى للمنتجات أو المصممين إذا لزم الأمر
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDesigns::route('/'),
            'create' => Pages\CreateDesign::route('/create'),
            'edit' => Pages\EditDesign::route('/{record}/edit'),
        ];
    }

    /**
     * Process Data URL image and save to storage.
     *
     * @param string $base64Data The base64 encoded image data.
     * @param string $type The type of design (e.g., 'front', 'back').
     * @return string The stored image path relative to the storage disk.
     * @throws \Exception If saving the image fails.
     */
    protected function saveDesignImage(string $base64Data, string $type): string
    {
        try {
            // Remove data URI scheme (e.g., "data:image/png;base64,")
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Data));

            if ($imageData === false) {
                throw new \Exception("Failed to decode base64 image data.");
            }

            $datePath = now()->format('Y/m/d');
            $filename = "designs/{$type}/{$datePath}/" . Str::uuid() . '.png'; // Using PNG for consistency

            Storage::disk('public')->put($filename, $imageData);
            return $filename;
        } catch (\Exception $e) {
            Log::error("Failed to save {$type} design image: " . $e->getMessage());
            Notification::make()
                ->title('خطأ في حفظ التصميم')
                ->body('فشل حفظ الصورة، الرجاء المحاولة مرة أخرى.')
                ->danger()
                ->send();
            throw $e; // إعادة رمي الاستثناء للسماح لـ Filament بالتعامل معه
        }
    }

    /**
     * Normalize logo data from form input to a JSON array.
     * Ensures consistent storage of logo paths.
     *
     * @param mixed $input The raw input from the 'logo_front' or 'logo_back' hidden field.
     * @return string A JSON string representing an array of logo paths.
     */
    protected function normalizeLogoData($input): string
    {
        // إذا كانت القيمة بالفعل مصفوفة، فقط قم بترميزها كـ JSON
        if (is_array($input)) {
            return json_encode(array_values($input)); // تأكد أنها قائمة مرتبة
        }

        // إذا كانت سلسلة نصية، حاول فك تشفيرها
        if (is_string($input)) {
            try {
                $decoded = json_decode($input, true);
                // تأكد أن النتيجة مصفوفة بعد فك التشفير
                if (is_array($decoded)) {
                    return json_encode(array_values($decoded));
                }
            } catch (\Throwable $e) {
                Log::warning("Invalid logo data format during decode: " . $e->getMessage() . " Input: " . $input);
            }
        }
        // في حال فشل الفك أو كانت القيمة غير صالحة، أعد مصفوفة JSON فارغة
        return '[]';
    }

    /**
     * Mutate form data before creating a new record.
     * Processes design images and normalizes logo data.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // معالجة التصميم الأمامي
        if (!empty($data['image_front']) && Str::startsWith($data['image_front'], 'data:image/')) {
            $data['image_front'] = $this->saveDesignImage($data['image_front'], 'front');
        } else {
            // إذا لم يتم إنشاء تصميم جديد أو كانت البيانات فارغة، قم بتعيينها إلى null
            $data['image_front'] = null;
        }

        // معالجة التصميم الخلفي إذا كان المنتج ذا وجهين
        if (!empty($data['is_double_sided']) && !empty($data['image_back']) && Str::startsWith($data['image_back'], 'data:image/')) {
            $data['image_back'] = $this->saveDesignImage($data['image_back'], 'back');
        } else {
            $data['image_back'] = null;
        }

        // تأكيد حفظ أسماء الشعارات بصيغة JSON
        $data['logo_front'] = $this->normalizeLogoData($data['logo_front'] ?? null);
        $data['logo_back'] = $this->normalizeLogoData($data['logo_back'] ?? null);

        // إزالة الحقول المؤقتة غير المرتبطة بقاعدة البيانات
        unset($data['background_image_front']);
        unset($data['background_image_back']);
        unset($data['is_double_sided']);

        return $data;
    }

    /**
     * Mutate form data before updating an existing record.
     * Processes design images (only if they are new Data URLs) and normalizes logo data.
     */
    protected function mutateFormDataBeforeUpdate(array $data): array
    {
        // إذا تم تعديل التصميم الأمامي (أي أنه لا يزال Data URL)
        if (!empty($data['image_front']) && Str::startsWith($data['image_front'], 'data:image/')) {
            $data['image_front'] = $this->saveDesignImage($data['image_front'], 'front');
        } else if (empty($data['image_front'])) {
            // إذا تم مسح التصميم الأمامي من الكانفاس (أو لم يتم تعديله ولم يكن هناك تصميم سابق)
            $data['image_front'] = null;
        }
        // إذا لم يتم تعديل التصميم الأمامي (أي أنه مسار ملف محفوظ بالفعل)، لا تفعل شيئًا

        // إذا تم تعديل التصميم الخلفي
        if (!empty($data['is_double_sided']) && !empty($data['image_back']) && Str::startsWith($data['image_back'], 'data:image/')) {
            $data['image_back'] = $this->saveDesignImage($data['image_back'], 'back');
        } else if (empty($data['image_back'])) {
            $data['image_back'] = null;
        }

        // تأكيد حفظ أسماء الشعارات بصيغة JSON
        $data['logo_front'] = $this->normalizeLogoData($data['logo_front'] ?? null);
        $data['logo_back'] = $this->normalizeLogoData($data['logo_back'] ?? null);

        // إزالة الحقول المؤقتة غير المرتبطة بقاعدة البيانات
        unset($data['background_image_front']);
        unset($data['background_image_back']);
        unset($data['is_double_sided']);

        return $data;
    }

    /**
     * Filter designs by authenticated designer
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('designer_id', Auth::id());
    }
}
