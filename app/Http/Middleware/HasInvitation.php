<?php

namespace App\Http\Middleware;

use App\Invitations;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HasInvitation
{

    public function handle($request, Closure $next)
    {
        //Only for GET requests. Otherwise, this middleware will block our registration.
        if ($request->isMethod('get')) 
        {
            //No token = Goodbye.
            if (!$request->has('invitation_token')) 
            {
                session()->flash('fail', 'No invitation token found! Try again with the correct invitation token.');
                return redirect(route('login', app()->getLocale()));
            }

            $invitation_token = $request->get('invitation_token');

             //Lets try to find invitation by its token.
             //If failed -> return to request page with error.
            try {
                $invitation = Invitations::where('invitation_token', $invitation_token)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                session()->flash('fail', 'Wrong invitation token! Contact admin or use the correct invitation token.');
                return redirect(route('login', app()->getLocale()));
            }

            // Let's check if users already registered.
            // If yes -> redirect to login with error.
            if (!is_null($invitation->registered_at)) {
                session()->flash('fail', 'User with this email already exists, Please login.');
                return redirect(route('login', app()->getLocale()));
            }
        }

        return $next($request);
    }
}
