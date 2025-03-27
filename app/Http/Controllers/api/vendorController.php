<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function getVendorByServiceCode(Request $request)
    {
        $vendors = DB::select("
            SELECT
                vm.vendor_id,
                vs.vendor_service_id,
                vs.vendor_service_photo_id,
                vsc.category_id,
                vm.vendor_name,
                vs.service_name,
                vm.vendor_area,
                vm.vendor_city,
                vs.starting_price
            FROM vendor_master_table vm
            JOIN vendor_service_category_table vsc ON vm.vendor_id = vsc.vendor_id
            JOIN vendor_service_table vs ON vsc.category_id = vs.category_id
            WHERE vsc.service_code = ?",
            [$request->service_code]
        );

        return response()->json($vendors);
    }
}
