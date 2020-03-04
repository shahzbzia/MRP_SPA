<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;
use App\Http\Requests\Booking\CreateBookingRequest;
use Auth;

class BookingNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $to_name;
    public $roomName;
    public $startTime;
    public $endTime;
    public $date;
    public $linkedUsers;
    public function __construct($to_name, $roomName, $startTime, $endTime, $date, $linkedUsers)
    {
        $this->to_name = $to_name;
        $this->roomName = $roomName;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->date = $date;
        $this->linkedUsers = $linkedUsers;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */

    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable){

        $to_name = $this->to_name; 
        $roomName = $this->roomName; 
        $startTime = $this->startTime;
        $endTime = $this->endTime;
        $date =  $this->date;
        $linkedUsers =  $this->linkedUsers;

        if ($linkedUsers == null) {
            return (new SlackMessage)
            ->from('Meeting Room')
            ->to('#meeting-rooms')
            ->content('Room: "' . $roomName . '" has been booked by ' .$notifiable->name . ' on ' . $date . ' from ' . $startTime .  ' to ' . $endTime . '.' );
        }
        
        return (new SlackMessage)
            ->from('Meeting Room')
            ->to('#meeting-rooms')
            ->content('Room: "' . $roomName . '" has been booked by ' .$notifiable->name . ' on ' . $date . ' from ' . $startTime .  ' to ' . $endTime .' with the following linked users -> ' . $linkedUsers . '.' );

        

    }

}
