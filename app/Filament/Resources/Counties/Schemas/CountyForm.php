<?php

namespace App\Filament\Resources\Counties\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CountyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
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
            ]);
    }
}
