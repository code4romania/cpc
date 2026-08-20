<?php

namespace App\Filament\Resources\ResourceSubmissions\Tables;

use App\Actions\ApproveResourceSubmission;
use App\Enums\ResourceType;
use App\Enums\SubmissionStatus;
use App\Models\ResourceSubmission;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ResourceSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (ResourceType $state): string => $state->label())
                    ->searchable(),
                TextColumn::make('category')
                    ->searchable(),
                TextColumn::make('submitter_name')
                    ->searchable(),
                TextColumn::make('submitter_email')
                    ->searchable(),
                TextColumn::make('submitter_organization')
                    ->searchable(),
                TextColumn::make('external_url')
                    ->searchable(),
                TextColumn::make('locale')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (SubmissionStatus $state): string => $state->label())
                    ->searchable(),
                TextColumn::make('reviewedBy.name')
                    ->label(__('admin.fields.reviewed_by'))
                    ->sortable(),
                TextColumn::make('reviewed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('resource.title_ro')
                    ->label(__('admin.fields.resource'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(SubmissionStatus::options()),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (ResourceSubmission $record): bool => $record->getRawOriginal('status') === SubmissionStatus::Pending->value)
                    ->requiresConfirmation()
                    ->action(function (ResourceSubmission $record, ApproveResourceSubmission $approve): void {
                        /** @var User $reviewer */
                        $reviewer = Filament::auth()->user();
                        $approve($record, $reviewer);

                        Notification::make()
                            ->title(__('admin.notifications.submission_approved'))
                            ->success()
                            ->send();
                    }),
                Action::make('reject')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn (ResourceSubmission $record): bool => $record->getRawOriginal('status') === SubmissionStatus::Pending->value)
                    ->schema([
                        Textarea::make('rejection_reason')
                            ->required()
                            ->maxLength(2000),
                    ])
                    ->action(function (ResourceSubmission $record, array $data): void {
                        /** @var User $reviewer */
                        $reviewer = Filament::auth()->user();
                        $record->update([
                            'status' => SubmissionStatus::Rejected,
                            'rejection_reason' => $data['rejection_reason'],
                            'reviewed_by' => $reviewer->getKey(),
                            'reviewed_at' => now(),
                        ]);

                        Notification::make()
                            ->title(__('admin.notifications.submission_rejected'))
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
