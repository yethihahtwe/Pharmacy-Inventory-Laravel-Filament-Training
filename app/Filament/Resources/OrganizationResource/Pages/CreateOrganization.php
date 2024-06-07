<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrganization extends CreateRecord
{
    protected static string $resource = OrganizationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        
        $data['user_id'] = auth()->user()->id;
        return $data;
    }

    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle():?string{
        return 'Organization successfully created.';
    }
}
