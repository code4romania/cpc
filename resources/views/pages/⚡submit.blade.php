<?php

use App\Enums\ResourceType;
use App\Enums\SubmissionStatus;
use App\Models\County;
use App\Models\ResourceCategory;
use App\Models\ResourceSubmission;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

new #[Layout('layouts.app')] #[Title('Submit Resource')] class extends Component
{
    use WithFileUploads;

    public string $title = '';

    public string $description = '';

    public string $type = '';

    public string $category = '';

    public string $language = '';

    public string $createdOn = '';

    public string $targetAudience = '';

    public string $tags = '';

    public string $authorCredentials = '';

    public string $notes = '';

    public string $submitterName = '';

    public string $submitterEmail = '';

    public string $submitterOrganization = '';

    public string $organizationWebsite = '';

    public string $phone = '';

    public string $externalUrl = '';

    /** @var array<int, string> */
    public array $counties = [];

    /** @var array<int, TemporaryUploadedFile> */
    public array $files = [];

    public bool $rightsConfirmed = false;

    public bool $reviewConfirmed = false;

    public bool $submitted = false;

    /**
     * @return list<string>
     */
    public function languageOptions(): array
    {
        return ['ro', 'en', 'fr', 'es', 'de', 'it', 'hu', 'other'];
    }

    /**
     * @return list<string>
     */
    public function countyOptions(): array
    {
        return County::query()->orderBy('name_ro')->pluck('name_ro')->all();
    }

    /**
     * @return list<string>
     */
    public function categoryOptions(): array
    {
        return ResourceCategory::query()->orderBy('sort_order')->get()->pluck('name')->filter()->values()->all();
    }

    public function submit(): void
    {
        $validated = $this->validate([
            'submitterOrganization' => ['required', 'string', 'max:255'],
            'organizationWebsite' => ['nullable', 'url', 'max:2048'],
            'counties' => ['required', 'array', 'min:1'],
            'counties.*' => ['string', Rule::in($this->countyOptions())],
            'submitterName' => ['required', 'string', 'max:255'],
            'submitterEmail' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::enum(ResourceType::class)],
            'language' => ['required', Rule::in($this->languageOptions())],
            'createdOn' => ['required', 'date'],
            'category' => ['required', 'string', Rule::in($this->categoryOptions())],
            'description' => ['required', 'string', 'max:5000'],
            'targetAudience' => ['required', 'string', 'max:255'],
            'externalUrl' => ['nullable', 'url', 'max:2048'],
            'tags' => ['nullable', 'string', 'max:500'],
            'authorCredentials' => ['nullable', 'string', 'max:2000'],
            'files' => ['required', 'array', 'min:1'],
            'files.*' => ['file', 'max:51200', 'mimes:pdf,doc,docx,ppt,pptx,mp4,mov,webm'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'rightsConfirmed' => ['accepted'],
            'reviewConfirmed' => ['accepted'],
        ]);

        $paths = [];

        foreach ($this->files as $file) {
            $paths[] = $file->store('resource-submissions', 'local');
        }

        $tags = collect(explode(',', $validated['tags'] ?? ''))
            ->map(fn (string $tag): string => trim($tag))
            ->filter()
            ->values()
            ->all();

        ResourceSubmission::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'category' => $validated['category'],
            'submitter_name' => $validated['submitterName'],
            'submitter_email' => $validated['submitterEmail'],
            'submitter_organization' => $validated['submitterOrganization'],
            'organization_website' => $validated['organizationWebsite'] ?: null,
            'counties' => $validated['counties'],
            'phone' => $validated['phone'] ?: null,
            'language' => $validated['language'],
            'created_on' => $validated['createdOn'],
            'target_audience' => $validated['targetAudience'],
            'tags' => $tags,
            'author_credentials' => $validated['authorCredentials'] ?: null,
            'notes' => $validated['notes'] ?: null,
            'file_paths' => $paths,
            'external_url' => $validated['externalUrl'] ?: null,
            'locale' => app()->getLocale(),
            'status' => SubmissionStatus::Pending,
        ]);

        $this->submitted = true;
        $this->resetExcept('submitted');
    }

    public function submitAnother(): void
    {
        $this->submitted = false;
    }
};
?>

