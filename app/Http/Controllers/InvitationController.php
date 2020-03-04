<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Invitations\CreateInvitationRequest;
use App\User;
use App\Invitations;
use Mail;
use App\Mail\InvitationMail;

class InvitationController extends Controller
{

    public function store(CreateInvitationRequest $request)
	{
		
		$email = $request->email;

		if (User::where('email', '=', $email)->exists()) 
		{
			//dd($email);
			session()->flash('fail', 'User with this email address already exists!');

	        return redirect()->back();
		}
		else
		{
			$invitation = Invitations::where('email', '=', $email)->first();
			if ($invitation === null) 
			{

		        $invitations = new Invitations($request->all());
		    	$invitations->generateInvitationToken();
		    	$invitations->save();

		    	$invite = Invitations::where('email', '=', $email)->first();
				$token = $invite->invitation_token;

		    	//send mail
		    	Mail::to($email)->send(new InvitationMail($token));

		    	session()->flash('success', 'Invitation link sent!');

		        return redirect(route('inviteForm'));

			} else
			{

				$token = $invitation->invitation_token;

				//send mail
				Mail::to($email)->send(new InvitationMail($token));

		    	session()->flash('success', 'Invitation link sent again!');

		        return redirect(route('inviteForm'));
				
			}
			

		}
	    
	}
}
