<?php

namespace App\Filament\Resources\PartnershipIntents\Tables;

use App\Enums\PartnershipEntityType;
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
            ->defaultSort('created_at', 'desc');
    }
}
