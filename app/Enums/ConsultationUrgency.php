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
}
