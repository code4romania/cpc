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
        <x-page-header :title="__('submit.title')" :subtitle="__('submit.subtitle')" />
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <x-ui.alert class="mb-8" :title="__('submit.guidelines_title')">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach (__('submit.guidelines_items') as $guideline)
                        <li>{{ $guideline }}</li>
                    @endforeach
                </ul>
            </x-ui.alert>

            <form wire:submit="submit" class="bg-white rounded-xl border border-[color:var(--color-border)] p-8 space-y-8">
                <section>
                    <h2 class="text-xl font-bold text-navy pb-3 border-b border-[color:var(--color-border)]">{{ __('submit.organization_section') }}</h2>
                    <div class="grid md:grid-cols-2 gap-5 mt-5">
                        <x-ui.input wire:model="submitterOrganization" :label="__('submit.organization')" required :error="$errors->first('submitterOrganization')" />
                        <x-ui.input wire:model="organizationWebsite" type="url" :label="__('submit.organization_website')" placeholder="https://" :error="$errors->first('organizationWebsite')" />
                        <div class="md:col-span-2">
                            <label for="counties" class="block text-sm font-medium text-navy mb-1">{{ __('submit.counties') }}</label>
                            <select id="counties" wire:model="counties" multiple required class="w-full rounded-lg border border-[color:var(--color-border)] px-4 py-2 min-h-32">
                                @foreach ($this->countyOptions() as $county)
                                    <option value="{{ $county }}">{{ $county }}</option>
                                @endforeach
                            </select>
                            @error('counties') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <x-ui.input wire:model="submitterName" :label="__('submit.contact_name')" required :error="$errors->first('submitterName')" />
                        <x-ui.input wire:model="submitterEmail" type="email" :label="__('submit.email')" required :error="$errors->first('submitterEmail')" />
                        <x-ui.input wire:model="phone" :label="__('submit.phone')" :error="$errors->first('phone')" />
                    </div>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-navy pb-3 border-b border-[color:var(--color-border)]">{{ __('submit.resource_section') }}</h2>
                    <div class="space-y-5 mt-5">
                        <x-ui.input wire:model="title" :label="__('submit.resource_title')" required :error="$errors->first('title')" />
                        <div class="grid md:grid-cols-2 gap-5">
                            <x-ui.select wire:model="type" :label="__('submit.resource_type')" required :error="$errors->first('type')">
                                <option value="">{{ __('submit.choose_type') }}</option>
                                @foreach (ResourceType::cases() as $resourceType)
                                    <option value="{{ $resourceType->value }}">{{ $resourceType->label() }}</option>
                                @endforeach
                            </x-ui.select>
                            <x-ui.select wire:model="language" :label="__('submit.language')" required :error="$errors->first('language')">
                                <option value="">{{ __('submit.choose_language') }}</option>
                                @foreach ($this->languageOptions() as $languageOption)
                                    <option value="{{ $languageOption }}">{{ __("submit.languages.$languageOption") }}</option>
                                @endforeach
                            </x-ui.select>
                            <x-ui.input wire:model="createdOn" type="date" :label="__('submit.created_on')" required :error="$errors->first('createdOn')" />
                            <x-ui.select wire:model="category" :label="__('submit.category')" required :error="$errors->first('category')">
                                <option value="">{{ __('submit.choose_category') }}</option>
                                @foreach ($this->categoryOptions() as $categoryOption)
                                    <option value="{{ $categoryOption }}">{{ $categoryOption }}</option>
                                @endforeach
                            </x-ui.select>
                        </div>
                        <x-ui.textarea wire:model="description" :label="__('submit.description')" rows="6" required :error="$errors->first('description')" />
                        <x-ui.input wire:model="targetAudience" :label="__('submit.target_audience')" required :error="$errors->first('targetAudience')" />
                        <x-ui.input wire:model="externalUrl" type="url" :label="__('submit.source_url')" placeholder="https://" :error="$errors->first('externalUrl')" />
                        <x-ui.input wire:model="tags" :label="__('submit.tags')" :hint="__('submit.tags_hint')" :error="$errors->first('tags')" />
                        <x-ui.textarea wire:model="authorCredentials" :label="__('submit.author_credentials')" rows="3" :error="$errors->first('authorCredentials')" />
                        <div>
                            <label for="resource-files" class="block text-sm font-medium text-navy mb-1">{{ __('submit.files') }}</label>
                            <input id="resource-files" type="file" wire:model="files" multiple class="block w-full text-sm text-navy">
                            <p class="text-xs text-muted mt-1">{{ __('submit.files_hint') }}</p>
                            @error('files') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            @error('files.*') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <x-ui.textarea wire:model="notes" :label="__('submit.notes')" rows="4" :error="$errors->first('notes')" />
                    </div>
                </section>

                <div class="space-y-3">
                    <label class="flex gap-3 text-sm text-navy"><input type="checkbox" wire:model="rightsConfirmed"> {{ __('submit.rights') }}</label>
                    @error('rightsConfirmed') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    <label class="flex gap-3 text-sm text-navy"><input type="checkbox" wire:model="reviewConfirmed"> {{ __('submit.review') }}</label>
                    @error('reviewConfirmed') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-wrap gap-3">
                    <x-ui.button type="submit">{{ __('submit.button') }}</x-ui.button>
                    <x-ui.button href="{{ localized_route('resources.index') }}" variant="secondary">{{ __('submit.cancel') }}</x-ui.button>
                </div>
            </form>
        </main>
    @endif
</div>
