<?php

namespace App\Enums;

enum OrganizationType: string
{
    case Ngo = 'ngo';
    case PublicInstitution = 'public_institution';
    case International = 'international';
    case Other = 'other';

    public function label(): string
    {
        return __('enums.organization_type.' . $this->value);
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $type): array => [$type->value => $type->label()])
            ->all();
    }
}
