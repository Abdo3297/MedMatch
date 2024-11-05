<?php

namespace App\Filament\Doctor\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Surgery;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Doctor\Resources\SurgeryResource\Pages;
use App\Filament\Doctor\Resources\SurgeryResource\RelationManagers;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class SurgeryResource extends Resource
{
    protected static ?string $model = Surgery::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Medical Record';
    protected static ?int $navigationSort = 1;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Translate::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->string()
                    ])
                    ->columnSpanFull()
                    ->locales(config('app.available_locale')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListSurgeries::route('/'),
            'create' => Pages\CreateSurgery::route('/create'),
            'view' => Pages\ViewSurgery::route('/{record}'),
            'edit' => Pages\EditSurgery::route('/{record}/edit'),
        ];
    }
}
