<?php

namespace App\Enums;

enum ConsultationStatus: string
{
    case Open = 'open';
    case InProgress = 'in_progress';
    case Closed = 'closed';

    public function label(): string
    {
        return __('enums.consultation_status.' . $this->value);
    }
}
