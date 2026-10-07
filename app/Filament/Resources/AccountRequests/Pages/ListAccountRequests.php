<?php

namespace App\Filament\Resources\AccountRequests\Pages;

use App\Filament\Resources\AccountRequests\AccountRequestResource;
use Filament\Resources\Pages\ListRecords;

class ListAccountRequests extends ListRecords
{
    protected static string $resource = AccountRequestResource::class;
}
