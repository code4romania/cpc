<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@cpc.test'],
            [
                'name' => 'CPC Admin',
                'password' => 'password',
                'role' => UserRole::Admin,
                'organization' => null,
                'professional_role' => null,
                'verified_at' => now(),
                'locale' => 'ro',
                'email_verified_at' => now(),
            ],
        );
    }
}
