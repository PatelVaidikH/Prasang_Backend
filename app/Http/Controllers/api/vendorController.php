<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function getVendorByServiceCode(Request $request)
    {
        $serviceCode = $request->input('service_code');
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
            vs.starting_price,
            COALESCE(ROUND(AVG(rt.rating), 1), 0) AS average_rating
        FROM vendor_master_table vm
        JOIN vendor_service_category_table vsc ON vm.vendor_id = vsc.vendor_id
        JOIN vendor_service_table vs ON vsc.category_id = vs.category_id
        LEFT JOIN review_table rt ON vs.vendor_service_id = rt.vendor_service_id
        WHERE vsc.service_code = ?
        GROUP BY vm.vendor_id, vs.vendor_service_id, vs.vendor_service_photo_id, vsc.category_id,
                 vm.vendor_name, vs.service_name, vm.vendor_area, vm.vendor_city, vs.starting_price
    ", [$serviceCode]);

        return response()->json($vendors);
    }

    public function vendorDetails(Request $request)
{
    $categoryid = $request->input('category_id');

    $vendordetails = DB::select("
        SELECT
            vm.vendor_id,
            vs.vendor_service_id,
            vs.vendor_service_photo_id,
            vs.category_id,
            vm.vendor_name,
            vm.vendor_area,
            vm.vendor_city,
            vm.vendor_pincode,
            vs.service_name,
            vs.service_short_description,
            vs.service_long_description,
            COALESCE(ROUND(AVG(r.rating), 1), 0) AS ratings,
            vs.starting_price
        FROM vendor_service_table vs
        JOIN vendor_service_category_table vsc ON vs.category_id = vsc.category_id
        JOIN vendor_master_table vm ON vsc.vendor_id = vm.vendor_id
        LEFT JOIN review_table r ON vs.vendor_service_id = r.vendor_service_id
        WHERE vs.category_id = ?
        GROUP BY
            vm.vendor_id,
            vs.vendor_service_id,
            vs.vendor_service_photo_id,
            vs.category_id,
            vm.vendor_name,
            vm.vendor_area,
            vm.vendor_city,
            vm.vendor_pincode,
            vs.service_name,
            vs.service_short_description,
            vs.service_long_description,
            vs.starting_price;
    ", [$categoryid]);

    return response()->json($vendordetails);
}

}
