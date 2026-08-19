<?php

namespace App\Filament\Resources\StatisticDatasets\Pages;

use App\Filament\Resources\StatisticDatasets\StatisticDatasetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStatisticDataset extends EditRecord
{
    protected static string $resource = StatisticDatasetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
