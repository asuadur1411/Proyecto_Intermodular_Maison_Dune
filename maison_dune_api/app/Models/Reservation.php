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
        'checked_in_at',
        'event_slug',
        'event_title',
        'room_slug',
        'room_title',
        'checkout_date',
        'total_price',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'checkout_date' => 'date:Y-m-d',
        'total_price'   => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}