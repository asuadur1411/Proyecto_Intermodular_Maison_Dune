<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Closure extends Model
{
    protected $fillable = ['from_date', 'to_date', 'reason'];

    protected $casts = [
        'from_date' => 'date',
        'to_date'   => 'date',
    ];
}
