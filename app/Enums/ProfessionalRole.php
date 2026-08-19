<?php

namespace App\Enums;

enum ProfessionalRole: string
{
    case SocialWorker = 'social_worker';
    case HealthcareProvider = 'healthcare_provider';
    case Educator = 'educator';
    case LawEnforcement = 'law_enforcement';
    case Counselor = 'counselor';
    case CaseManager = 'case_manager';
    case LegalProfessional = 'legal_professional';
    case Other = 'other';

    public function label(): string
    {
        return __('enums.professional_role.' . $this->value);
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $role): array => [$role->value => $role->label()])
            ->all();
    }
}
