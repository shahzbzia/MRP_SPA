<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function(){
	return redirect(app()->getLocale());
});

Route::group(['prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}'], 'middleware' => 'setlocale'], function () {

	//Route::get('detail/room/{id}', 'RoomController@showDetails')->name('showDetails');

Auth::routes(['verify' => true]);

Route::get('/recieveData', 'BookingController@recieveData');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->middleware('hasInvitation')->name('register');

//Route::get('/', 'HomeController@getLocale')->name('test');

Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.route');

	Route::group(['middleware' => 'auth'], function () {

		Route::get('/', 'RoomController@showRooms')->name('landingPage');	
		Route::get('room/{id}/booking', 'BookingController@showForm')->name('bookings.create');
	    Route::post('detail/room/{id}/booking/store', 'BookingController@storeBooking')->name('bookings.store');
	    Route::get('dashboard', 'BookingController@userDashboard')->name('user.dashboard');
	    Route::get('edit/{booking}/{roomId}/{date}', 'BookingController@showEditForm')->name('editForm');
	    Route::put('edit/{booking}/{roomId}/save', 'BookingController@edit')->name('edit');
	    Route::get('profile/{id}', 'UserController@showUserEditForm')->name('showUserEditForm');
		Route::put('profile/edit/{id}', 'UserController@editUsers')->name('editUsers');
		Route::delete('profile/delete/{id}', 'UserController@deactivateUser')->name('deactivateUser');
		Route::get('dashboard/test', 'BookingController@showBookingInLinkedUserDashboard')->name('test');

	});



});

Route::delete('cancel/{booking}', 'BookingController@cancel')->name('cancel');

Route::get('booking_controller/read', 'BookingController@read')->name('booking_controller.read');

Route::group(['prefix' => 'admin' , 'middleware' => ['auth' => 'admin']], function(){

	Route::get('/', 'HomeController@AdminHome')->name('adminHome');
	Route::get('rooms/export/', 'RoomController@export')->name('rooms.export');
	Route::get('trashed-rooms', 'RoomController@trashed')->name('trashed-rooms.index');
	Route::put('restore-room/{room}', 'RoomController@restore')->name('restore-room');
	Route::get('users', 'UserController@listUsers')->name('listUsers');
	Route::get('admins', 'UserController@listAdmins')->name('listAdmins');
	Route::put('user/change-role/{user}', 'UserController@changeRole')->name('changeRole');
	Route::delete('user/delete/{user}', 'UserController@destroy')->name('users.destroy');
	Route::get('trashed-users', 'UserController@trashed')->name('trashed-users.index');
	Route::put('restore-user/{user}', 'UserController@restore')->name('restore-user');
	Route::get('users/export/', 'UserController@export')->name('users.export');
	Route::resource('rooms', 'RoomController');
	Route::get('import', 'RoomController@roomImportForm')->name('import');
	Route::post('import/upload', 'RoomController@roomImport')->name('rooms.import');
	Route::get('invite', 'UserController@inviteForm')->name('inviteForm');
	Route::post('invite/store', 'InvitationController@store')->name('storeInvitation');
});


Route::get('{any}', function () {
    return view('welcome');
})->where('any','.*')->name('all');