<div class="min-h-screen bg-background">
    @if ($submitted)
        <main class="max-w-3xl mx-auto px-4 py-16">
            <x-ui.card class="p-10 text-center">
                <div class="text-5xl text-primary mb-5">✓</div>
                <h1 class="text-3xl font-bold text-navy">{{ __('submit.success_title') }}</h1>
                <p class="text-muted mt-4">{{ __('submit.success_body') }}</p>
                <div class="flex flex-wrap justify-center gap-3 mt-8">
                    <x-ui.button wire:click="submitAnother">{{ __('submit.another') }}</x-ui.button>
                    <x-ui.button href="{{ localized_route('resources.index') }}" variant="secondary">{{ __('submit.browse') }}</x-ui.button>
                </div>
            </x-ui.card>
        </main>
    @else
        <x-page-header :title="__('submit.title')" :subtitle="__('submit.subtitle')">
            <x-slot:icon>
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5 5 5M12 5v12"/>
                </svg>
            </x-slot:icon>
        </x-page-header>
        <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <x-ui.alert class="mb-8" :title="__('submit.guidelines_title')">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach (__('submit.guidelines_items') as $guideline)
                        <li>{{ $guideline }}</li>
                    @endforeach
                </ul>
            </x-ui.alert>

            <form wire:submit="submit" class="space-y-8 rounded-xl border border-[color:var(--color-border)] bg-white p-6 sm:p-8">
                <h2 class="text-2xl font-bold text-navy">{{ __('submit.title') }}</h2>

                <section class="space-y-5">
                    <h3 class="border-b border-[color:var(--color-border)] pb-2 text-base font-semibold text-navy">{{ __('submit.organization_section') }}</h3>
                    <x-ui.input wire:model="submitterOrganization" :label="__('submit.organization')" :placeholder="__('submit.organization_placeholder')" required required-mark :error="$errors->first('submitterOrganization')" />
                    <div class="grid gap-5 md:grid-cols-2">
                        <x-ui.input wire:model="organizationWebsite" type="url" :label="__('submit.organization_website')" :placeholder="__('submit.website_placeholder')" :error="$errors->first('organizationWebsite')" />
                        <div>
                            <livewire:multi-select-filter wire:model.live="counties" :options="$this->countyOptions()" :label="__('submit.counties')" :placeholder="__('submit.counties_placeholder')" :required-mark="true" />
                            @error('counties') <p class="mt-1 text-sm text-destructive">{{ $message }}</p> @enderror
                        </div>
                        <x-ui.input wire:model="submitterName" :label="__('submit.contact_name')" :placeholder="__('submit.contact_placeholder')" required required-mark :error="$errors->first('submitterName')" />
                        <x-ui.input wire:model="submitterEmail" type="email" :label="__('submit.email')" :placeholder="__('submit.email_placeholder')" required required-mark :error="$errors->first('submitterEmail')" />
                        <x-ui.input wire:model="phone" :label="__('submit.phone')" :placeholder="__('submit.phone_placeholder')" :error="$errors->first('phone')" />
                    </div>
                </section>

                <section class="space-y-5">
                    <h3 class="border-b border-[color:var(--color-border)] pb-2 text-base font-semibold text-navy">{{ __('submit.resource_section') }}</h3>
                    <x-ui.input wire:model="title" :label="__('submit.resource_title')" :placeholder="__('submit.title_placeholder')" required required-mark :error="$errors->first('title')" />
                    <div class="grid gap-5 md:grid-cols-3">
                        <x-ui.select wire:model="type" :label="__('submit.resource_type')" :placeholder="__('submit.choose_type')" required required-mark :error="$errors->first('type')">
                            @foreach (ResourceType::cases() as $resourceType)
                                <option value="{{ $resourceType->value }}">{{ $resourceType->label() }}</option>
                            @endforeach
                        </x-ui.select>
                        <x-ui.select wire:model="language" :label="__('submit.language')" :placeholder="__('submit.choose_language')" required required-mark :error="$errors->first('language')">
                            @foreach ($this->languageOptions() as $languageOption)
                                <option value="{{ $languageOption }}">{{ __("submit.languages.$languageOption") }}</option>
                            @endforeach
                        </x-ui.select>
                        <x-ui.input wire:model="createdOn" type="date" :label="__('submit.created_on')" required required-mark :error="$errors->first('createdOn')" />
                    </div>
                    <x-ui.select wire:model="category" :label="__('submit.category')" :placeholder="__('submit.choose_category')" required required-mark :error="$errors->first('category')">
                        @foreach ($this->categoryOptions() as $categoryOption)
                            <option value="{{ $categoryOption }}">{{ $categoryOption }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.textarea wire:model="description" :label="__('submit.description')" :placeholder="__('submit.description_placeholder')" rows="5" required required-mark :error="$errors->first('description')" />
                    <x-ui.input wire:model="targetAudience" :label="__('submit.target_audience')" :placeholder="__('submit.audience_placeholder')" required required-mark :error="$errors->first('targetAudience')" />
                    <x-ui.input wire:model="externalUrl" type="url" :label="__('submit.source_url')" :placeholder="__('submit.source_placeholder')" :error="$errors->first('externalUrl')" />
                    <x-ui.input wire:model="tags" :label="__('submit.tags')" :placeholder="__('submit.tags_placeholder')" :hint="__('submit.tags_hint')" :error="$errors->first('tags')" />
                    <x-ui.textarea wire:model="authorCredentials" :label="__('submit.author_credentials')" :placeholder="__('submit.credentials_placeholder')" rows="3" :error="$errors->first('authorCredentials')" />
                </section>

                <section class="space-y-5">
                    <h3 class="border-b border-[color:var(--color-border)] pb-2 text-base font-semibold text-navy">{{ __('submit.upload_section') }}</h3>
                    <div>
                        <p class="mb-1 text-sm font-medium text-navy">{{ __('submit.files') }}<span class="text-destructive"> *</span></p>
                        <label class="relative flex cursor-pointer flex-col items-center justify-center rounded-lg border border-dashed border-primary/20 bg-surface-muted px-6 py-10 text-center">
                            <input id="resource-files" type="file" wire:model="files" multiple class="absolute inset-0 h-full w-full cursor-pointer" style="opacity: 0">
                            <span class="pointer-events-none">
                                <svg class="mx-auto h-8 w-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 3h6l5 5v13a1 1 0 01-1 1H8a1 1 0 01-1-1V4a1 1 0 011-1z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 3v5h5M9 13h6M9 17h6"/>
                                </svg>
                                <span class="mt-3 block text-sm font-medium text-primary">{{ __('submit.dropzone_action') }} <span class="font-normal text-navy">{{ __('submit.dropzone_or') }}</span></span>
                                <span class="mt-1 block text-xs text-muted">{{ __('submit.files_hint') }}</span>
                            </span>
                        </label>
                        @if (count($files) > 0)
                            <ul class="mt-3 space-y-1 text-sm text-navy">
                                @foreach ($files as $file)
                                    <li>{{ $file->getClientOriginalName() }}</li>
                                @endforeach
                            </ul>
                        @endif
                        @error('files') <p class="mt-1 text-sm text-destructive">{{ $message }}</p> @enderror
                        @error('files.*') <p class="mt-1 text-sm text-destructive">{{ $message }}</p> @enderror
                    </div>
                </section>

                <section class="space-y-5">
                    <h3 class="border-b border-[color:var(--color-border)] pb-2 text-base font-semibold text-navy">{{ __('submit.additional_section') }}</h3>
                    <x-ui.textarea wire:model="notes" :label="__('submit.notes')" :placeholder="__('submit.notes_placeholder')" rows="4" :error="$errors->first('notes')" />
                    <div class="space-y-3">
                        <label class="flex items-start gap-3 rounded-lg bg-surface-muted px-4 py-3 text-sm text-navy">
                            <input type="checkbox" wire:model="rightsConfirmed" class="mt-0.5 h-4 w-4 shrink-0 rounded border-[color:var(--color-border)] text-accent focus:ring-accent">
                            <span>{{ __('submit.rights') }} <span class="text-destructive">*</span></span>
                        </label>
                        @error('rightsConfirmed') <p class="text-sm text-destructive">{{ $message }}</p> @enderror
                        <label class="flex items-start gap-3 rounded-lg bg-surface-muted px-4 py-3 text-sm text-navy">
                            <input type="checkbox" wire:model="reviewConfirmed" class="mt-0.5 h-4 w-4 shrink-0 rounded border-[color:var(--color-border)] text-accent focus:ring-accent">
                            <span>{{ __('submit.review') }} <span class="text-destructive">*</span></span>
                        </label>
                        @error('reviewConfirmed') <p class="text-sm text-destructive">{{ $message }}</p> @enderror
                    </div>
                </section>

                <div class="flex flex-wrap gap-3">
                    <x-ui.button type="submit">{{ __('submit.button') }}</x-ui.button>
                    <x-ui.button href="{{ localized_route('resources.index') }}" variant="secondary">{{ __('submit.cancel') }}</x-ui.button>
                </div>
            </form>
        </main>
    @endif
</div>
