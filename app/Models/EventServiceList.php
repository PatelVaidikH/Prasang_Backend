<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventMaster;
use App\Models\ServiceMaster;

class EventServiceList extends Model
{
    use HasFactory;

    protected $table = 'all_matrix'; // Update the table name if different

    // protected $primaryKey = 'id';

    public $timestamps = false; // No timestamps in the table

    protected $fillable = [
        'event_code',
        'service_code',
        'is_applicable',
    ];

    protected $casts = [
        'is_applicable' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(ServiceMaster::class, 'service_code', 'service_code');
    }

    public function event()
    {
        return $this->hasMany(EventMaster::class, 'event_code', 'event_code');
    }
}
