<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking_table'; // Table name if different from 'bookings'

    protected $primaryKey = 'booking_id'; // Primary key

    public $timestamps = false; // Since there are no `updated_at` and `created_at` fields

    protected $fillable = [
        'vendor_service_id',
        'user_id',
        'event_code',
        'event_date',
        'no_of_guests',
        'additional_info',
        'created_on',
        'event_time'
    ];

    protected $casts = [
        'event_date' => 'date',
        'created_on' => 'datetime',
    ];
}
