<?php

namespace App\Filament\Exports;

use App\Models\Organization;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class OrganizationExporter extends Exporter
{
    protected static ?string $model = Organization::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name'),
            ExportColumn::make('abbr'),
            ExportColumn::make('editable')
            ->formatStateUsing(fn($state) => $state == true ? 'Editable' : 'Non-editable'),
            ExportColumn::make('user.name'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your organization export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
