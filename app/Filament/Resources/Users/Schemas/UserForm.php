<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\ProfessionalRole;
use App\Enums\UserRole;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->maxLength(255),
                Select::make('role')
                    ->options(UserRole::class)
                    ->required()
                    ->live(),
                TextInput::make('organization')
                    ->maxLength(255)
                    ->visible(fn (Get $get): bool => $get('role') === UserRole::Professional->value),
                Select::make('professional_role')
                    ->options(ProfessionalRole::class)
                    ->visible(fn (Get $get): bool => $get('role') === UserRole::Professional->value),
                DateTimePicker::make('verified_at'),
                Select::make('locale')
                    ->options([
                        'ro' => 'Română',
                        'en' => 'English',
                    ])
                    ->required()
                    ->default('ro'),
            ]);
    }
}
