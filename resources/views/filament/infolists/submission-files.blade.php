<div class="space-y-1">
    @forelse (($getState() ?? []) as $index => $path)
        <div wire:key="submission-file-{{ $index }}">
            <a class="text-primary underline" href="{{ route('resource-submissions.files.download', ['submission' => $getRecord(), 'index' => $index]) }}">
                {{ basename((string) $path) }}
            </a>
        </div>
    @empty
        <span>—</span>
    @endforelse
</div>
