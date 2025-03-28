<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\admin\superAdminController;
use App\Http\Controllers\admin\vendorAdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/loginGet', function () {
    return view('loginPage');
})->name('loginGet');
Route::post('/login', [loginController::class, 'login']);

Route::get('/admin', [superAdminController::class, 'adminDashboard'])->name('adminDashboard');

Route::get('/addVendor', function () {
    return view('admin.addVendor');
})->name('addVendor');

Route::post('/addVendorPost', [superAdminController::class, 'addVendor'])->name('addVendorPost');

Route::get('/viewVendor',[superAdminController::class, 'viewVendors'])
->name('viewVendor');

Route::get('/vendor', function () {
    return view('vendor.vendorDashboard');
})->name('vendorDashboard');

Route::get('/update', [vendorAdminController::class, 'updateProfileGet'])->name('update');

Route::post('/updatePost', [vendorAdminController::class, 'updateProfilePost'])->name('updateProfilePost');

Route::get('/addService', [vendorAdminController::class, 'addServiceGet'])->name('addService');

Route::post('/addServicePost',[vendorAdminController::class, 'addServicePost'])->name('addServicePost');

Route::get('/viewService', [vendorAdminController::class, 'viewService'])->name('viewService');