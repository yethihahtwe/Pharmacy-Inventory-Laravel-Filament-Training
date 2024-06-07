<?php

namespace App\Filament\Resources;

use App\Filament\Exports\UserExporter;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Services\Components\AppIcons;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ExportAction;
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
                TextColumn::make('position')
                ->default('Not specified')
                ->badge()
                ->color(fn($state) => $state === 'Not specified' ? 'warning' : 'success'),
                TextColumn::make('is_admin')
                ->label('Role')
                ->badge()
                ->color(fn($state) => $state == true ? 'success' : 'primary')
                ->formatStateUsing(fn($state) => $state == true ? 'Admin' : 'User'),
                TextColumn::make('warehouse_id')
                ->label('Warehouse/Clinic'),
            ])
            ->recordUrl(null)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ExportAction::make()
                ->exporter(UserExporter::class)
                ->icon(AppIcons::DOWNLOAD_ICON)
                ->label('Export Excel')
                ->color('primary')
                ->outlined()
                ->columnMapping(false)
                ->fileName(fn() => date('d-M-Y') . '-export-users')
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
