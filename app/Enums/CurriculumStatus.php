<?php

namespace App\Enums;

enum CurriculumStatus: string
{
    case NEW = 'new';
    case PENDING_ASSEMBLY = 'pending_assembly';
    case PENDING_REVIEW = 'pending_review';
    case PENDING_APPROVAL = 'pending_approval';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

}
