<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['designer_id', 'name', 'phone', 'address', 'profile'];

    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
