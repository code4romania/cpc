<?php

namespace App\Filament\Resources\Consultations\Schemas;

use App\Enums\ConsultationStatus;
use App\Enums\ConsultationUrgency;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ConsultationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('subject')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Select::make('urgency')
                    ->options(ConsultationUrgency::class)
                    ->default('medium')
                    ->required(),
                Select::make('status')
                    ->options(ConsultationStatus::class)
                    ->default('open')
                    ->required(),
                TextInput::make('category'),
                Select::make('assigned_to')
                    ->relationship('assignedTo', 'name')
                    ->searchable()
                    ->preload(),
            ]);
    }
}
