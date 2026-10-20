<?php

namespace App\Filament\Resources\PartnershipIntents\Tables;

use App\Enums\PartnershipEntityType;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PartnershipIntentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('entity_name')->searchable(),
                TextColumn::make('entity_type')
                    ->formatStateUsing(fn (PartnershipEntityType $state): string => $state->label()),
                TextColumn::make('contact_name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('intent')->limit(80)->wrap(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make()
                    ->schema([
                        TextEntry::make('entity_name'),
                        TextEntry::make('entity_type')
                            ->formatStateUsing(fn (PartnershipEntityType $state): string => $state->label()),
                        TextEntry::make('activity_domain'),
                        TextEntry::make('contact_name'),
                        TextEntry::make('contact_role'),
                        TextEntry::make('phone'),
                        TextEntry::make('email'),
                        TextEntry::make('intent')->columnSpanFull(),
                        IconEntry::make('personal_data_consent')->boolean(),
                        TextEntry::make('locale'),
                        TextEntry::make('created_at')->dateTime(),
                    ]),
            ]);
    }
}
