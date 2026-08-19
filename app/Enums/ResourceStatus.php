<?php

namespace App\Enums;

enum ResourceStatus: string
{
    case Draft = 'draft';
    case Published = 'published';

    public function label(): string
    {
        return __('enums.resource_status.' . $this->value);
    }
}
