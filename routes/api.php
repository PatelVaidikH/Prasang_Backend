<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\allEventServiceController;
use App\Http\Controllers\api\VendorController;

Route::get('/events',[allEventServiceController::class, 'eventList']);
Route::get('/services',[allEventServiceController::class, 'serviceList']);

Route::post('/eventservicelist',[allEventServiceController::class, 'eventServiceList']);
Route::post('/vendorlist',[VendorController::class, 'getVendorByServiceCode']);
