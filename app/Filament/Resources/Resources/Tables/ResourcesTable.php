<?php

namespace App\Filament\Resources\Resources\Tables;

use App\Enums\ResourceStatus;
use App\Enums\ResourceType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ResourcesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('title_ro')
                    ->searchable(),
                TextColumn::make('title_en')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (ResourceType $state): string => $state->label())
                    ->searchable(),
                TextColumn::make('resourceCategory.name_ro')
                    ->label(__('admin.fields.category'))
                    ->searchable(),
                TextColumn::make('author')
                    ->searchable(),
                TextColumn::make('download_url')
                    ->searchable(),
                TextColumn::make('video_url')
                    ->searchable(),
                IconColumn::make('featured')
                    ->boolean(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (ResourceStatus $state): string => $state->label())
                    ->searchable(),
                TextColumn::make('published_at')
                    ->dateTime()
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
                SelectFilter::make('type')
                    ->options(ResourceType::options()),
                SelectFilter::make('status')
                    ->options(ResourceStatus::options()),
                SelectFilter::make('resource_category_id')
                    ->relationship('resourceCategory', 'name_ro')
                    ->searchable()
                    ->preload(),
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
