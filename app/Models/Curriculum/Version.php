<?php

namespace App\Models\Curriculum;

use App\Models\Curriculum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Version extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'curriculum_id',
        'editor_id',
    ];

    public function curriculum(): BelongsTo
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
