<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
    	'user_id', 'room_id', 'date', 'start_time', 'end_time', 'linked_users'
    ];

    protected $casts = [
        'linked_users' => 'json'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }
}
