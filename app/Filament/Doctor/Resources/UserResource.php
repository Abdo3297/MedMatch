<?php

namespace App\Filament\Doctor\Resources;

use App\Enums\RoleType;
use App\Filament\Doctor\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Patient';

    protected static ?int $navigationSort = 5;

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
                Section::make('Patient Info')->schema([
                    TextInput::make('name')
                        ->readOnly(auth()->user()->hasRole(RoleType::radiologist->value))
                        ->required()
                        ->string(),
                    TextInput::make('email')
                        ->readOnly(auth()->user()->hasRole(RoleType::radiologist->value))
                        ->required()
                        ->email(),
                    TextInput::make('ssn')
                        ->readOnly(auth()->user()->hasRole(RoleType::radiologist->value))
                        ->label('ssn')
                        ->required()
                        ->rule(['digits:10', 'unique:users,ssn'])
                        ->numeric(),
                ])->columns(1),
                Section::make('Patient Profile')->schema([
                    SpatieMediaLibraryFileUpload::make('profile')
                        ->disabled(auth()->user()->hasRole(RoleType::radiologist->value))
                        ->image()
                        ->downloadable()
                        ->maxSize(1024)
                        ->collection('profile'),
                ])->columns(1),
                Section::make('Patient Rays')->schema([
                    SpatieMediaLibraryFileUpload::make('rays')
                        ->multiple()
                        ->downloadable()
                        ->maxSize(1024)
                        ->collection('rays')
                        ->disabled(auth()->user()->hasRole(RoleType::doctor->value)),
                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('ssn')
                    ->searchable(),
                SpatieMediaLibraryImageColumn::make('profile')
                    ->circular()
                    ->collection('profile'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->withoutRole([RoleType::doctor->value, RoleType::admin->value, RoleType::radiologist->value]);
            })
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('User deleted')
                            ->body('The User has been deleted successfully.'),
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->successNotification(
                        Notification::make()
                            ->success()
                            ->title('All Users deleted')
                            ->body('All Users have been deleted successfully.'),
                    ),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
