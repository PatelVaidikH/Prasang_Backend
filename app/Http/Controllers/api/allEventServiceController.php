<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\EventMaster;
use App\Models\ServiceMaster;
use Illuminate\Http\Request;

class allEventServiceController extends Controller
{
    public function eventList(){
        $events = EventMaster::select('event_code', 'event_name', 'event_description', 'event_cover_photo')->get();
        return response()->json($events, 200);
    }

    public function serviceList(){
        $service = ServiceMaster::select('service_code', 'service_master_name', 'service_description', 'service_cover_photo')->get();
        return response()->json($service, 200);
    }

    public function eventServiceList(Request $request){


        $requestservice = $request['event_code'];

        $services = ServiceMaster::join('all_matrix_table', 'service_master_table.service_code', '=', 'all_matrix_table.service_code')
        ->where('all_matrix_table.event_code', $requestservice)
        ->where('all_matrix_table.is_applicable', true)
        ->select('service_master_table.service_code', 'service_master_table.service_master_name', 'service_master_table.service_cover_photo', 'service_master_table.service_description', 'service_master_table.service_icon')
        ->get();

        return response()->json($services, 200);
    }
}
