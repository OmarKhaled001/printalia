<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Subscription;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'اشتراكات المصممين';
    protected static ?string $label = 'الاشتراك';
    protected static ?string $navigationGroup = 'الحسابات';

    protected static ?string $pluralLabel = 'الاشتراكات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    Select::make('plan_id')
                        ->relationship('plan', 'name')->label('الخطة')
                        ->disabled(),


                    Select::make('status')->label('الحالة')
                        ->options([
                            'active' => 'مطابق',
                            'rejected' => 'مرفوض',
                        ]),

                    DatePicker::make('start_date')->disabled()->label('تاريخ الاشتراك'),
                    DatePicker::make('end_date')->label('تاريخ الانتهاء'),
                    Toggle::make('is_approved')
                        ->label('تمت الموافقة'),


                    Forms\Components\FileUpload::make('receipt')
                        ->label('إيصال الدفع')
                        ->directory('receipts')
                        ->image()
                        ->columnSpanFull()
                        ->imagePreviewHeight(100)
                        ->downloadable(),

                    Textarea::make('notes')->columnSpanFull()->label('ملاحظات'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subscribable.name')->label('المستخدم'),
                TextColumn::make('plan.name')->label('الخطة'),
                BooleanColumn::make('is_approved')->label('تمت الموافقة'),
                TextColumn::make('status')->badge()->label('الحالة'),
                TextColumn::make('start_date')->date()->label('تاريخ الاشتراك'),
                TextColumn::make('end_date')->date()->label('تاريخ الانتهاء'),
                ImageColumn::make('receipt')->label('إيصال التحويل')->disk('public'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->filters([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
