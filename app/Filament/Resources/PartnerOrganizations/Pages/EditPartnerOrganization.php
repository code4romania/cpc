<?php

namespace App\Filament\Resources\PartnerOrganizations\Pages;

use App\Filament\Resources\PartnerOrganizations\PartnerOrganizationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPartnerOrganization extends EditRecord
{
    protected static string $resource = PartnerOrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
