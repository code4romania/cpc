<?php

namespace App\Http\Controllers;

use App\Models\ResourceSubmission;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadResourceSubmissionFileController extends Controller
{
    public function __invoke(ResourceSubmission $submission, int $index): StreamedResponse
    {
        abort_unless(auth()->user()?->canAccessPanel(Filament::getPanel('admin')) === true, 403);

        $path = $submission->file_paths[$index] ?? null;

        abort_unless(is_string($path) && Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->download($path);
    }
}
