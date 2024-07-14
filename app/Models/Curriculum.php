<?php

namespace App\Models;

use App\Enums\CurriculumStatus;
use App\Models\Curriculum\Version;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = "curriculum";

    protected $fillable = [
        'id',
        'customer_info',
        'customer_id',
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
        return $user->id !== $this->customer->id && !$this->reviewer()->exists();
    }

    public function join(User $user)
    {
        if (!$this->canBeJoined($user)) {
            return false;
        }

        if ($this->status == CurriculumStatus::NEW) {
            $this->reviewer()->associate($user);
            $this->status = CurriculumStatus::PENDING_REVIEW;
            $this->save();
            return true;
        }

        return false;
    }

    public function getContent()
    {
        if ($this->versions()->count() == 0) return "";

        $content =  $this->versions()->latest()->first()->content;
        $isOwner = $this->customer_id == Auth::id();
        $customerInfo = $this->customer_info;

        return preg_replace_callback('/\{([^}]+)\}/', function ($matches) use ($customerInfo, $isOwner) {
            $variableName = $matches[1];

            $keys = explode('.', $variableName);

            $type = $keys[0] ?? null;

            if ($type === 'customer') {
                $attribute = $keys[1] ?? null;
                if (isset($customerInfo[$attribute])) {
                    $value = $customerInfo[$attribute];
                } else {
                    return $matches[0];
                }

            } elseif ($type === 'experiences' || $type === 'educations') {
                $index = $keys[1] ?? null;
                $attribute = $keys[2] ?? null;

                if (is_numeric($index) && isset($customerInfo[$type][$index][$attribute])) {
                    return $customerInfo[$type][$index][$attribute];
                } else {
                    return $matches[0];
                }
            } else {
                return $matches[0];
            }

            if (!$isOwner) {
                $value = str_repeat('*', strlen($value));
            }

            return $value;
        }, $content);
    }
}
