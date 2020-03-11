<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/api', 'RoomController@api')->name('api')->middleware('auth:api');

Route::get('/rooms', 'RoomController@apiShowRooms');

Route::get('/rooms/{id}/booking/create', 'BookingController@bookRooms');

Route::get('/rooms/{id}', 'RoomController@apiRoomInfo');

Route::post('/booking/store', 'BookingController@apiCreateBooking');

Route::get('/edit/profile', 'UserController@apiGetUserData');

Route::post('/edit/profile/update', 'UserController@apiUpdateUserData');

Route::get('/user/dashboard', 'BookingController@apiGetBookingsList');

Route::delete('/user/dashboard/delete/{id}', 'BookingController@apiDeleteBooking');

Route::get('/user/dashboard/extend/{id}', 'BookingController@apiExtendBooking');

Route::post('/user/dashboard/extend/store/{id}', 'BookingController@apiExtendBookingUpdate');

Route::post('/get/booking/slots', 'BookingController@apiGetBookedSlots');

