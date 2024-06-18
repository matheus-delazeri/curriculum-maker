<?php

namespace App\Enums;

enum CurriculumStatus: string
{
    case NEW = 'new';
    case PENDING_ASSEMBLY = 'pending_assembly';
    case ASSEMBLED = 'assembled';
    case PENDING_REVIEW = 'pending_review';
    case REVIEWED = 'reviewed';
    case PENDING_APPROVAL = 'pending_approval';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::NEW => __('New'),
            self::PENDING_ASSEMBLY => __('Pending Assembly'),
            self::ASSEMBLED => __('Assembled'),
            self::PENDING_REVIEW => __('Pending Review'),
            self::REVIEWED => __('Reviewed'),
            self::PENDING_APPROVAL => __('Pending Approval'),
            self::APPROVED => __('Approved'),
            self::REJECTED => __('Rejected')
        };
    }
}
