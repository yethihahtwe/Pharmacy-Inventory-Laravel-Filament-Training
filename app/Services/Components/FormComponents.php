<?php

namespace App\Services\Components;

use App\Models\State;
use Filament\Forms\Get;
use App\Models\Township;
use App\Models\Warehouse;
use App\Models\Organization;
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

    public static function countrySelect()
    {
        return Select::make('country')
            ->required()
            ->placeholder('Please select country')
            ->options([
                'burma' => 'Burma',
                'thailand' => 'Thailand',
            ])
            ->native(false);
    }
    public static function stateInput()
    {
        return TextInput::make('name')
            ->required()
            ->label(__('State/Division/Province'))
            ->placeholder('Please enter state/division/province')
            ->maxLength(255);
    }

    public static function warehouseInput()
    {
        return TextInput::make('name')
            ->label(__('Warehouse/Clinic Name'))
            ->placeholder('Please enter warehouse/clinic name')
            ->required()
            ->maxLength(255)
            ->unique(ignoreRecord: true);
    }

    public static function organizationSelect()
    {
        return Select::make('organization_id')
            ->label(__('Organization'))
            ->placeholder('Please select organization')
            ->options(Organization::all()->pluck('name', 'id'))
            ->searchable()
            ->preload()
            ->required()
            ->native(false);
    }

    public static function stateSelect()
    {
        return Select::make('state_id')
            ->label(__('State/Divison/Province'))
            ->placeholder('Please select state')
            ->options(State::all()->pluck('name', 'id'))
            ->searchable()
            ->preload()
            ->required()
            ->native(false);
    }

    public static function townshipSelect()
    {
        return Select::make('township_id')
            ->label(__('Township'))->placeholder('Please select township')
            ->options(function (Get $get) {
                $townships = Township::query()->where('state_id', $get('state_id'))->pluck('name', 'id');
                if ($townships && $townships->isNotEmpty()) {
                    return $townships;
                }
                return ['No township available'];
            })
            ->searchable()
            ->preload()
            ->native(false)
            ->required();
    }

    public static function parentWarehouseToggle()
    {
        return Toggle::make('has_parent')
            ->label(__('This has a parent warehouse'))
            ->inline()
            ->live()
            ->columnSpanFull();
    }

    public static function parentWarehouseSelect()
    {
        return Select::make('parent_id')
            ->label(__('Parent Warehouse'))
            ->placeholder('Please select parent warehouse')
            ->options(function (Get $get) {
                $currentWarehouseId = $get('id');
                return Warehouse::where('id', '!=', $currentWarehouseId)->pluck('name', 'id');
            })
            ->searchable()
            ->preload()
            ->native(false)
            ->required(fn(Get $get): bool => $get('has_parent') == true)
            ->visible(fn(Get $get): bool => $get('has_parent'));
    }

    public static function donorInput()
    {
        return TextInput::make('name')
            ->label('Donor Name')
            ->required()
            ->maxLength(255)
            ->unique(ignoreRecord: true)
            ->placeholder('Please enter donor name');
    }
}
