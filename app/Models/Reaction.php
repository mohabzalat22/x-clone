<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tweet_id',
        'heart',
        'repost',
        'viewed'
    ];

    // RELATIONS
    public function tweet(): BelongsTo
    {
        return $this->belongsTo(Tweet::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
