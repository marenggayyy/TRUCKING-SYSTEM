<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';
    protected $fillable = [
        'date', 'time', 'plate_number', 'debit', 'receipt_surrendered', 'remarks', 'liters', 'odometer',
    ];
    // Add casts if needed
    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
        'liters' => 'float',
        'odometer' => 'integer',
    ];
}
