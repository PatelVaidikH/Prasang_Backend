<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class superAdminController extends Controller
{

    public function adminDashboard()
    {
        // $services = DB::table('service_master_table')->select('service_master_name')->get();
        $serviceCounts = DB::table('service_master_table')
        ->leftJoin('vendor_service_category_table', 'service_master_table.service_code', '=', 'vendor_service_category_table.service_code')
        ->select(
            'service_master_table.service_code',
            'service_master_table.service_master_name',
            DB::raw('COALESCE(COUNT(vendor_service_category_table.service_code), 0) as service_count')
        )
        ->groupBy('service_master_table.service_code', 'service_master_table.service_master_name')
        ->get();
        return view('admin.adminDashboard',compact('serviceCounts'));
    }
    public function addVendor(Request $request)
    {
        $request->validate([
            'vendor_name' => 'required',
            'vendor_email' => 'required',
            'vendor_password' => 'required',
        ]);

        DB::table('user_master_table')->insert([
            'user_email' => $request->vendor_email,
            'user_password' => $request->vendor_password,
            'user_firstname' => $request->vendor_name,
            'role' => 'vendor',
            'created_by' => '1',
            'created_on' => now(),
            'active_status' => '1'
        ]);

        DB::table('vendor_master_table')->insert([
            'vendor_name' => $request->vendor_name,
            'created_by' => '1',
            'created_on' => now(),
            'active_status' => '1'
        ]);

        return redirect()->back()->with('success', 'Vendor added successfully');
    }

    public function viewVendors()
    {
        // $vendors = DB::table('vendor_master_table')->get();
        $vendorServiceCounts = DB::table('vendor_master_table')
            ->leftJoin('vendor_service_category_table', 'vendor_master_table.vendor_id', '=', 'vendor_service_category_table.vendor_id')
            ->select(
                'vendor_master_table.vendor_name',
                'vendor_master_table.vendor_city',
                DB::raw('COALESCE(COUNT(vendor_service_category_table.service_code), 0) as service_count')
            )
            ->groupBy('vendor_master_table.vendor_id', 'vendor_master_table.vendor_name', 'vendor_master_table.vendor_city')
            ->get();
        return view('admin.viewVendor',compact('vendorServiceCounts'));
    }
}
