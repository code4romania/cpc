<?php

namespace App\Filament\Resources\StaticPages;

use App\Filament\Concerns\HasTranslatedLabels;
use App\Filament\Resources\StaticPages\Pages\CreateStaticPage;
use App\Filament\Resources\StaticPages\Pages\EditStaticPage;
use App\Filament\Resources\StaticPages\Pages\ListStaticPages;
use App\Filament\Resources\StaticPages\Schemas\StaticPageForm;
use App\Filament\Resources\StaticPages\Tables\StaticPagesTable;
use App\Models\StaticPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StaticPageResource extends Resource
{
    use HasTranslatedLabels;

    protected static ?string $model = StaticPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    public static function form(Schema $schema): Schema
    {
        return StaticPageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StaticPagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStaticPages::route('/'),
            'create' => CreateStaticPage::route('/create'),
            'edit' => EditStaticPage::route('/{record}/edit'),
        ];
    }

    protected static function translationKey(): string
    {
        return 'static_pages';
    }
}
