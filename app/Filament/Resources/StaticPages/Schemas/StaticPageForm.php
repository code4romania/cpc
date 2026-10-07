<?php

namespace App\Filament\Resources\StaticPages\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class StaticPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated(false),
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('Română')->schema([
                            TextInput::make('title_ro')->required(),
                            RichEditor::make('body_ro')
                                ->required()
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsDirectory('static-pages')
                                ->helperText(__('admin.resources.static_pages.blocks_hint')),
                        ]),
                        Tab::make('English')->schema([
                            TextInput::make('title_en')->required(),
                            RichEditor::make('body_en')
                                ->required()
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsDirectory('static-pages')
                                ->helperText(__('admin.resources.static_pages.blocks_hint')),
                        ]),
                    ])
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->required(),
            ]);
    }
}
