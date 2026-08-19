<?php

namespace App\Filament\Resources\ResourceSubmissions;

use App\Filament\Resources\ResourceSubmissions\Pages\ListResourceSubmissions;
use App\Filament\Resources\ResourceSubmissions\Schemas\ResourceSubmissionForm;
use App\Filament\Resources\ResourceSubmissions\Tables\ResourceSubmissionsTable;
use App\Models\ResourceSubmission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ResourceSubmissionResource extends Resource
{
    protected static ?string $model = ResourceSubmission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Moderation';

    public static function form(Schema $schema): Schema
    {
        return ResourceSubmissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ResourceSubmissionsTable::configure($table);
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
            'index' => ListResourceSubmissions::route('/'),
        ];
    }
}
