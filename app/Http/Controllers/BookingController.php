<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\ExtendBookingFormRequest;
use App\Http\Requests\Booking\CreateBookingRequest;
use Illuminate\Database\Eloquent\Collection;
use App\Notifications\BookingNotification;
use App\Mail\BookingConfirmation;
use Spatie\CalendarLinks\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Notification;
use App\Booking;
use Sessions;
use App\Room;
use App\User;
use DateTime;
use Storage;
use Config;
use Carbon;
use Auth;
use Mail;
use App;
use DB;

class BookingController extends Controller
{
    public function showForm($id)
    {

    	$room = Room::where('id', $id)->firstOrFail();
    	$user = Auth::user();
    	$otherUsers = User::all()->except(Auth::id());
            
        return view('bookings.create')->with('room', $room)->with('user', $user)->with('users', $otherUsers);

    }


    public function storeBooking(CreateBookingRequest $request, $id)
    {
        $room = Room::where('id', $id)->firstOrFail();

        $user = Auth::user();

    	$startTime = $request->start_time;

    	$endTime = $request->end_time;

        $to_name = $user->name;

        $to_email = $user->email;

        $roomName = $room->name;

        $date = $request->date;

        $eventStart = $date . ' ' . $startTime;

        $eventEnd = $date . ' ' . $endTime;

        $from = DateTime::createFromFormat('Y-m-d H:i', $eventStart);

        $to = DateTime::createFromFormat('Y-m-d H:i', $eventEnd);

        $link = Link::create($room->name, $from, $to)
            ->address('Ankerrui-2,-2018-Antwerpen' . '-' . $room->location);

        $linkedUsers = '';

        $linkedUsersEmails = '';

        $linkedUsersEmailsArray = null;

		$bookings = Booking::where('date', '=', $request->date)->where('room_id', $room->id)->where(function ($query) use($startTime, $endTime){
		    $query->where([
		        ['start_time', '>=', $startTime],
		        ['start_time', '<', $endTime],
		    ])->orWhere([
		        ['start_time', '<=', $startTime],
		        ['end_time', '>', $startTime],
		    ]);
		})->count();

	  	if($bookings == 0)
        {

	  		if (now('CET')->format('Y-m-d') == $date && now('CET')->format('H:i') > $startTime) 
            {
                session()->flash('fail', "You can't book a room in the past!");

                return redirect()->back()->withInput();
            }

            else
            {
                //$json_array = json_encode();
                
                Booking::create([

                    'user_id' => $user->id,
                    'room_id' => $room->id,
                    'date' => $request->date,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'linked_users' => $request->input('linked_user'),

                ]);

                Storage::disk('local')->put( Str::random(30) . '.ics', $link->ics());
        
                $data['ics'] = $link->ics();

                if ($request->linked_user == null) 
                {
                    $linkedUsers = null;

                    Mail::to($to_email)->send(new BookingConfirmation($to_name, $roomName, $startTime, $endTime, $date, $linkedUsers, $data['ics']));
                }
                else
                {
                    foreach ($request->linked_user as $u) 
                    {
                        $linkedUsers .= User::where('id', $u)->value('name') . ', ';
                        $linkedUsersEmails .= User::where('id', $u)->value('email') . ', ';
                    }
                    $linkedUsers = trim($linkedUsers, ', ');
                    $linkedUsersEmails = trim($linkedUsersEmails, ', ');
                    $linkedUsersEmailsArray = explode(", ", $linkedUsersEmails);

                    Mail::to($to_email)->cc($linkedUsersEmailsArray)->send(new BookingConfirmation($to_name, $roomName, $startTime, $endTime, $date, $linkedUsers, $data['ics']));
                }

                if (App::environment('production')) 
                {
                    Notification::send($user, new BookingNotification($to_name, $roomName, $startTime, $endTime, $date, $linkedUsers));
                }

                session()->flash('success', 'Room booked successfully!');

                return redirect(route('landingPage', app()->getLocale()));
            }

	  	}

	  	else
        {

            $user = Auth::user();

            $otherUsers = User::all()->except(Auth::id());

            $bookingSlots = Booking::where('date', '=', $request->date)->where('room_id', $room->id)->get();

            $slots = '';

            foreach ($bookingSlots as $b) {
                $slots .= $b->start_time . ' - ' . $b->end_time . ' | ';
            }
            $slots = trim($slots, ' | ');

            //dd($slots);

	  		session()->flash('fail', 'The room is already booked during these hours!');

            session()->flashInput($request->input());

	 		return view('bookings.create', [app()->getLocale(), $room->id])->with('slots', $slots)->with('room', $room)->with('user', $user)->with('users', $otherUsers);

	  	}

    }

