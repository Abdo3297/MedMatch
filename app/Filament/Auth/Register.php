<?php

namespace App\Filament\Auth;

use App\Enums\RoleType;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as AuthRegister;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class Register extends AuthRegister
{
    public function getHeading(): string|Htmlable
    {
        return __('Doctor Registration');
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            $this->getNameFormComponent(),
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(), // restrict
            $this->getPasswordConfirmationFormComponent(), // same
            TextInput::make('ssn')
                ->label('ssn')
                ->rule(['digits:10', 'unique:users,ssn'])
                ->numeric(),
        ])->statePath('data');
    }

    protected function handleRegistration(array $data): Model
    {
        $user = $this->getUserModel()::create($data);
        // verify account
        $user->update([
            'email_verified_at' => now(),
        ]);
        // give role after register
        $user->assignRole(RoleType::doctor->value);
        //user role
        //many to many
        // user id   role id   pivot table

        return $user;
    }
}
