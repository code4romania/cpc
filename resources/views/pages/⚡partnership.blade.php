<?php

use App\Enums\PartnershipEntityType;
use App\Models\PartnershipIntent;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Partnership')] class extends Component
{
    public string $entityName = '';

    public string $entityType = '';

    public string $activityDomain = '';

    public string $contactName = '';

    public string $contactRole = '';

    public string $phone = '';

    public string $email = '';

    public string $intent = '';

    public bool $personalDataConsent = false;

    public bool $submitted = false;

    public function submit(): void
    {
        $validated = $this->validate([
            'entityName' => ['required', 'string', 'max:255'],
            'entityType' => ['required', Rule::enum(PartnershipEntityType::class)],
            'activityDomain' => ['required', 'string', 'max:255'],
            'contactName' => ['required', 'string', 'max:255'],
            'contactRole' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'intent' => ['required', 'string', 'max:5000'],
            'personalDataConsent' => ['accepted'],
        ]);

        PartnershipIntent::query()->create([
            'entity_name' => $validated['entityName'],
            'entity_type' => $validated['entityType'],
            'activity_domain' => $validated['activityDomain'],
            'contact_name' => $validated['contactName'],
            'contact_role' => $validated['contactRole'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'intent' => $validated['intent'],
            'personal_data_consent' => true,
            'locale' => app()->getLocale(),
        ]);

        $this->reset();
        $this->submitted = true;
    }
};
?>

<div class="min-h-screen bg-background">
    <x-page-header :title="__('partnership.title')" />

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
        <x-ui.card class="p-8 space-y-4 text-navy leading-7">
            @foreach (__('partnership.intro') as $paragraph)
                <p wire:key="intro-{{ $loop->index }}">{{ $paragraph }}</p>
            @endforeach
        </x-ui.card>

        @if ($submitted)
            <x-ui.alert variant="success" :title="__('partnership.success')" />
        @endif

        <form wire:submit="submit" class="space-y-5">
            <x-ui.input id="entity-name" wire:model="entityName" :label="__('partnership.entity_name')" required-mark :error="$errors->first('entityName')" />
            <x-ui.select id="entity-type" wire:model="entityType" :label="__('partnership.entity_type')" :placeholder="__('partnership.entity_type_placeholder')" required-mark :error="$errors->first('entityType')">
                @foreach (PartnershipEntityType::cases() as $type)
                    <option value="{{ $type->value }}">{{ $type->label() }}</option>
                @endforeach
            </x-ui.select>
            <x-ui.input id="activity-domain" wire:model="activityDomain" :label="__('partnership.activity_domain')" required-mark :error="$errors->first('activityDomain')" />
            <x-ui.input id="contact-name" wire:model="contactName" :label="__('partnership.contact_name')" required-mark :error="$errors->first('contactName')" />
            <x-ui.input id="contact-role" wire:model="contactRole" :label="__('partnership.contact_role')" required-mark :error="$errors->first('contactRole')" />
            <div class="grid gap-5 sm:grid-cols-2">
                <x-ui.input id="phone" wire:model="phone" :label="__('partnership.phone')" required-mark :error="$errors->first('phone')" />
                <x-ui.input id="email" type="email" wire:model="email" :label="__('partnership.email')" required-mark :error="$errors->first('email')" />
            </div>
            <x-ui.textarea id="intent" wire:model="intent" :label="__('partnership.intent')" :placeholder="__('partnership.intent_placeholder')" required-mark rows="6" :error="$errors->first('intent')" />

            <label class="flex items-start gap-3 rounded-lg border border-[color:var(--color-border)] bg-white p-4">
                <input type="checkbox" wire:model="personalDataConsent" class="mt-1 rounded border-[color:var(--color-border)] text-primary focus:ring-accent">
                <span class="text-sm text-navy">{{ __('partnership.consent') }}</span>
            </label>
            @error('personalDataConsent')
                <p class="text-sm text-destructive">{{ $message }}</p>
            @enderror

            <x-ui.button type="submit">{{ __('partnership.submit') }}</x-ui.button>
        </form>
    </main>
</div>
