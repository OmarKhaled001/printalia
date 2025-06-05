<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{

    protected $table = 'bank_accounts';

    protected $fillable = ['name', 'code', 'is_active'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
