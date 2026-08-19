<?php

namespace App\Filament\Resources\Professionals\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ProfessionalForm
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
                            TextInput::make('title_ro')->required(),
                            Textarea::make('description_ro')->required(),
                        ]),
                        Tab::make('English')->schema([
                            TextInput::make('title_en')->required(),
                            Textarea::make('description_en')->required(),
                        ]),
                    ])
                    ->columnSpanFull(),
                TextInput::make('category')->required(),
                TextInput::make('type')->required(),
                FileUpload::make('file_path')
                    ->directory('professional-resources')
                    ->visibility('public'),
                TextInput::make('file_size')->numeric(),
                Toggle::make('is_published'),
                DateTimePicker::make('last_updated_at'),
            ]);
    }
}
