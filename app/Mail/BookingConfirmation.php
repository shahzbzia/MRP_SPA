<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $to_name;
    public $roomName;
    public $startTime;
    public $endTime;
    public $date;
    public $linkedUsers;
    public function __construct($to_name, $roomName, $startTime, $endTime, $date, $linkedUsers, $data)
    {
        $this->to_name = $to_name;
        $this->roomName = $roomName;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->date = $date;
        $this->linkedUsers = $linkedUsers;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->markdown('emails.bookingConfirmation')
                    ->attach($this->data, ['as' => 'reminder.ics', 'mime' => 'data:text charset=utf8']);
    }
}
