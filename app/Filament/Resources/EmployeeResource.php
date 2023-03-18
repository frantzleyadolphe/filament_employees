<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Employee;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeResource\RelationManagers;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'EMPLOYEES MANAGEMENT';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('department_id')
                    ->relationship('department', 'name')->required(),
                Select::make('city_id')
                    ->relationship('city', 'name')->required(),
                Select::make('state_id')
                    ->relationship('state', 'name')->required(),
                Select::make('country_id')
                    ->relationship('country', 'name')->required(),
                TextInput::make('firstname')->required(),
                TextInput::make('lastname')->required(),
                TextInput::make('address')->required(),
                TextInput::make('zip_code')->required(),
                DatePicker::make('birth_date')->required(),
                DatePicker::make('date_hired')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('lastname')->searchable(),
                TextColumn::make('firstname')->searchable(),
                TextColumn::make('department.name')->searchable(),
                TextColumn::make('birth_date')->date(),
                TextColumn::make('date_hired'),
            ])
            ->filters([
                //pour filtrer par departement
                SelectFilter::make('department_id')->relationship('department', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
