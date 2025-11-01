<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialDetail extends Model
{
    use HasFactory;

    protected $fillable = ['material_id', 'category_id'];

    public function material(): BelongsTo {
        return $this->belongsTo(Material::class);
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }
}
