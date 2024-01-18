<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tweet extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'data',
        'source',
    ];
    // RELATIONS
    // BELONG
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // HAS_MANY
    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
