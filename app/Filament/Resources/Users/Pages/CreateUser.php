<?php

namespace App\Filament\Resources\Users\Pages;

use App\Enums\AccountApprovalStatus;
use App\Enums\UserRole;
use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (in_array($data['role'] ?? null, [UserRole::Mai->value, UserRole::Ngo->value], true)) {
            $data['approval_status'] = AccountApprovalStatus::Approved->value;
            $data['verified_at'] = $data['verified_at'] ?? now();
            $data['expires_at'] = now()->addYear();
        }

        return $data;
    }
}
