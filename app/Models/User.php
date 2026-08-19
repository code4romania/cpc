<?php

namespace App\Models;

use App\Enums\ProfessionalRole;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int                   $id
 * @property string                $name
 * @property string                $email
 * @property Carbon|null           $email_verified_at
 * @property string                $password
 * @property UserRole              $role
 * @property string|null           $organization
 * @property ProfessionalRole|null $professional_role
 * @property Carbon|null           $verified_at
 * @property string                $locale
 * @property string|null           $remember_token
 * @property Carbon|null           $created_at
 * @property Carbon|null           $updated_at
 */
#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'organization',
    'professional_role',
    'verified_at',
    'locale',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'professional_role' => ProfessionalRole::class,
        ];
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin() || $this->isEditor();
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isEditor(): bool
    {
        return $this->role === UserRole::Editor;
    }

    public function isProfessional(): bool
    {
        return $this->role === UserRole::Professional;
    }

    public function isVerifiedProfessional(): bool
    {
        return $this->isProfessional() && $this->verified_at !== null;
    }

    /**
     * Get the user's initials.
     */
    public function initials(): string
    {
        $initials = Str::initials($this->name, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1) . Str::substr($initials, -1)
            : $initials;
    }
}
