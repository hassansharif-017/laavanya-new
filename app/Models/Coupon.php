<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'expire_date',
        'percentage',
        'is_publish',
    ];

    public function scopeActive($query)
    {
        return $query->where('expire_date', '<=', now())->where('is_publish', 1);
    }
}
