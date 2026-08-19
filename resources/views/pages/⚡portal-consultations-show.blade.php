<?php

use App\Models\Consultation;
use App\Models\ConsultationMessage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app')] #[Title('Consultation')] class extends Component
{
    public Consultation $consultation;

    public string $message = '';

    public function mount(Consultation $consultation): void
    {
        abort_unless($consultation->user_id === auth()->id(), 404);
        $this->consultation = $consultation;
    }

    public function sendMessage(): void
    {
        abort_unless($this->consultation->user_id === auth()->id(), 404);
        $validated = $this->validate(['message' => ['required', 'string', 'max:5000']]);

        ConsultationMessage::create([
            'consultation_id' => $this->consultation->id,
            'user_id' => auth()->id(),
            'body' => $validated['message'],
            'is_expert' => false,
        ]);

        $this->consultation->touch();
        $this->reset('message');
    }
};
?>

<div class="min-h-screen bg-background">
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ localized_route('portal.consultations.index') }}" class="text-primary">← {{ __('consultations.back') }}</a>
        <header class="my-7 flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-navy">{{ $consultation->subject }}</h1>
                <p class="text-muted mt-2">{{ $consultation->category }} · #{{ $consultation->id }}</p>
            </div>
            <div class="flex gap-2"><x-ui.badge variant="accent">{{ $consultation->status->label() }}</x-ui.badge><x-ui.badge>{{ $consultation->urgency->label() }}</x-ui.badge></div>
        </header>

        <div class="grid lg:grid-cols-3 gap-8">
            <section class="lg:col-span-2">
                <x-ui.card>
                    <div class="p-6 border-b border-[color:var(--color-border)]">
                        <h2 class="text-xl font-bold text-navy">{{ __('consultations.thread') }}</h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="rounded-lg bg-tint-blue p-4">
                            <p class="text-xs text-muted mb-2">{{ auth()->user()->name }} · {{ $consultation->created_at->diffForHumans() }}</p>
                            <p class="text-navy whitespace-pre-line">{{ $consultation->description }}</p>
                        </div>
                        @foreach ($consultation->messages()->with('user')->oldest()->get() as $threadMessage)
                            <div wire:key="message-{{ $threadMessage->id }}" class="rounded-lg {{ $threadMessage->is_expert ? 'bg-tint-purple' : 'bg-tint-blue' }} p-4">
                                <p class="text-xs text-muted mb-2">{{ $threadMessage->user->name }} · {{ $threadMessage->created_at->diffForHumans() }}</p>
                                <p class="text-navy whitespace-pre-line">{{ $threadMessage->body }}</p>
                            </div>
                        @endforeach
                    </div>
                    <form wire:submit="sendMessage" class="p-6 border-t border-[color:var(--color-border)]">
                        <x-ui.textarea wire:model="message" :label="__('consultations.add_message')" rows="4" :error="$errors->first('message')" />
                        <x-ui.button type="submit" class="mt-4">{{ __('consultations.send') }}</x-ui.button>
                    </form>
                </x-ui.card>
            </section>
            <aside>
                <x-ui.card class="p-6">
                    <h2 class="font-semibold text-navy">{{ __('consultations.case_info') }}</h2>
                    <dl class="mt-4 space-y-4 text-sm">
                        <div><dt class="text-muted">{{ __('consultations.created') }}</dt><dd class="text-navy">{{ $consultation->created_at->translatedFormat('j F Y') }}</dd></div>
                        <div><dt class="text-muted">{{ __('consultations.status') }}</dt><dd class="text-navy">{{ $consultation->status->label() }}</dd></div>
                    </dl>
                </x-ui.card>
            </aside>
        </div>
    </main>
</div>
