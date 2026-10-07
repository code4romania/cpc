<?php

namespace App\Filament\Support;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class LimitedFileUpload
{
    public static function configure(SpatieMediaLibraryFileUpload $upload, int $megabytes): SpatieMediaLibraryFileUpload
    {
        return $upload
            ->maxSize($megabytes * 1024)
            ->helperText(__('admin.upload_limit', ['size' => $megabytes]));
    }
}
