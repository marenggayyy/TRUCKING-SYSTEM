<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckDocument extends Model
{
    protected $guarded = [];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }
}