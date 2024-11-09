<?php

namespace App\Filament\Doctor\Resources;

use App\Enums\RoleType;
use App\Filament\Doctor\Resources\ResultResource\Pages;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ResultResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Patient Result';

    protected static ?string $navigationGroup = 'Patient';

    protected static ?int $navigationSort = 7;

    public static function getNavigationBadge(): ?string
    {
        $admin = User::role(RoleType::admin->value)->count();
        $doctor = User::role(RoleType::doctor->value)->count();
        $radiologist = User::role(RoleType::radiologist->value)->count();

        return static::getModel()::count() - $admin - $doctor - $radiologist;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->readOnly(),
                TextInput::make('ssn')->readOnly(),
                TextInput::make('result')
                    ->string(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('ssn')->searchable(),
                TextColumn::make('result'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->withoutRole([RoleType::doctor->value, RoleType::admin->value, RoleType::radiologist->value]);
            });
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
            'index' => Pages\ListResults::route('/'),
            'view' => Pages\ViewResult::route('/{record}'),
            'edit' => Pages\EditResult::route('/{record}/edit'),
        ];
    }
}
