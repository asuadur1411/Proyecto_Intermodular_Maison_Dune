<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date',
        'time',
        'guests',
        'section',
        'table_number',
        'room_number',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}