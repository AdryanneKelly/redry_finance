<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringBill extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'amount', 'description', 'start_date', 'end_date', 'frequency'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
