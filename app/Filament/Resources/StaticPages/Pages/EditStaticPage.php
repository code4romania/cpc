<?php

namespace App\Filament\Resources\StaticPages\Pages;

use App\Filament\Resources\StaticPages\StaticPageResource;
use App\Models\StaticPage;
use App\Support\StaticPageBlocks;
use Filament\Resources\Pages\EditRecord;

class EditStaticPage extends EditRecord
{
    protected static string $resource = StaticPageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        /** @var StaticPage $page */
        $page = $this->getRecord();

        $data['blocks'] = array_replace_recursive(
            StaticPageBlocks::defaults($page->slug),
            is_array($data['blocks'] ?? null) ? $data['blocks'] : [],
        );

        return $data;
    }
}
