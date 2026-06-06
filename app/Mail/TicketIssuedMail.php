<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketIssuedMail extends Mailable
{
  use Queueable, SerializesModels;

  public $booking;
  public $tickets;

  public function __construct(Booking $booking, array $tickets)
  {
    $this->booking = $booking;
    $this->tickets = $tickets;
  }

  public function build()
  {
    return $this->subject('E-Ticket Pendakian Gunung Mountix: ' . $this->booking->kode_booking)
      ->view('emails.ticket')
      ->with([
        'booking' => $this->booking,
        'tickets' => $this->tickets
      ]);
  }
}