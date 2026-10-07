<?php

namespace App\Filament\Resources\PartnershipIntents\Pages;

use App\Filament\Resources\PartnershipIntents\PartnershipIntentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPartnershipIntent extends EditRecord
{
    protected static string $resource = PartnershipIntentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
