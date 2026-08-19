<?php

namespace App\Actions\Fortify;

use App\Enums\ProfessionalRole;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array<string, mixed> $input
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'organization' => ['required', 'string', 'max:255'],
            'professional_role' => ['required', Rule::enum(ProfessionalRole::class)],
            'password' => $this->passwordRules(),
            'terms' => ['accepted'],
            'locale' => ['nullable', 'string', Rule::in(config('cpc.supported_locales', ['ro', 'en']))],
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'organization' => $input['organization'],
            'professional_role' => $input['professional_role'],
            'role' => UserRole::Professional,
            'verified_at' => null,
            'locale' => $input['locale'] ?? session('locale', config('cpc.default_locale', 'ro')),
        ]);
    }
}
