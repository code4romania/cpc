<?php

namespace App\Filament\Resources\PartnerOrganizations\Pages;

use App\Filament\Resources\PartnerOrganizations\PartnerOrganizationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPartnerOrganizations extends ListRecords
{
    protected static string $resource = PartnerOrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
