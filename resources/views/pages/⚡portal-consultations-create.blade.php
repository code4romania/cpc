<?php

use App\Enums\ConsultationStatus;
use App\Enums\ConsultationUrgency;
use App\Models\Consultation;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('New Consultation')] class extends Component
{
    public string $category = '';

    public string $urgency = '';

    public string $subject = '';

    public string $description = '';

    public string $questions = '';

    public bool $anonymized = false;

    public function submit(): void
    {
        $validated = $this->validate([
            'category' => ['required', 'string', 'max:255'],
            'urgency' => ['required', Rule::enum(ConsultationUrgency::class)],
            'subject' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'max:10000'],
            'questions' => ['required', 'string', 'max:5000'],
            'anonymized' => ['accepted'],
        ]);

        $consultation = Consultation::create([
            'user_id' => auth()->id(),
            'subject' => $validated['subject'],
            'description' => $validated['description']."\n\n".__('consultations.questions').":\n".$validated['questions'],
            'urgency' => $validated['urgency'],
            'status' => ConsultationStatus::Open,
            'category' => $validated['category'],
        ]);

        $this->redirect(localized_route('portal.consultations.show', ['consultation' => $consultation]), navigate: true);
    }
};
?>

<div class="min-h-screen bg-background">
    <x-page-header :title="__('consultations.create_title')" :subtitle="__('consultations.create_subtitle')" />
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <x-ui.alert variant="emergency" class="mb-8" :title="__('consultations.security_title')">{{ __('consultations.security_body') }}</x-ui.alert>
        <form wire:submit="submit" class="bg-white rounded-xl border border-[color:var(--color-border)] p-8 space-y-6">
            <div class="grid md:grid-cols-2 gap-5">
                <x-ui.select wire:model="category" :label="__('consultations.case_type')" required :error="$errors->first('category')">
                    <option value="">{{ __('submit.choose') }}</option>
                    @foreach (['suspected_trafficking', 'confirmed_case', 'risk_assessment', 'intervention_planning', 'legal_guidance', 'other'] as $option)
                        <option value="{{ $option }}">{{ __("consultations.categories.$option") }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.select wire:model="urgency" :label="__('consultations.urgency')" required :error="$errors->first('urgency')">
                    <option value="">{{ __('submit.choose') }}</option>
                    @foreach (ConsultationUrgency::cases() as $option)
                        <option value="{{ $option->value }}">{{ $option->label() }}</option>
                    @endforeach
                </x-ui.select>
            </div>
            <x-ui.input wire:model="subject" :label="__('consultations.subject')" required :error="$errors->first('subject')" />
            <x-ui.textarea wire:model="description" :label="__('consultations.description')" rows="7" required :error="$errors->first('description')" />
            <x-ui.textarea wire:model="questions" :label="__('consultations.questions')" rows="5" required :error="$errors->first('questions')" />
            <label class="flex items-start gap-3 text-sm text-navy">
                <input type="checkbox" wire:model="anonymized" class="mt-1">
                <span>{{ __('consultations.anonymized') }}</span>
            </label>
            @error('anonymized') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            <x-ui.button type="submit">{{ __('consultations.submit') }}</x-ui.button>
        </form>
    </main>
</div>
