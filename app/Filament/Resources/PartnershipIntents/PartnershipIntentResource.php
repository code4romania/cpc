<?php

namespace App\Filament\Resources\PartnershipIntents;

use App\Filament\Concerns\HasTranslatedLabels;
use App\Filament\Resources\PartnershipIntents\Pages\ListPartnershipIntents;
use App\Filament\Resources\PartnershipIntents\Schemas\PartnershipIntentForm;
use App\Filament\Resources\PartnershipIntents\Tables\PartnershipIntentsTable;
use App\Models\PartnershipIntent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PartnershipIntentResource extends Resource
{
    use HasTranslatedLabels;

    protected static ?string $model = PartnershipIntent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Moderation';

    public static function form(Schema $schema): Schema
    {
        return PartnershipIntentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PartnershipIntentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPartnershipIntents::route('/'),
        ];
    }

    protected static function translationKey(): string
    {
        return 'partnership_intents';
    }
}
