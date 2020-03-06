<?php

use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\BookingCollection;
use App\Http\Resources\Booking as BookingResource;
use App\User;
use App\Booking;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

	Route::post('signin', 'vueAuth\SignInController');
	Route::post('signout', 'vueAuth\SignOutController');
	Route::get('me', 'vueAuth\MeController');

/*--------------------------------------------------------

	test api routes in the comments!

	Route::get('/user', function (Request $request) {
	    return new UserCollection(User::all());
	});

	Route::get('/user', function (Request $request) {
	    return new UserResource(User::findOrFail(5));
	});

	Route::get('/booking', function (Request $request) {
	    return new BookingCollection(Booking::all());
	});

-----------------------------------------------------------*/

Route::get('/api', 'RoomController@api')->name('api')->middleware('auth:api');

Route::get('/rooms', 'RoomController@apiShowRooms');

Route::get('/rooms/{id}/booking/create', 'BookingController@bookRooms');

Route::get('/rooms/{id}', 'RoomController@apiRoomInfo');

Route::post('/booking/store', 'BookingController@recieveData');

Route::get('/edit/profile', 'UserController@apiGetUserData');

Route::post('/edit/profile/update', 'UserController@apiUpdateUserData');
