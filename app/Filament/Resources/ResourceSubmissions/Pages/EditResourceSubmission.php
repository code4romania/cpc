<?php

namespace App\Filament\Resources\ResourceSubmissions\Pages;

use App\Filament\Resources\ResourceSubmissions\ResourceSubmissionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditResourceSubmission extends EditRecord
{
    protected static string $resource = ResourceSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
