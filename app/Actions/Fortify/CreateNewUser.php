<?php

namespace App\Actions\Fortify;

use App\Enums\AccountApprovalStatus;
use App\Enums\UserRole;
use App\Models\User;
use App\Notifications\AccountRequested;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * @param  array<string, mixed>  $input
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'organization' => ['required', 'string', 'max:255'],
            'reference_phone' => ['required', 'string', 'max:50'],
            'account_role' => ['required', Rule::in([UserRole::Mai->value, UserRole::Ngo->value])],
            'terms' => ['accepted'],
            'locale' => ['nullable', 'string', Rule::in(config('cpc.supported_locales', ['ro', 'en']))],
        ])->validate();

        $user = User::query()->create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Str::password(32),
            'organization' => $input['organization'],
            'reference_phone' => $input['reference_phone'],
            'professional_role' => null,
            'role' => $input['account_role'],
            'approval_status' => AccountApprovalStatus::Pending,
            'verified_at' => null,
            'locale' => $input['locale'] ?? session('locale', config('cpc.default_locale', 'ro')),
        ]);

        Notification::send(
            User::query()->where('role', UserRole::Admin)->get(),
            new AccountRequested($user),
        );

        return $user;
    }
}
