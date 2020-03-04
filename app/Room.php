<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Room extends Model
{

	use SoftDeletes;
	use HasTranslations;

    protected $fillable = [

    	'name', 'description', 'location', 'image',

    ];

    public $translatable = ['description'];

    public function booking(){
        return $this->hasMany(Booking::class)->with('user');
    }

}
