<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\ETicket;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketIssuedMail;

class ETicketService
{
  public function generateTicket(Booking $booking)
  {
    $tickets = [];

    foreach ($booking->members as $member) {
      $qrCodeString = 'MTX-TKT-' . $booking->kode_booking . '-' . $member->nik;

      // TODO: Generate QR Image dengan package 'simplesoftwareio/simple-qrcode'
      // $qrImage = QrCode::format('png')->size(200)->generate($qrCodeString);

      // TODO: Generate PDF dengan package 'barryvdh/laravel-dompdf'
      // $pdf = Pdf::loadView('tickets.pdf', compact('booking', 'member'));

      $ticket = ETicket::create([
        'booking_id' => $booking->id,
        'nama_lengkap' => $member->nama_lengkap,
        'qr_code' => $qrCodeString,
        'pdf_path' => 'dummy_path_pdf.pdf' // Sesuaikan jika upload file sudah dikonfigurasi
      ]);

      $tickets[] = $ticket;
    }

    $booking->update(['status' => 'ticket_issued']);

    try {
      Mail::to($booking->user->email)->send(new TicketIssuedMail($booking, $tickets));
    } catch (\Exception $e) {
      // Abaikan jika mail gagal (SMTP tidak di set local) 
      // Disarankan menggunakan Queue Job (ShouldQueue) di Mailable
      \Log::error('Gagal mengirim email tiket: ' . $e->getMessage());
    }

    return $tickets;
  }
}