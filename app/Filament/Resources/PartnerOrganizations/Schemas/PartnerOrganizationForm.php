<?php

namespace App\Filament\Resources\PartnerOrganizations\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PartnerOrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                FileUpload::make('logo_path')
                    ->image()
                    ->directory('partners')
                    ->visibility('public'),
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('Română')->schema([
                            Textarea::make('description_ro'),
                        ]),
                        Tab::make('English')->schema([
                            Textarea::make('description_en'),
                        ]),
                    ])
                    ->columnSpanFull(),
                TextInput::make('url')
                    ->url(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_published')
                    ->required(),
            ]);
    }
}
