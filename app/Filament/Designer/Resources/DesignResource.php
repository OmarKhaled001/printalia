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
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
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
            ->schema([]);
    }


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
            // ->filter(
            //     [

            //         Filter::make('subscription_range')
            //             ->label('تصاميم الاشتراك الحالي')
            //             ->query(function (Builder $query) {
            //                 $designer = auth('designer')->user();
            //                 $subscription = $designer->activeSubscription();

            //                 if (!$subscription) {
            //                     return $query->whereRaw('0 = 1'); // لا شيء
            //                 }

            //                 return $query->whereBetween('created_at', [
            //                     $subscription->start_date,
            //                     $subscription->end_date,
            //                 ]);
            //             })
            //             ->default()
            //     ]


            // )
            ->actions([
                Tables\Actions\ViewAction::make()->label(false), // View button
                Action::make('download_image')
                    ->label('تحميل')
                    ->icon('heroicon-o-arrow-down-tray') // أيقونة التحميل
                    ->color('success')
                    ->hidden(fn($record) => !$record->image_front) // يخفي الزر إذا لم توجد صورة
                    ->action(function ($record) {
                        // يمكنك هنا تنفيذ شيء مثل تتبع المشاركة أو فتح الصورة
                        return response()->download(storage_path('app/public/' . $record->image_front));
                    }),

            ])

            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDesigns::route('/'),
            'create' => Pages\CreateDesign::route('/create'),
            'edit' => Pages\EditDesign::route('/{record}/edit'),
            'view' => Pages\ViewDesign::route('/{record}'),

        ];
    }
}
