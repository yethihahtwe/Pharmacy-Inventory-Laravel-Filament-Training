<?php

namespace App\Filament\Resources\DonorResource\Pages;

use App\Filament\Resources\DonorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDonor extends CreateRecord
{
    protected static string $resource = DonorResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->user()->id;
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): string
    {
        return 'Donor successfully created';
    }
}
