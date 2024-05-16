<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralBalanceEntries extends Model
{
    use HasFactory;

    protected $fillable = [
        'general_balance_id',
        'description',
        'value',
        'entry_date',
    ];
}
