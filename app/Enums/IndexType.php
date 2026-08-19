<?php

namespace App\Enums;

enum IndexType: string
{
    case Vulnerability = 'vulnerability';
    case Resilience = 'resilience';
    case Rti = 'rti';

    public function label(): string
    {
        return __('enums.index_type.' . $this->value);
    }
}
