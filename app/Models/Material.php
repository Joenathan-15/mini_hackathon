<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'file_name', 'title', 'description', 'price'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany {
        return $this->hasMany(MaterialDetail::class);
    }

    public function activities(): HasMany {
        return $this->hasMany(Activity::class);
    }
}
