<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceMaster extends Model
{
    //
    protected $table = 'service_master_table';

    // protected $primaryKey = 'service_code';

    protected $fillable = [
        'service_code',
        'service_master_name',
        'service_description',
        'service_cover_photo',
        'service_icon'
    ];

    public $timestamps=false;
}

