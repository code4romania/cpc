<?php

namespace App\Filament\Resources\StatisticDatasets;

use App\Filament\Concerns\HasTranslatedLabels;
use App\Filament\Resources\StatisticDatasets\Pages\CreateStatisticDataset;
use App\Filament\Resources\StatisticDatasets\Pages\EditStatisticDataset;
use App\Filament\Resources\StatisticDatasets\Pages\ListStatisticDatasets;
use App\Filament\Resources\StatisticDatasets\RelationManagers\DataPointsRelationManager;
use App\Filament\Resources\StatisticDatasets\Schemas\StatisticDatasetForm;
use App\Filament\Resources\StatisticDatasets\Tables\StatisticDatasetsTable;
use App\Models\StatisticDataset;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StatisticDatasetResource extends Resource
{
    use HasTranslatedLabels;

    protected static ?string $model = StatisticDataset::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Statistics';

    public static function form(Schema $schema): Schema
    {
        return StatisticDatasetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StatisticDatasetsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            DataPointsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStatisticDatasets::route('/'),
            'create' => CreateStatisticDataset::route('/create'),
            'edit' => EditStatisticDataset::route('/{record}/edit'),
        ];
    }

    protected static function translationKey(): string
    {
        return 'statistic_datasets';
    }
}
