<?php

namespace App\Filament\Resources\ResourceCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ResourceCategoryForm
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
                        Tab::make('Română')->schema([
                            TextInput::make('name_ro')->required(),
                        ]),
                        Tab::make('English')->schema([
                            TextInput::make('name_en')->required(),
                        ]),
                    ])
                    ->columnSpanFull(),
                TextInput::make('color_bg'),
                TextInput::make('color_text'),
                TextInput::make('color_border'),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
