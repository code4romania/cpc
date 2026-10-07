<?php

namespace App\Filament\Resources\AccountRequests\Tables;

use App\Actions\ApproveAccountRequest;
use App\Enums\UserRole;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AccountRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('organization')->searchable(),
                TextColumn::make('reference_phone'),
                TextColumn::make('role')
                    ->formatStateUsing(function (UserRole|string $state): string {
                        $role = $state instanceof UserRole ? $state : UserRole::from($state);

                        return $role->label();
                    }),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label(__('admin.fields.approve'))
                    ->action(fn (User $record) => app(ApproveAccountRequest::class)->approve($record)),
                Action::make('reject')
                    ->label(__('admin.fields.reject'))
                    ->color('danger')
                    ->action(fn (User $record) => app(ApproveAccountRequest::class)->reject($record)),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
