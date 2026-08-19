<?php

namespace App\Filament\Resources\Organizations\Tables;

use App\Enums\OrganizationType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class OrganizationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('city')
                    ->searchable(),
                TextColumn::make('county.name_ro')
                    ->label('County')
                    ->searchable(),
                TextColumn::make('organization_type')
                    ->badge()
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('website')
                    ->searchable(),
                TextColumn::make('hours')
                    ->searchable(),
                TextColumn::make('address')
                    ->searchable(),
                IconColumn::make('is_published')
                    ->boolean(),
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
                SelectFilter::make('county_id')
                    ->relationship('county', 'name_ro')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('organization_type')
                    ->options(OrganizationType::class),
                TernaryFilter::make('is_published'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
