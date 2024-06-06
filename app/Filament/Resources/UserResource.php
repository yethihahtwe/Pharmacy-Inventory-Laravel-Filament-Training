<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Services\Components\AppIcons;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Components\FormComponents;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $navigationGroup = 'User Settings';
    protected static ?string $navigationIcon = AppIcons::USER_ICON;
    protected static ?string $model = User::class;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Name and Email')
                    ->schema([
                        FormComponents::userNameInput()->columnSpan(1),
                        FormComponents::userEmailInput()->columnSpan(1),
                        FormComponents::userWarehouseSelect()->columnSpan(1),
                    ])
                    ->columns(3),
                Section::make('Password')
                    ->schema([
                        FormComponents::userPasswordInput()->columnSpan(1),
                        FormComponents::userPasswordConfirmationInput(),
                    ])
                    ->columns(3),
                Section::make('Admin')
                    ->schema([
                        FormComponents::userAdminInput()->columnSpanFull(),
                    ]),
                Section::make('Profile Information')
                    ->schema([
                        FormComponents::userPositionInput()->columnSpan(1),
                        FormComponents::userAvatarUpload()->columnSpan(1),
                    ])
                    ->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('position'),
                TextColumn::make('is_admin'),
                TextColumn::make('warehouse_id'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
