<?php

namespace App\Services\Components;

use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\UserResource\Pages\CreateUser;

class FormComponents
{
    public static function userNameInput()
    {
        return TextInput::make('name')
        ->label('Username')
        ->placeholder('Please enter user name')
        ->required();
    }

    public static function userEmailInput()
    {
        return TextInput::make('email')
        ->placeholder('Please enter user email')
        ->email()
        ->required();
    }

    public static function userPasswordInput()
    {
        return TextInput::make('password')
            ->dehydrateStateUsing(fn($state) => Hash::make($state))
            ->dehydrated(fn($state) => filled($state))
            ->placeholder('Please enter password')
            ->password()
            ->confirmed()
            ->revealable()
            ->required(fn($livewire) => $livewire instanceof CreateUser);
    }

    public static function userPasswordConfirmationInput()
    {
        return TextInput::make('password_confirmation')
        ->label('Confirm Password')
        ->placeholder('Please confirm password')
        ->dehydrated(false)
        ->password()
        ->revealable()
        ->required(fn($livewire) => $livewire instanceof CreateUser);
    }
    public static function userAdminInput()
    {
        return Toggle::make('is_admin')->label('Make this user admin');
    }
    public static function userPositionInput()
    {
        return TextInput::make('position')
        ->placeholder('Please enter user position');
    }

    public static function userAvatarUpload()
    {
        return FileUpload::make('avatar')->avatar()->imageEditor()->directory('avatars');
    }

    public static function userWarehouseSelect()
    {
        return Select::make('warehouse_id')
        ->label('Warehouse')
        ->placeholder('Please select user warehouse');
    }
}