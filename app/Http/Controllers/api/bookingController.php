<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorServiceAvailability;


class bookingController extends Controller
{
    public function checkAvailability(Request $request){
        // $request->validate([
        //     'vendor_service_id' => 'required|integer',
        //     'event_date' => 'required|date',
        // ]);

        $vendorServiceId = $request->vendor_service_id;
        $eventDate = $request->event_date;

        $isBooked = VendorServiceAvailability::where('vendor_service_id', $vendorServiceId)
                             ->where('event_date', $eventDate)
                             ->exists();
        if ($isBooked) {
        return response()->json(['available' => false], 200);
        }

        return response()->json(['available' => true], 200);


    }
}
