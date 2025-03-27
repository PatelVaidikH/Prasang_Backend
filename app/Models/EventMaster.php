<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventMaster extends Model
{
    //
    protected $table = 'event_master_table';

    // protected $primaryKey = 'event_code';

    protected $fillable = [
        'event_code',
        'event_name',
        'event_description',
        'event_cover_photo'
    ];

    public $timestamps=false;
}
