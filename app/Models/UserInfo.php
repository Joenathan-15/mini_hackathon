<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exp',
        'username',
        'birth_date',
        'balance',
        'collage_year',
        'major'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
