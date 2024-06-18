<?php

namespace App\Models;

use App\Enums\CurriculumStatus;
use App\Models\Curriculum\Version;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = "curriculum";

    protected $fillable = [
        'id',
        'customer_info',
        'customer_id',
        'assembler_id',
        'reviewer_id'
    ];

    protected $casts = [
        'customer_info' => 'array',
        'status' => CurriculumStatus::class
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assembler(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function versions(): HasMany
    {
        return $this->hasMany(Version::class);
    }

    public function canBeJoined(User $user)
    {
        return $user->id !== $this->customer->id
            && (!$this->assembler()->exists() || !$this->reviewer()->exists());
    }

    public function join(User $user)
    {
        if (!$this->canBeJoined($user)) {
            return false;
        }

        if ($this->status == CurriculumStatus::NEW) {
            $this->assembler()->associate($user);
            $this->status = CurriculumStatus::PENDING_ASSEMBLY;
            $this->save();
            return true;
        } else if (!$this->status == CurriculumStatus::ASSEMBLED) {
            $this->reviewer()->associate($user);
            $this->status = CurriculumStatus::PENDING_REVIEW;
            $this->save();
            return true;
        }

        return false;
    }
}
