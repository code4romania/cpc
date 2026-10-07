<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use App\Notifications\AccountRenewal;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('accounts:expire')]
#[Description('Notify expired organization accounts and delete those that were not renewed')]
class ExpireAccounts extends Command
{
    public function handle(): int
    {
        User::query()
            ->whereIn('role', [UserRole::Mai, UserRole::Ngo])
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->whereNull('renewal_notified_at')
            ->each(function (User $user): void {
                $user->notify(new AccountRenewal);
                $user->update(['renewal_notified_at' => now()]);
            });

        User::query()
            ->whereIn('role', [UserRole::Mai, UserRole::Ngo])
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now()->subMonth())
            ->delete();

        return self::SUCCESS;
    }
}
