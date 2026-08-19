<?php

use App\Enums\ResourceType;
use App\Enums\SubmissionStatus;
use App\Models\ResourceSubmission;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Submit Resource')] class extends Component
{
    public string $title = '';

    public string $description = '';

    public string $type = '';

    public string $category = '';

    public string $submitterName = '';

    public string $submitterEmail = '';

    public string $submitterOrganization = '';

    public string $externalUrl = '';

    public bool $rightsConfirmed = false;

    public bool $reviewConfirmed = false;

    public bool $submitted = false;

    public function submit(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'type' => ['required', Rule::enum(ResourceType::class)],
            'category' => ['nullable', 'string', 'max:255'],
            'submitterName' => ['required', 'string', 'max:255'],
            'submitterEmail' => ['required', 'email', 'max:255'],
            'submitterOrganization' => ['nullable', 'string', 'max:255'],
            'externalUrl' => ['nullable', 'url', 'max:2048'],
            'rightsConfirmed' => ['accepted'],
            'reviewConfirmed' => ['accepted'],
        ]);

        ResourceSubmission::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'category' => $validated['category'],
            'submitter_name' => $validated['submitterName'],
            'submitter_email' => $validated['submitterEmail'],
            'submitter_organization' => $validated['submitterOrganization'],
            'external_url' => $validated['externalUrl'],
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
            <x-ui.alert class="mb-8" :title="__('submit.guidelines_title')">{{ __('submit.guidelines') }}</x-ui.alert>

            <form wire:submit="submit" class="bg-white rounded-xl border border-[color:var(--color-border)] p-8 space-y-8">
                <section>
                    <h2 class="text-xl font-bold text-navy pb-3 border-b border-[color:var(--color-border)]">{{ __('submit.organization_section') }}</h2>
                    <div class="grid md:grid-cols-2 gap-5 mt-5">
                        <x-ui.input wire:model="submitterName" :label="__('submit.contact_name')" required :error="$errors->first('submitterName')" />
                        <x-ui.input wire:model="submitterEmail" type="email" :label="__('submit.email')" required :error="$errors->first('submitterEmail')" />
                        <x-ui.input wire:model="submitterOrganization" :label="__('submit.organization')" :error="$errors->first('submitterOrganization')" />
                        <x-ui.input wire:model="externalUrl" type="url" :label="__('submit.source_url')" placeholder="https://" :error="$errors->first('externalUrl')" />
                    </div>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-navy pb-3 border-b border-[color:var(--color-border)]">{{ __('submit.resource_section') }}</h2>
                    <div class="space-y-5 mt-5">
                        <x-ui.input wire:model="title" :label="__('submit.resource_title')" required :error="$errors->first('title')" />
                        <div class="grid md:grid-cols-2 gap-5">
                            <x-ui.select wire:model="type" :label="__('submit.resource_type')" required :error="$errors->first('type')">
                                <option value="">{{ __('submit.choose') }}</option>
                                @foreach (ResourceType::cases() as $resourceType)
                                    <option value="{{ $resourceType->value }}">{{ $resourceType->label() }}</option>
                                @endforeach
                            </x-ui.select>
                            <x-ui.input wire:model="category" :label="__('submit.category')" :error="$errors->first('category')" />
                        </div>
                        <x-ui.textarea wire:model="description" :label="__('submit.description')" rows="6" required :error="$errors->first('description')" />
                    </div>
                </section>

                <div class="space-y-3">
                    <label class="flex gap-3 text-sm text-navy"><input type="checkbox" wire:model="rightsConfirmed"> {{ __('submit.rights') }}</label>
                    @error('rightsConfirmed') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    <label class="flex gap-3 text-sm text-navy"><input type="checkbox" wire:model="reviewConfirmed"> {{ __('submit.review') }}</label>
                    @error('reviewConfirmed') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <x-ui.button type="submit">{{ __('submit.button') }}</x-ui.button>
            </form>
        </main>
    @endif
</div>
