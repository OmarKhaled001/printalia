<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Filament\Resources\PlanResource\RelationManagers;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'خطط الاشتراك';
    protected static ?string $pluralLabel = 'الخطط';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->label('اسم الخطة')->required(),
            TextInput::make('price')->label('السعر')->numeric()->required(),
            TextInput::make('duration')->label('المدة')->numeric()->required(),
            Select::make('duration_unit')->label('وحدة المدة')
                ->options([
                    'day' => 'يوم',
                    'month' => 'شهر',
                    'year' => 'سنة',
                ])
                ->default('day')
                ->required(),
            TextInput::make('design_count')->label('حد التصاميم')->numeric()->nullable(),
            Textarea::make('description')->label('الوصف')->rows(3)->nullable(),
            Toggle::make('is_active')->label('نشطة'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('الاسم')->searchable(),
            TextColumn::make('price')->label('السعر'),
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
