<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Services\Components\AppIcons;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Components\FormComponents;
use App\Services\Components\TableComponents;
use App\Filament\Resources\CategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategoryResource\RelationManagers;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = AppIcons::CATEGORY_ICON;

    protected static ?string $navigationGroup = 'Inventory Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Item Category')
                ->schema([
                    FormComponents::masterTextInput(
                        'name',
                        'Category',
                        true,
                        'Please enter category'
                    ),
                ])
                ->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TableComponents::masterTextColumn(
                    'name',
                    'Category',
                    false,
                    null,
                    true,
                    true,
                ),
                TableComponents::masterTextColumn(
                    'user.name',
                    'Created by',
                    false,
                    null,
                    false,
                    true,
                ),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
