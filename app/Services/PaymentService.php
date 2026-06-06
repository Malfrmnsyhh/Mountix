<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Exception;

class PaymentService
{
  public function processPayment(Booking $booking, array $data)
  {
    return DB::transaction(function () use ($booking, $data) {
      if (!in_array($booking->status, ['draft', 'pending_upload'])) {
        throw new Exception("Booking tidak dapat dibayar pada status saat ini.");
      }

      // -- TODO: Integrasi Payment Gateway (Stripe/PayPal) dapat ditempatkan di sini --
      // $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
      // $charge = $stripe->charges->create([...]);

      $payment = Payment::create([
        'booking_id' => $booking->id,
        'tanggal_bayar' => now(),
        'jumlah_bayar' => $booking->total_bayar,
        'metode_pembayaran' => $data['metode_pembayaran'] ?? 'transfer',
        'bukti_bayar' => $data['bukti_bayar'] ?? null,
        'status_verifikasi' => 'pending' // Menunggu verifikasi admin atau webhook
      ]);

      $booking->update(['status' => 'waiting_verification']);

      return $payment;
    });
  }

  public function verifyPayment(Payment $payment, string $status)
  {
    return DB::transaction(function () use ($payment, $status) {
      $payment->update(['status_verifikasi' => $status]);

      if ($status === 'approved') {
        app(ETicketService::class)->generateTicket($payment->booking);
      } else {
        $payment->booking->update(['status' => 'rejected']);
        // TODO: Return kuota harian tiket karena ditolak
      }
      return $payment;
    });
  }
}