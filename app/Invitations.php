<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitations extends Model
{
	use SoftDeletes;

    protected $fillable = [
        'email', 'invitation_token', 'registered_at', 'user_id'
    ];

    public function generateInvitationToken() {
    	$this->invitation_token = substr(md5(rand(0, 9) . $this->email . time()), 0, 32);
	}

	public function user()
    {
        return $this->belongsTo('App\User');
    }

}