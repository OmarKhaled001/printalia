<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'اشتراكات المصممين';
    protected static ?string $pluralLabel = 'الاشتراكات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('plan_id')->relationship('plan', 'name')->disabled(),
                DatePicker::make('start_date')->disabled(),
                DatePicker::make('end_date')->disabled(),
                Textarea::make('notes'),
                Toggle::make('is_approved')->label('تمت الموافقة'),
                Select::make('status')
                    ->options([
                        'active' => 'نشط',
                        'pending' => 'قيد الانتظار',
                        'cancelled' => 'ملغي',
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
                TextColumn::make('status')->badge(),
                TextColumn::make('start_date')->date(),
                TextColumn::make('end_date')->date(),
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
