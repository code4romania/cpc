<?php

namespace App\Filament\Resources\StatisticDatasets\Pages;

use App\Filament\Resources\StatisticDatasets\StatisticDatasetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStatisticDatasets extends ListRecords
{
    protected static string $resource = StatisticDatasetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
