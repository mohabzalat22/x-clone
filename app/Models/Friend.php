<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friend extends Model
{
    use HasFactory;
    protected $fillable = [
        'follower_id',
        'following_id'
    ];

    // RELATIONSHIPS
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
