<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\allEventServiceController;
use App\Http\Controllers\api\VendorController;
use App\Http\Controllers\api\bookingController;

Route::get('/events',[allEventServiceController::class, 'eventList']);
Route::get('/services',[allEventServiceController::class, 'serviceList']);

Route::post('/eventservicelist',[allEventServiceController::class, 'eventServiceList']);
Route::post('/vendorlist',[VendorController::class, 'getVendorByServiceCode']);
Route::post('/vendordetail',[VendorController::class, 'vendorDetails']);
Route::post('/vendorserviceavailability',[bookingController::class, 'checkAvailability']);
Route::post('/storedate',[bookingController::class, 'storeDate']);
Route::post('/cart',[bookingController::class, 'addToCart']);
Route::get('/viewCart',[bookingController::class, 'viewCart']);
Route::delete('/cart/{cart_id}', [bookingController::class, 'removeFromCart']);
