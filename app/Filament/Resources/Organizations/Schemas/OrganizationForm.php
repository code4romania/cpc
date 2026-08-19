<?php

namespace App\Filament\Resources\Organizations\Schemas;

use App\Enums\OrganizationType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class OrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
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
                TextInput::make('city')
                    ->required(),
                Select::make('county_id')
                    ->relationship('county', 'name_ro')
                    ->searchable()
                    ->preload(),
                Select::make('organization_type')
                    ->options(OrganizationType::class)
                    ->required(),
                TagsInput::make('services'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('website')
                    ->url(),
                TextInput::make('hours'),
                TextInput::make('address'),
                Toggle::make('is_published')
                    ->required(),
            ]);
    }
}
