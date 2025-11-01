<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['email', 'password'];

    public function userInfo(): HasOne {
        return $this->hasOne(UserInfo::class);
    }

    public function materials(): HasMany {
        return $this->hasMany(Material::class);
    }

    public function activities(): HasMany {
        return $this->hasMany(Activity::class);
    }

    public function ownedTransactions(): HasMany {
        return $this->hasMany(Transaction::class, 'owner_id');
    }

    public function customerTransactions(): HasMany {
        return $this->hasMany(Transaction::class, 'customer_id');
    }
}
