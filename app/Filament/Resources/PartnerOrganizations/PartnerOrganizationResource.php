<?php

namespace App\Filament\Resources\PartnerOrganizations;

use App\Filament\Resources\PartnerOrganizations\Pages\CreatePartnerOrganization;
use App\Filament\Resources\PartnerOrganizations\Pages\EditPartnerOrganization;
use App\Filament\Resources\PartnerOrganizations\Pages\ListPartnerOrganizations;
use App\Filament\Resources\PartnerOrganizations\Schemas\PartnerOrganizationForm;
use App\Filament\Resources\PartnerOrganizations\Tables\PartnerOrganizationsTable;
use App\Models\PartnerOrganization;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PartnerOrganizationResource extends Resource
{
    protected static ?string $model = PartnerOrganization::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Directory';

    public static function form(Schema $schema): Schema
    {
        return PartnerOrganizationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PartnerOrganizationsTable::configure($table);
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
            'index' => ListPartnerOrganizations::route('/'),
            'create' => CreatePartnerOrganization::route('/create'),
            'edit' => EditPartnerOrganization::route('/{record}/edit'),
        ];
    }
}
