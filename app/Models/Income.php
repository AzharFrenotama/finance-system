<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable=['profile_id', 'category_id', 'amount', 'description', 'date'];
}
