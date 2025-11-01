<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function details()
    {
        return $this->hasMany(MaterialDetail::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_details');
    }
}
