<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PayrollReadyMail extends Mailable
{
    public $person;
    public $rows;
    public $amount;
    public $weekStart;
    public $weekEnd;

    public function __construct($person, $rows, $amount, $weekStart, $weekEnd)
    {
        $this->person = $person;
        $this->rows = $rows;
        $this->amount = $amount;
        $this->weekStart = $weekStart;
        $this->weekEnd = $weekEnd;
    }
    public function build()
    {
        return $this->subject('Payroll Ready')->view('emails.payroll_ready');
    }
}
