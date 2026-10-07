<?php

namespace App\Enums;

enum PartnershipEntityType: string
{
    case PublicInstitution = 'public_institution';
    case Ngo = 'ngo';
    case PrivateCompany = 'private_company';

    public function label(): string
    {
        return __('enums.partnership_entity_type.'.$this->value);
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
