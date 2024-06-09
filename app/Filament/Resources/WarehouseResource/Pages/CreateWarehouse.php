<?php

namespace App\Filament\Resources\WarehouseResource\Pages;

use App\Filament\Resources\WarehouseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWarehouse extends CreateRecord
{
    protected static string $resource = WarehouseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->user()->id;
        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Warehouse/Clinic successfully created.';
    }
}
