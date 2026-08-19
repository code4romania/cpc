<?php

namespace App\Filament\Resources\StatisticDatasets\Schemas;

use App\Enums\ChartType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class StatisticDatasetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Select::make('chart_type')
                    ->options(ChartType::options())
                    ->required(),
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('Română')->schema([
                            TextInput::make('title_ro')->required(),
                            Textarea::make('description_ro'),
                            Textarea::make('narrative_ro'),
                        ]),
                        Tab::make('English')->schema([
                            TextInput::make('title_en')->required(),
                            Textarea::make('description_en'),
                            Textarea::make('narrative_en'),
                        ]),
                    ])
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->required(),
                DateTimePicker::make('published_at'),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
