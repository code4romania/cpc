<?php

namespace App\Filament\Resources\ResourceSubmissions\Schemas;

use App\Enums\ResourceType;
use App\Enums\SubmissionStatus;
use App\Models\ResourceSubmission;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class ResourceSubmissionInfolist
{
    /**
     * @return array<int, Tabs>
     */
    public static function schema(): array
    {
        return [
            Tabs::make('Submission')
                ->tabs([
                    Tab::make(__('admin.tabs.response'))
                        ->schema([
                            TextEntry::make('title')->label(__('submit.resource_title')),
                            TextEntry::make('type')
                                ->label(__('submit.resource_type'))
                                ->formatStateUsing(fn (ResourceType $state): string => $state->label()),
                            TextEntry::make('category')->label(__('submit.category')),
                            TextEntry::make('language')
                                ->label(__('submit.language'))
                                ->formatStateUsing(fn (?string $state): string => filled($state) ? __('submit.languages.'.$state) : '—'),
                            TextEntry::make('description')->label(__('submit.description'))->columnSpanFull(),
                            TextEntry::make('submitter_name')->label(__('submit.contact_name')),
                            TextEntry::make('submitter_email')->label(__('submit.email')),
                            TextEntry::make('submitter_organization')->label(__('submit.organization')),
                            TextEntry::make('organization_website')->label(__('submit.organization_website')),
                            TextEntry::make('phone')->label(__('submit.phone')),
                            TextEntry::make('counties')
                                ->label(__('submit.counties'))
                                ->state(fn (ResourceSubmission $record): string => implode(', ', $record->counties ?? []) ?: '—'),
                            TextEntry::make('created_on')->label(__('submit.created_on'))->date(),
                            TextEntry::make('target_audience')->label(__('submit.target_audience')),
                            TextEntry::make('tags')
                                ->label(__('submit.tags'))
                                ->state(fn (ResourceSubmission $record): string => implode(', ', $record->tags ?? []) ?: '—'),
                            TextEntry::make('author_credentials')->label(__('submit.author_credentials'))->columnSpanFull(),
                            TextEntry::make('notes')->label(__('submit.notes'))->columnSpanFull(),
                            TextEntry::make('external_url')->label(__('submit.source_url')),
                            ViewEntry::make('file_paths')
                                ->label(__('submit.files'))
                                ->view('filament.infolists.submission-files')
                                ->columnSpanFull(),
                        ]),
                    Tab::make(__('admin.tabs.review'))
                        ->schema([
                            TextEntry::make('status')
                                ->formatStateUsing(fn (SubmissionStatus $state): string => $state->label()),
                            TextEntry::make('rejection_reason')->columnSpanFull(),
                            TextEntry::make('reviewedBy.name')->label(__('admin.fields.reviewed_by')),
                            TextEntry::make('reviewed_at')->dateTime(),
                            TextEntry::make('resource.title_ro')->label(__('admin.fields.resource')),
                        ]),
                ])
                ->columnSpanFull(),
        ];
    }
}
