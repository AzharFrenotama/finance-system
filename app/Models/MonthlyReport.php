<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    protected $fillable=['profile_id', 'month', 'year', 'total_incomes', 'total_expenses', 'balance'];
}
