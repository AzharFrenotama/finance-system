<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    
    protected $fillable = ['profile_id', 'category_id', 'month', 'year', 'limit_amount', 'current_expense'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
