<?php

namespace App\Enums;

enum CurriculumStatus: string
{
    case NEW = 'new';
    case PENDING_REVIEW = 'pending_review';
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
            self::PENDING_REVIEW => __('Pending Review'),
            self::PENDING_APPROVAL => __('Pending Approval'),
            self::APPROVED => __('Approved'),
            self::REJECTED => __('Rejected')
        };
    }
}
