<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Organization;
use Filament\Resources\Resource;
use App\Services\Components\AppIcons;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\OrganizationExporter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrganizationResource\Pages;
use App\Filament\Resources\OrganizationResource\RelationManagers;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $navigationIcon = AppIcons::ORGANIZATION_ICON;

    protected static ?string $navigationGroup = 'Demographic Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Organization and Abbreviation')->schema([
                    TextInput::make('name'),
                    TextInput::make('abbr')
                ])->columns(2)

        //         'name',
        // 'abbr',
        // 'editable',
        // 'user_id',
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('abbr')
                ->badge(),
                TextColumn::make('editable')
                ->formatStateUsing(fn($state) => $state == true ? 'Editable' : 'Non-editable')
                ->badge()
                ->color(fn($state) => $state == true ? 'success' : 'primary'),
                TextColumn::make('user.name')
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
            ])
            ->headerActions([
                ExportAction::make()
                ->exporter(OrganizationExporter::class)
                ->icon(AppIcons::DOWNLOAD_ICON)
                ->label('Download Excel')
                ->fileName(fn(): string => date('d-M-Y') . '-organization-export')
                ->columnMapping(false)
            ])
            ;
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
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }
}
