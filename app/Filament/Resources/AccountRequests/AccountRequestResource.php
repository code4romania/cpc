<?php

namespace App\Filament\Resources\AccountRequests;

use App\Enums\AccountApprovalStatus;
use App\Filament\Concerns\HasTranslatedLabels;
use App\Filament\Resources\AccountRequests\Pages\ListAccountRequests;
use App\Filament\Resources\AccountRequests\Tables\AccountRequestsTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class AccountRequestResource extends Resource
{
    use HasTranslatedLabels;

    protected static ?string $model = User::class;

    protected static ?string $slug = 'account-requests';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserPlus;

    protected static string|UnitEnum|null $navigationGroup = 'Moderation';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return AccountRequestsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('approval_status', AccountApprovalStatus::Pending);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAccountRequests::route('/'),
        ];
    }

    protected static function translationKey(): string
    {
        return 'account_requests';
    }
}
