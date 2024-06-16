<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Warehouse;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Services\Components\AppIcons;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\WarehouseExporter;
use App\Services\Components\FormComponents;
use App\Filament\Resources\WarehouseResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WarehouseResource\RelationManagers;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;

    protected static ?string $navigationIcon = AppIcons::WAREHOUSE_ICON;

    protected static ?string $navigationGroup = 'Demographic Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Clinic/Warehouse details')
                    ->schema([
                        FormComponents::warehouseInput(),
                        FormComponents::organizationSelect(),
                        FormComponents::stateSelect()
                            ->live()
                            ->afterStateUpdated(function (Set $set) {
                                $set('township_id', null);
                            }),
                        FormComponents::townshipSelect(),
                    ])
                    ->columns(4),
                Section::make('Parent Warehouse')
                    ->schema([
                        FormComponents::parentWarehouseToggle(),
                        FormComponents::parentWarehouseSelect(),
                    ])
                    ->columns(3),

            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Warehouse/Clinic')->searchable()->sortable(),
                TextColumn::make('township.name')->label('Township')->searchable()->sortable(),
                TextColumn::make('state.name')->label('State')->searchable()->sortable(),
                TextColumn::make('parent.name')
                    ->default('No parent warehouse')
                    ->label('Parent Warehouse')->badge()
                    ->color(fn (string $state): string => $state == 'No parent warehouse' ? 'success' : 'primary')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('organization.abbr')
                    ->label('Organization')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Created By')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordUrl(null)
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
                    ->icon(AppIcons::DOWNLOAD_ICON)
                    ->label('Download Excel')
                    ->color('primary')
                    ->outlined()
                    ->exporter(WarehouseExporter::class)
                    ->fileName(fn (): string => date('d-M-Y') . '-warehouse-export')
                    ->columnMapping(false)
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
            'index' => Pages\ListWarehouses::route('/'),
            'create' => Pages\CreateWarehouse::route('/create'),
            'edit' => Pages\EditWarehouse::route('/{record}/edit'),
        ];
    }
}