    public function read(Request $request)
    {

     	if($request->ajax())
        {
    		$query = $request->get('query');
    		$room = $request->get('room');
            $date = date( "Y-m-d", strtotime( $query ) );
    		$data = Booking::whereDate('date', $date)->where('room_id', $room)->orderBy('start_time', 'asc')->get();
    		$total_row = $data->count();
    		$output = '';
    		if ($total_row>0) 
            {
    			foreach ($data as $row) 
                {
    				$output .= '<span>' . $row->start_time .' - '.$row->end_time. '</span>';
    			}
    		}
    		else
            {
    			$output = '/';
    		}

    		$data = $output;

    		echo json_encode($data);
    	}

    }


    public function userDashboard()
    {

        $user_id = Auth::user()->id;

        $json = Booking::whereNotNull('linked_users')->get();

        $bookings = Booking::where('user_id', $user_id)->orWhere('linked_users', 'like', '%' . $user_id . '%')->where('deleted_at', null)->orderBy('created_at', 'desc')->get();

        return view('home')->with('bookings', $bookings);

    }

    public function showEditForm(Booking $booking, $roomId, $date)
    {

        $room = Room::where('id', $roomId)->firstOrFail();
        $user = Auth::user();
        $otherUsers = User::all()->except(Auth::id());
        $bookedSlots = Booking::where('room_id', $roomId)->where('date', '=', $date)->orderBy('start_time', 'asc')->get();

        $bookingSlot = ' ';

        foreach ($bookedSlots as $slots) {
            $bookingSlot .= $slots->start_time .' - '. $slots->end_time . ' | ';
        }

        $bookingSlot = trim($bookingSlot, ' | ');

        return view('bookings.create')->with('room', $room)->with('booking', $booking)->with('user', $user)->with('users', $otherUsers)->with('bookingSlot', $bookingSlot);
    }

    public function edit(ExtendBookingFormRequest $request, $bookingId, $roomId)
    {

        $endTime = $request->end_time;

        $startTime = Booking::where('id', $bookingId)->value('start_time');

        if ($startTime >= $endTime) 
        {

            session()->flash('fail', 'End time should always be greater than start time!');
            return redirect()->back()->withInput();

        }

        $bookings = Booking::where('date', '=', $request->date)
            ->where('room_id', $roomId)
            ->where('id', '!=', $bookingId)
            ->where([
                ['start_time', '>', $startTime],
                ['start_time', '<', $endTime],
            ])
            ->count();

        if($bookings == 0)
        {

            $json_array = json_encode($request->input('linked_user'));

            Booking::whereId($bookingId)->update([

                'end_time' => $request->end_time,

            ]);

            session()->flash('success', 'Booking update successfully!');

            return redirect(route('landingPage', app()->getLocale()));

        }

        else
        {

            session()->flash('fail', 'The room is already booked during that hour!');

            return redirect()->back()->withInput();

        }

    }

    public function cancel(Booking $booking)
    {

        $booking->forceDelete();

        session()->flash('success', 'Booking deleted successfully');

        return redirect()->back();

    }

    public function apiCreateBooking(CreateBookingRequest $request){

        $room = Room::where('id', $request->room_id)->firstOrFail();

        $user = Auth::user();

        $startTime = $request->start_time;

        $endTime = $request->end_time;

        $to_name = $user->name;

        $to_email = $user->email;

        $roomName = $room->name;

        $date = $request->date;

        $eventStart = $date . ' ' . $startTime;

        $eventEnd = $date . ' ' . $endTime;

        $from = DateTime::createFromFormat('Y-m-d H:i', $eventStart);

        $to = DateTime::createFromFormat('Y-m-d H:i', $eventEnd);

        $link = Link::create($room->name, $from, $to)
            ->address('Ankerrui-2,-2018-Antwerpen' . '-' . $room->location);

        $linkedUsers = '';

        $linkedUsersEmails = '';

        $linkedUsersEmailsArray = null;

        $bookings = Booking::where('date', '=', $request->date)->where('room_id', $room->id)->where(function ($query) use($startTime, $endTime){
            $query->where([
                ['start_time', '>=', $startTime],
                ['start_time', '<', $endTime],
            ])->orWhere([
                ['start_time', '<=', $startTime],
                ['end_time', '>', $startTime],
            ]);
        })->count();

        if($bookings == 0)
        {

            if (now('CET')->format('Y-m-d') == $date && now('CET')->format('H:i') > $startTime) 
            {
                return response()->json([
                    "message" => "You cant book a room in the past!"
                ], 500);
            }

            else
            {
                //$json_array = json_encode();
                
                Booking::create([

                    'user_id' => $user->id,
                    'room_id' => $room->id,
                    'date' => $request->date,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'linked_users' => $request->linked_user,

                ]);

                Storage::disk('local')->put( Str::random(30) . '.ics', $link->ics());
        
                $data['ics'] = $link->ics();

                if ($request->linked_user == '[]') 
                {
                    $linkedUsers = null;

                    //Mail::to($to_email)->send(new BookingConfirmation($to_name, $roomName, $startTime, $endTime, $date, $linkedUsers, $data['ics']));
                }
                else
                {
                    foreach ($request->linked_user as $u) 
                    {
                        $linkedUsers .= User::where('id', $u)->value('name') . ', ';
                        $linkedUsersEmails .= User::where('id', $u)->value('email') . ', ';
                    }
                    $linkedUsers = trim($linkedUsers, ', ');
                    $linkedUsersEmails = trim($linkedUsersEmails, ', ');
                    $linkedUsersEmailsArray = explode(", ", $linkedUsersEmails);

                    //Mail::to($to_email)->cc($linkedUsersEmailsArray)->send(new BookingConfirmation($to_name, $roomName, $startTime, $endTime, $date, $linkedUsers, $data['ics']));
                }

                if (App::environment('production')) 
                {
                    Notification::send($user, new BookingNotification($to_name, $roomName, $startTime, $endTime, $date, $linkedUsers));
                }

                return response()->json([
                    "success" => true,
                    "message" => "Booking made successfully!",
                ]);
            }

        }


        return response()->json([
            "success" => false,
            "message" => 'Booking already exists during these hours!',
        ], 500);
    }

