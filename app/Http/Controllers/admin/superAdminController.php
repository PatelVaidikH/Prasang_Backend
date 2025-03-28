<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class superAdminController extends Controller
{
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
        $vendors = DB::table('vendor_master_table')->get();
        return view('admin.viewVendor',compact('vendors'));
    }
}
