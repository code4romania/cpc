<?php

namespace App\Enums;

enum AccountApprovalStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function label(): string
    {
        return __('enums.account_approval_status.'.$this->value);
    }
}
