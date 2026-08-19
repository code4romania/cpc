<?php

namespace App\Enums;

enum ConsultationUrgency: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    public function label(): string
    {
        return __('enums.consultation_urgency.' . $this->value);
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $urgency): array => [$urgency->value => $urgency->label()])
            ->all();
    }
}
