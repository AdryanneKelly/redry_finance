<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralBalance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'related_month', 'balance', 'fixed_bills_total', 'recurring_bills_total', 'variant_bills_total', 'total_bills', 'available_balance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entries()
    {
        return $this->hasMany(GeneralBalanceEntries::class);
    }
}
