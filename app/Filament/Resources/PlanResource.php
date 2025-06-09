<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Plan;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;

use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BooleanColumn;
use App\Filament\Resources\PlanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PlanResource\RelationManagers;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;
    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';
    protected static ?string $navigationLabel = 'الخطط';
    protected static ?string $pluralLabel = 'الخطط';
    protected static ?string $navigationGroup = 'المنتجات';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->label('اسم الخطة')->required(),
            TextInput::make('price')->label('السعر')->suffix('ر.س')
                ->numeric()->required(),
            Toggle::make('is_infinity')
                ->label('غير محدودة')
                ->reactive(),

            TextInput::make('duration')
                ->label('المدة')
                ->numeric()
                ->required()
                ->visible(fn(Get $get) => !$get('is_infinity')),

            Select::make('duration_unit')
                ->label('وحدة المدة')
                ->options([
                    'day' => 'يوم',
                    'month' => 'شهر',
                    'year' => 'سنة',
                ])
                ->default('day')
                ->required()
                ->visible(fn(Get $get) => !$get('is_infinity')),

            TextInput::make('design_count')->label('حد التصاميم')->numeric()->nullable(),
            Textarea::make('description')->label('الوصف')->rows(3)->nullable(),
            Toggle::make('is_active')->label('نشطة'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('الاسم')->searchable(),
            TextColumn::make('price')->label('السعر')->money('SAR'),
            TextColumn::make('duration')->label('المدة'),
            TextColumn::make('duration_unit')->label('الوحدة'),
            TextColumn::make('design_count')->label('حد التصاميم'),
            BooleanColumn::make('is_active')->label('نشطة'),
        ])->filters([])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
