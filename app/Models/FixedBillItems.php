<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedBillItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'fixed_bill_id',
        'parcel_number',
        'value',
        'due_date',
        'is_paid',
    ];

    public function fixedBill()
    {
        return $this->belongsTo(FixedBill::class);
    }
}
