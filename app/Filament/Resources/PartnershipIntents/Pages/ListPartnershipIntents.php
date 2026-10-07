<?php

namespace App\Filament\Resources\PartnershipIntents\Pages;

use App\Filament\Resources\PartnershipIntents\PartnershipIntentResource;
use Filament\Resources\Pages\ListRecords;

class ListPartnershipIntents extends ListRecords
{
    protected static string $resource = PartnershipIntentResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
