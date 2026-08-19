<?php

namespace App\Filament\Resources\ResourceSubmissions\Schemas;

use App\Enums\ResourceType;
use App\Enums\SubmissionStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ResourceSubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Select::make('type')
                    ->options(ResourceType::class)
                    ->required(),
                TextInput::make('category'),
                TextInput::make('submitter_name')
                    ->required(),
                TextInput::make('submitter_email')
                    ->email()
                    ->required(),
                TextInput::make('submitter_organization'),
                TextInput::make('file_path'),
                TextInput::make('external_url')
                    ->url(),
                TextInput::make('locale')
                    ->required()
                    ->default('ro'),
                Select::make('status')
                    ->options(SubmissionStatus::class)
                    ->default('pending')
                    ->required(),
                Textarea::make('rejection_reason')
                    ->columnSpanFull(),
                TextInput::make('reviewed_by')
                    ->numeric(),
                DateTimePicker::make('reviewed_at'),
                Select::make('resource_id')
                    ->relationship('resource', 'id'),
            ]);
    }
}
