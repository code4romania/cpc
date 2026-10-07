<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Editor = 'editor';
    case Professional = 'professional';
    case Mai = 'mai';
    case Ngo = 'ngo';

    public function label(): string
    {
        return __('enums.user_role.'.$this->value);
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect([self::Admin, self::Editor])
            ->mapWithKeys(fn (self $role): array => [$role->value => $role->label()])
            ->all();
    }
}
