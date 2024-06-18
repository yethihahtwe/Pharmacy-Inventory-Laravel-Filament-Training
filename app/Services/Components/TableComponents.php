<?php

namespace App\Services\Components;

use Filament\Tables\Columns\TextColumn;

class TableComponents
{
    public static function masterTextColumn($textColumnName, $textColumnLabel, $isBadge, $color, $isSearchable, $isSortable)
    {
        return TextColumn::make($textColumnName)
            ->label($textColumnLabel)
            ->badge($isBadge)
            ->color($color)
            ->searchable($isSearchable)
            ->sortable($isSortable);
    }
}
