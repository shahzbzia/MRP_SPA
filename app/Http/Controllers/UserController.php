<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Http\Requests\Users\EditUserRequest;
use App\Booking;

class UserController extends Controller
{
    public function listUsers()
    {

    	$user = User::where('role_id', '=', 1)->get();

    	return view('users.index')->with('users', $user);

    }

    public function listAdmins()
    {

    	$user = User::where('role_id', '=', 2)->get();

    	return view('users.index')->with('users', $user);

    }

    public function changeRole($id)
    {

    	$user = User::where('id', $id)->firstOrFail();

    	if ($user->role_id == 1) 
        {
    		User::where('id', $id)->update(['role_id' => '2']);
    	}

    	else
        {
    		User::where('id', $id)->update(['role_id' => '1']);
    	}

    	session()->flash('success', 'User updated successfully.');

    	return redirect()->back();

    }

    public function destroy($id)
    {
        //find the user in the DB
        $user = User::withTrashed()->where('id', $id)->firstOrFail();

        //if user is softdeleted, then force delete, else soft delete
        if ($user->trashed()) 
        {

            $user->forceDelete();

            //show success message
            session()->flash('success', 'User deleted successfully!');

            //redirect back
            return redirect()->back();
        }
        else
        {
            $user->delete();

            $bookings = Booking::where('user_id', $id)->get();

            foreach ($bookings as $b) {
                $b->delete();
            }

            //show success message
            session()->flash('success', 'User trashed successfully!');

            //redirect back
            return redirect()->back();
        }

    }

    public function trashed(User $user)
    {
        $trashed = User::onlyTrashed()->get();


        return view('users.index')->with('users', $trashed);

    }

    public function restore($id)
    {

        //find the room in the DB
        $user = User::withTrashed()->where('id', $id)->firstOrFail();

        $bookings = Booking::withTrashed()->where('user_id', $id)->get();

        foreach ($bookings as $b) {
            $b->restore();
        }

        $user->restore();

        //show success message
        session()->flash('success', 'User restored successfully!');

        //redirect back
        return redirect()->back();

    }

    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function showUserEditForm()
    {

        $user = Auth::user();

        return view('auth.register')->with('user', $user);

    }

    public function editUsers(EditUserRequest $request, $id)
    {

        $user = User::findOrFail($id);

        $input = $request->all();

        $user->update($input);

        session()->flash('success', 'Profile updated successfully!');

        return redirect(route('landingPage', app()->getLocale()));

    }

    public function deactivateUser($id)
    {

        $user = User::findOrFail($id);

        Auth::logout();

        $user->delete();

        $bookings = Booking::where('user_id', $id)->get();

        foreach ($bookings as $b) {
            $b->delete();
        }

        session()->flash('success', 'Account deactivated successfully! Contact Admin to reactivate your account.');

        return redirect(route('landingPage', app()->getLocale()));
    }

    public function inviteForm() 
    {
        return view('users.invite');
    }
}
