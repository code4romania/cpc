<?php

use App\Enums\OrganizationType;
use App\Models\County;
use App\Models\Organization;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.app')] #[Title('Organizations')] class extends Component
{
    use WithPagination;

    public string $search = '';

    public array $counties = [];

    public array $services = [];

    public array $types = [];

    public function updated(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'counties', 'services', 'types']);
    }

    /** @return array<int, string> */
    public function countyOptions(): array
    {
        $column = $this->countyNameColumn();

        return County::query()->orderBy($column)->pluck($column)->all();
    }

    protected function countyNameColumn(): string
    {
        $locale = app()->getLocale();

        return in_array($locale, ['ro', 'en'], true) ? "name_{$locale}" : 'name_ro';
    }

    /** @return array<int, string> */
    public function serviceOptions(): array
    {
        return Organization::published()->pluck('services')->flatten()->filter()->unique()->sort()->values()->all();
    }

    /** @return array<int, string> */
    public function typeOptions(): array
    {
        return collect(OrganizationType::cases())->map(fn (OrganizationType $type): string => $type->value)->all();
    }

    public function organizations(): LengthAwarePaginator
    {
        return Organization::published()
            ->with('county')
            ->when($this->search, function ($query): void {
                $query->where(function ($query): void {
                    $query->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('description_ro', 'like', '%'.$this->search.'%')
                        ->orWhere('description_en', 'like', '%'.$this->search.'%')
                        ->orWhere('city', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->counties, function ($query): void {
                $column = $this->countyNameColumn();

                $query->whereHas(
                    'county',
                    fn ($query) => $query->whereIn($column, $this->counties),
                );
            })
            ->when($this->services, function ($query): void {
                $query->where(function ($query): void {
                    foreach ($this->services as $service) {
                        $query->orWhereJsonContains('services', $service);
                    }
                });
            })
            ->when($this->types, fn ($query) => $query->whereIn('organization_type', $this->types))
            ->orderBy('name')
            ->paginate(10);
    }
};
?>

<div class="min-h-screen bg-background">
    <x-page-header :title="__('organizations.title')" :subtitle="__('organizations.subtitle')" />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <x-ui.alert variant="emergency" class="mb-8">{{ __('organizations.emergency') }} <strong>119</strong>.</x-ui.alert>

        <section class="bg-white rounded-xl border border-[color:var(--color-border)] p-6 mb-8">
            <label for="organization-search" class="block text-sm font-medium text-navy mb-2">{{ __('organizations.search_label') }}</label>
            <input id="organization-search" type="search" wire:model.live.debounce.300ms="search" placeholder="{{ __('organizations.search_placeholder') }}"
                   class="w-full rounded-lg border border-[color:var(--color-border)] px-4 py-3 focus:border-accent focus:ring-accent">
            <div class="grid md:grid-cols-3 gap-6 mt-6">
                <livewire:multi-select-filter wire:model.live="counties" :options="$this->countyOptions()" :label="__('organizations.county')" :placeholder="__('organizations.all_counties')" />
                <livewire:multi-select-filter wire:model.live="services" :options="$this->serviceOptions()" :label="__('organizations.service')" :placeholder="__('organizations.all_services')" />
                <livewire:multi-select-filter wire:model.live="types" :options="$this->typeOptions()" :label="__('organizations.type')" :placeholder="__('organizations.all_types')" />
            </div>
            @if ($search !== '' || $counties || $services || $types)
                <button wire:click="clearFilters" class="mt-5 text-sm font-semibold text-primary">{{ __('organizations.clear_all') }}</button>
            @endif
        </section>

        @php($organizations = $this->organizations())
        <p class="text-muted mb-6">{{ __('organizations.showing', ['count' => $organizations->total()]) }}</p>
        <div class="grid md:grid-cols-2 gap-6">
            @forelse ($organizations as $organization)
                <x-organization-card
                    wire:key="organization-{{ $organization->id }}"
                    :name="$organization->name"
                    :description="$organization->description"
                    :address="$organization->address"
                    :city="$organization->city"
                    :state="$organization->county?->name"
                    :phone="$organization->phone"
                    :email="$organization->email"
                    :website="$organization->website"
                    :hours="$organization->hours"
                    :services="$organization->services ?? []"
                    :organization-type="$organization->organization_type?->value"
                />
            @empty
                <x-ui.card class="md:col-span-2 p-12 text-center">{{ __('organizations.none') }}</x-ui.card>
            @endforelse
        </div>
        <div class="mt-8">{{ $organizations->links() }}</div>
    </main>
</div>
