<?php

namespace App\Actions;

use App\Enums\AccountApprovalStatus;
use App\Models\User;
use App\Notifications\AccountApproved;
use App\Notifications\AccountRejected;

class ApproveAccountRequest
{
    public function approve(User $user): void
    {
        $user->update([
            'approval_status' => AccountApprovalStatus::Approved,
            'verified_at' => now(),
            'expires_at' => now()->addYear(),
        ]);

        $user->notify(new AccountApproved);
    }

    public function reject(User $user): void
    {
        $user->update([
            'approval_status' => AccountApprovalStatus::Rejected,
        ]);

        $user->notify(new AccountRejected);
    }
}
