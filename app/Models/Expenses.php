<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $fillable=['profile_id', 'category_id', 'amount', 'description', 'date'];
}
