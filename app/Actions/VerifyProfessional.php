<?php

namespace App\Actions;

use App\Models\User;
use App\Notifications\ProfessionalVerified;
use Illuminate\Support\Facades\DB;

class VerifyProfessional
{
    public function __invoke(User $user): User
    {
        if (! $user->isProfessional()) {
            return $user;
        }

        if ($user->verified_at !== null) {
            return $user;
        }

        return DB::transaction(function () use ($user): User {
            $user->forceFill([
                'verified_at' => now(),
            ])->save();

            $user->notify(new ProfessionalVerified);

            return $user->refresh();
        });
    }
}
