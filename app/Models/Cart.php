<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $primaryKey = 'cart_id';

    public $timestamps = false; 

    protected $fillable = [
        'vendor_service_id',
        'user_id',
        'event_date',
        'created_on',
        'event_time',
        'no_of_guests',
        'additional_info',
        'event_code',
    ];

    protected $casts = [
        'event_date' => 'date',
        'created_on' => 'datetime',
    ];
}
