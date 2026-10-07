<?php

namespace App\Filament\Resources\Resources\Schemas;

use App\Enums\ResourceAccess;
use App\Enums\ResourceStatus;
use App\Enums\ResourceType;
use App\Filament\Support\LimitedFileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ResourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('Română')
                            ->schema([
                                TextInput::make('title_ro')->required(),
                                Textarea::make('description_ro')->required(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                TextInput::make('title_en')->required(),
                                Textarea::make('description_en')->required(),
                            ]),
                    ])
                    ->columnSpanFull(),
                Select::make('type')
                    ->options(ResourceType::options())
                    ->required(),
                Select::make('access_levels')
                    ->label(__('admin.fields.access_levels'))
                    ->options(ResourceAccess::options())
                    ->multiple()
                    ->required()
                    ->default([ResourceAccess::Public->value]),
                Select::make('resource_category_id')
                    ->relationship('resourceCategory', 'name_ro')
                    ->searchable()
                    ->preload()
                    ->required(),
                TagsInput::make('tags'),
                TextInput::make('author'),
                TextInput::make('download_url')
                    ->url(),
                TextInput::make('video_url')
                    ->url(),
                LimitedFileUpload::configure(
                    SpatieMediaLibraryFileUpload::make('file')->collection('file'),
                    50,
                ),
                Toggle::make('featured'),
                Select::make('status')
                    ->options(ResourceStatus::options())
                    ->default('draft')
                    ->required(),
                DateTimePicker::make('published_at'),
            ]);
    }
}