    public function apiGetBookingsList(){

        $user = Auth::user();
        $bookings = Booking::with('user')->with('room')->where('user_id', $user->id)->orWhere('linked_users', 'like', '%' . $user->id . '%')->where('deleted_at', null)->orderBy('created_at', 'desc')->get();

        //dd($user->id, $bookings);

        return response()->json([
            "success" => true,
            "user" => $user,
            "bookings" => $bookings,
        ], 200);

    }

    public function apiDeleteBooking($id)
    {
        $booking = Booking::whereId($id);
        $booking->forceDelete();

        return response()->json('The booking was successfully deleted');
    }

    public function apiExtendBooking($id)
    {
        $booking = Booking::with('user')->with('room')->where('id', $id)->firstOrFail();

        $bookedSlots = Booking::where('room_id', $booking->room_id)->where('date', '=', $booking->date)->orderBy('start_time', 'asc')->get();

        $slots = '';

        foreach ($bookedSlots as $b) {
            $slots .= $b->start_time . ' - ' . $b->end_time . ' | ';
        }
        $slots = trim($slots, ' | ');

        //dd($slots);

        return response()->json([
            "success" => true,
            "data" => $booking,
            "slots" => $slots,
        ], 200);
    }

    public function apiExtendBookingUpdate(ExtendBookingFormRequest $request, $id)
    {
        $endTime = $request->end_time;

        $startTime = $request->start_time;

        $user_id = $request->user_id;

        $room_id = $request->room_id;

        $date = $request->date;


        //$startTime = Booking::where('id', $id)->value('start_time');

        if ($startTime >= $endTime) 
        {

            return response()->json([
                "message" => "End time needs to be greater then the start time!"
            ], 500);

        }

        $bookings = Booking::where('date', '=', $date)
            ->where('room_id', $room_id)
            ->where('id', '!=', $id)
            ->where([
                ['start_time', '>', $startTime],
                ['start_time', '<', $endTime],
            ])
            ->count();

        if($bookings == 0)
        {

            Booking::whereId($id)->update([

                'end_time' => $request->end_time,

            ]);

            return response()->json([
                "success" => true,
                "message" => "Booking extended successfully",
            ], 200);

        }

        else
        {

            return response()->json([
                "success" => false,
                "message" => 'Booking already exists during these hours!',
            ], 500);

        }

    }

    public function apiGetBookedSlots(Request $request){

        $date = $request->get('date');

        $room_id = $request->get('room_id');

        $slots = '';

        $bookedSlots = Booking::where('room_id', $room_id)->where('date', '=', $date)->orderBy('start_time', 'asc')->get();

        if ($bookedSlots->count() == 0 ) {
            
            $slots .= '/';

            return response()->json([
                "success" => true,
                "slots" => $slots,
            ], 200);
        }

        if ($bookedSlots->count() > 0 ) {

            foreach ($bookedSlots as $b) {
                $slots .= $b->start_time . ' - ' . $b->end_time . ' | ';
            }
            $slots = trim($slots, ' | ');

            //dd($slots);

            return response()->json([
                "success" => true,
                "slots" => $slots,
            ], 200);

        }

    }

}