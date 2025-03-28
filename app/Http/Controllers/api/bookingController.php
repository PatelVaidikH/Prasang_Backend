<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorServiceAvailability;
use App\Models\Cart;


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

    public function storeDate(Request $request){
        $existingAvailability = VendorServiceAvailability::where('vendor_service_id', $request->vendor_service_id)
            ->where('event_date', $request->event_date)
            ->first();
        if ($existingAvailability) {
            return response()->json(['message' => 'Date is already booked'], 409);
        }
        $availability = new VendorServiceAvailability();
        $availability->vendor_service_id = $request->vendor_service_id;
        $availability->event_date = $request->event_date;
        $availability->save();

        return response()->json(['message' => 'Date stored successfully'], 201);

    }
    public function addToCart(Request $request)
    {
        // return response()->json($request->all());
        // Validate incoming request data
        // $request->validate([
        //     'event_date' => 'required|date',
        //     'event_time' => 'required|string|max:45',
        //     'event_code' => 'required|string|max:8',
        //     'no_of_guests' => 'required|integer|min:1',
        //     'additional_info' => 'nullable|string',
        // ]);

        // Create a new cart entry
        Cart::create([
            'vendor_service_id' => $request->vendor_service_id,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'event_code' => $request->event_code,
            'no_of_guests' => $request->no_of_guests,
            'additional_info' => $request->additional_info,
        ]);

        return response()->json([
            'message' => 'Event added to cart successfully',
            
        ], 201);
    }
}
