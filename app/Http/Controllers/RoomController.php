<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Rooms\CreateRoomsRequest;
use App\Http\Requests\Rooms\UpdateRoomsRequest;
use App\Room;
use App\Booking;
use Illuminate\Support\Facades\Storage;
use App\Exports\RoomsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\RoomCollection;
use App\Imports\RoomsImport;
use Carbon;
use Illuminate\Support\Facades\Cookie;
use Auth;
use App\User;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('rooms.index')->with('rooms', Room::all());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('rooms.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoomsRequest $request)
    {

        //upload image
        $image = ($request->image->store('rooms'));


        //create room
        Room::create([

            'name' => $request->name,
            'description' => [
                'en' => $request->descriptionEN,
                'nl' => $request->descriptionNL
            ],
            'location' => $request->location,
            'image' => $image


        ]);

        //flash success message
        session()->flash('success', 'Room created successfully!');

        //return redirect back

        return redirect(route('rooms.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {

        return view('rooms.create')->with('room', $room);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoomsRequest $request, $id)
    {

        //check if new image

        //$data = $request->only(['name', 'descriptionEN', 'descriptionNL', 'location']);
        $room = Room::whereId($id)->firstOrFail();

        $hasImage = false;

        if ($request->hasFile('image')) 
        {
            
            //upload it
            $image = $request->image->store('rooms');

            //delete old image
            Storage::delete($room->image);

            $data['image'] = $image;

            $hasImage = true;

        }
        

        //update attributes
        $room::whereId($id)->update([

            'name' => $request->name,
            'description' => [
                'en' => $request->descriptionEN,
                'nl' => $request->descriptionNL
            ],
            'location' => $request->location,

        ]);

        if ($hasImage) 
        {
            
            $room::whereId($id)->update([
                'image' => $image,
            ]);
            
        }

        // flash message
        session()->flash('success', 'Room updated successfully.');

        // redirect user
        return redirect(route('rooms.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find the room in the DB
        $room = Room::withTrashed()->where('id', $id)->firstOrFail();

        //if user is softdeleted, then force delete, else soft delete
        if ($room->trashed()) 
        {

            Storage::delete($room->image);

            $room->forceDelete();

            //show success message
            session()->flash('success', 'Room deleted successfully!');

            //redirect back
            return redirect(route('trashed-rooms.index'));

        }
        else 
        {

            $room->delete();

            $bookings = Booking::where('room_id', $id)->get();

            foreach ($bookings as $b) {
                $b->delete();
            }

            //show success message
            session()->flash('success', 'Room trashed successfully!');

            //redirect back
            return redirect(route('rooms.index'));

        }

    }

    /**
     * Show trashed rooms
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed(Room $room)
    {

        $trashed = Room::onlyTrashed()->get();


        return view('rooms.index')->with('rooms', $trashed);

    }

    public function restore($id)
    {

        //find the room in the DB
        $room = Room::withTrashed()->where('id', $id)->firstOrFail();

        $room->restore();

        $bookings = Booking::withTrashed()->where('room_id', $id)->get();

        foreach ($bookings as $b) {
            $b->restore();
        }

        //show success message
        session()->flash('success', 'Room restored successfully!');

        //redirect back
        return redirect()->back();

    }

    public function export() 
    {

        return Excel::download(new RoomsExport, 'rooms.xlsx');
    }


    public function showRooms(Request $request)
    {

        // $rooms=Room::paginate(9);


        // if ($request->ajax()) {

        //     return view('roomData')->with('rooms', $rooms);

        // }


        // return view('welcome');


        if (app()->getLocale() == 'nl') {
            setcookie('lang', 'nl');
        }

        else{

            setcookie('lang', 'en');
        }

        return view('welcome');


    }

    public function showDetails($id)
    {

        $room = Room::where('id', $id)->firstOrFail();

        return view('rooms.detail')->with('room', $room);

    }

    public function api()
    {

        return new RoomCollection(Room::with('booking')->get());

    }

    public function roomImportForm()
    {
        
        return view('import');

    }

    public function roomImport(Request $request) 
    {

        Excel::import(new RoomsImport, request()->file('excel'));

        session()->flash('success', 'Room created successfully!');
        
        return redirect('/admin/rooms')->with('rooms', Room::all());

    }

    public function apiShowRooms(Request $request)
    {


        $rooms = Room::all()->toArray();

        return response()->json([
            "success" => true,
            "data" => $rooms], 200);

    }

    public function apiRoomInfo(Request $request, $id)
    {

        $room = Room::where('id', $id)->firstOrFail();
        $user = Auth::user();
        $otherUsers = User::all()->except(Auth::id());

        return response()->json([
            "success" => true,
            "data" => $room,
            "user" => $user,
            "otherUsers" => $otherUsers,
        ], 200);

    }



}
