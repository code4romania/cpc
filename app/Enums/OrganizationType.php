<?php

namespace App\Enums;

enum OrganizationType: string
{
    case PublicInstitution = 'public_institution';
    case Ngo = 'ngo';
    case Company = 'company';
    case SupportGroup = 'support_group';

    public function label(): string
    {
        return __('enums.organization_type.'.$this->value);
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
