<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
  protected $paymentService;

  public function __construct(PaymentService $paymentService)
  {
    $this->paymentService = $paymentService;
  }

  public function store(Request $request, Booking $booking)
  {
    $request->validate([
      'metode_pembayaran' => 'required|string',
      'bukti_bayar' => 'nullable|image|max:2048'
    ]);

    if ($booking->user_id !== auth('api')->id()) {
      return response()->json(['message' => 'Unauthorized'], 403);
    }

    try {
      $data = $request->only('metode_pembayaran');
      if ($request->hasFile('bukti_bayar')) {
        $data['bukti_bayar'] = $request->file('bukti_bayar')->store('payments', 'public');
      }

      $payment = $this->paymentService->processPayment($booking, $data);
      return response()->json(['message' => 'Pembayaran berhasil diproses, menunggu verifikasi', 'data' => $payment], 201);
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  public function verify(Request $request, Payment $payment)
  {
    $request->validate(['status' => 'required|in:approved,rejected']);

    $payment = $this->paymentService->verifyPayment($payment, $request->status);

    return response()->json(['message' => "Pembayaran berhasil di-{$request->status} dan E-Ticket otomatis dikirim jika approved", 'data' => $payment]);
  }
}