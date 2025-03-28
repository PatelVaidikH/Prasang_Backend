<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class loginController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = DB::table('user_master_table')->where('user_email', $request->email)->first();

        if ($user && $user->user_password === $request->password) {
            Auth::loginUsingId($user->user_id);
            
            if ($user->role == 'admin') {
                return redirect('/admin');
            } elseif ($user->role == 'vendor') {
                $vendor_id = DB::table('vendor_master_table')
                ->select('vendor_id')->where('vendor_name', $user->user_firstname)->first();
                Session::put('vendor_id', $vendor_id->vendor_id);
                return redirect('/vendor');
            } else {
                return back()->withErrors(['error' => 'Unauthorized role']);
            }
        }
        
        return back()->withErrors(['error' => 'Invalid email or password']);
    }   
}
