<?php

namespace App\Filament\Resources\Consultations\Tables;

use App\Enums\ConsultationStatus;
use App\Enums\ConsultationUrgency;
use App\Models\Consultation;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ConsultationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('subject')
                    ->searchable(),
                TextColumn::make('urgency')
                    ->badge()
                    ->formatStateUsing(fn (ConsultationUrgency $state): string => $state->label())
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (ConsultationStatus $state): string => $state->label())
                    ->searchable(),
                TextColumn::make('category')
                    ->searchable(),
                TextColumn::make('assignedTo.name')
                    ->label(__('admin.fields.assigned_to'))
                    ->sortable(),
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
                    ->options(ConsultationStatus::options()),
                SelectFilter::make('urgency')
                    ->options(ConsultationUrgency::options()),
            ])
            ->recordActions([
                Action::make('assign')
                    ->icon('heroicon-o-user-plus')
                    ->schema([
                        Select::make('assigned_to')
                            ->relationship('assignedTo', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->fillForm(fn (Consultation $record): array => [
                        'assigned_to' => $record->assigned_to,
                    ])
                    ->action(function (Consultation $record, array $data): void {
                        $record->update([
                            'assigned_to' => $data['assigned_to'],
                            'status' => ConsultationStatus::InProgress,
                        ]);

                        Notification::make()
                            ->title(__('admin.notifications.consultation_assigned'))
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
