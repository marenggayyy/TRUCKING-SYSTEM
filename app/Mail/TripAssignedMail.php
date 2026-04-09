<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TripAssignedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $trip;
    public $person;

    public function __construct($trip, $person)
    {
        $this->trip = $trip;
        $this->person = $person;
    }

    public function build()
    {
        return $this->subject('New Trip Assigned')->view('emails.trip_assigned');
    }
}
