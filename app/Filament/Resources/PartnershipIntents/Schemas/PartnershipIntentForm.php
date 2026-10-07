<?php

namespace App\Filament\Resources\PartnershipIntents\Schemas;

use App\Enums\PartnershipEntityType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PartnershipIntentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('entity_name')->disabled(),
                Select::make('entity_type')
                    ->options(PartnershipEntityType::options())
                    ->disabled(),
                TextInput::make('activity_domain')->disabled(),
                TextInput::make('contact_name')->disabled(),
                TextInput::make('contact_role')->disabled(),
                TextInput::make('phone')->disabled(),
                TextInput::make('email')->disabled(),
                Textarea::make('intent')->disabled()->columnSpanFull(),
                Toggle::make('personal_data_consent')->disabled(),
            ]);
    }
}
