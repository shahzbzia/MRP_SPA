<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('/', app()->getLocale());
    }

    public function AdminHome()
    {
        return view('admin');
    }

    public function getLocale(){

        $file = 'storage/locale.txt';

        if (app()->getLocale() == 'en') {
            if (Storage::exists($file)) {
            Storage::delete($file);
            }else{
                Storage::disk('public')->put('locale.txt', app()->getLocale());
            }
            return view('welcome');
        }else{
            if (Storage::exists($file)) {
               Storage::delete($file);
            }else{
                Storage::disk('public')->put('locale.txt', app()->getLocale());
            }
            return view('welcome');
        }

        // $path = Storage::disk('public')->getAdapter()->applyPathPrefix('locale.txt');
        
        // dd($path);



    }
}
