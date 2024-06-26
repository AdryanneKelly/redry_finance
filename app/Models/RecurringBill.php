<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringBill extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'type', 'value', 'billing_date', 'is_active'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
