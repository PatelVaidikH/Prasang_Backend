<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\EventMaster;
use App\Models\ServiceMaster;

class vendorAdminController extends Controller
{
    public function updateProfileGet(Request $request){
        $vendor_id = Session::get('vendor_id');
        $vendor = DB::table('vendor_master_table')->where('vendor_id', $vendor_id)->first();
        // dd($vendor_id);
        return view('vendor.updateProfile', compact('vendor'));
    }    

    public function updateProfilePost(Request $request){
        $vendor_id = Session::get('vendor_id');

        $updated = DB::table('vendor_master_table')->where('vendor_id', $vendor_id)->update([
            'vendor_name' => $request->vendor_name,
            'vendor_address' => $request->vendor_address,
            'vendor_state' => $request->vendor_state,
            'vendor_city' => $request->vendor_city,
            'vendor_area' => $request->vendor_area,
            'vendor_pincode' => $request->vendor_pincode,
            'gst_id' => $request->vendor_gst,
            'updated_on' => now(),
        ]);
        
        if ($updated) {
            return redirect()->back()->with('success', 'Profile updated successfully');
        } else {
            return redirect()->back()->withErrors(['error' => 'No changes made or update failed']);
        }
    }

    public function addServiceGet(){
        $services = ServiceMaster::select('service_code', 'service_master_name')->get();
        return view('vendor.addService',compact('services'));
    }

    public function addServicePost(Request $request){
        $vendor_id = Session::get('vendor_id');

        if ($request->hasFile('cover_photo')) {
            $file = $request->file('cover_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = str_replace(' ', '_', strtolower($request->service_name)) . '_cover_photo.' . $extension;
            $coverPhotoPath = $file->storeAs('service_photos', $filename, 'public');
        } else {
            $coverPhotoPath = null;
        }

        DB::table('vendor_service_category_table')->insert([
            'vendor_id' => $vendor_id,
            'service_code' => $request->service_code,
        ]);
        $category = DB::table('vendor_service_category_table')
        ->where('vendor_id', $vendor_id)
        ->where('service_code', $request->service_code)
        ->first();

        DB::table('vendor_service_table')->insert([
            'category_id' => $category->category_id,
            'service_name' => $request->service_name,
            'service_short_description' => $request->service_short_description,
            'service_long_description' => $request->service_long_description,
            'starting_price' => $request->starting_price,
            'cover_photo' => $coverPhotoPath,
            'created_by' => 1,
            'created_on' => now(),
        ]);

        return redirect()->back()->with('success', 'Service added successfully');
    }

    public function viewService(Request $request){
        $vendor_id = Session::get('vendor_id');
        $services = DB::table('vendor_service_category_table as vsc')
        ->join('service_master_table as smt', 'vsc.service_code', '=', 'smt.service_code')
        ->join('vendor_service_table as vst', 'vsc.category_id', '=', 'vst.category_id') // Replace 'your_service_table' with the correct table
        ->select('smt.service_master_name', 'vst.service_name', 'vst.starting_price')
        ->where('vsc.vendor_id', $vendor_id)
        ->get();
        // dd($services);
        return view('vendor.viewService', compact('services'));
    }
}
