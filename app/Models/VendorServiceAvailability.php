<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorServiceAvailability extends Model
{
    use HasFactory;

    protected $table = 'vendor_service_availability'; // Explicitly defining table name

    protected $primaryKey = 'vendor_service_availability_id'; // Defining primary key

    public $timestamps = false; // Since there are no created_at and updated_at fields

    protected $fillable = [
        'vendor_service_id',
        'event_date',
        'booked_by',
        'booked_on'
    ];
}
