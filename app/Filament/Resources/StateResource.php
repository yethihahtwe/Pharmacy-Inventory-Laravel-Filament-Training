<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\State;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Services\Components\AppIcons;
use App\Filament\Exports\StateExporter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Components\FormComponents;
use App\Filament\Resources\StateResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StateResource\RelationManagers;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static ?string $navigationIcon = AppIcons::STATE_ICON;

    protected static ?string $navigationGroup = 'Demographic Settings';

    protected static ?string $navigationLabel = 'State/Division/Province';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FormComponents::countrySelect(),
                FormComponents::stateInput(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('country')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->badge()
                    ->color(fn (string $state): string => $state == 'burma' ? 'success' : 'warning')
                    ->searchable()->sortable(),
            ])
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
            ->recordUrl(null)
            ->headerActions([
                ExportAction::make()
                    ->icon(AppIcons::DOWNLOAD_ICON)
                    ->label('Download Excel')
                    ->color('primary')
                    ->outlined()
                    ->exporter(StateExporter::class)
                    ->fileName(fn (): string => date('d-M-Y') . '-state-export')
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
            'index' => Pages\ListStates::route('/'),
            'create' => Pages\CreateState::route('/create'),
            'edit' => Pages\EditState::route('/{record}/edit'),
        ];
    }
}
