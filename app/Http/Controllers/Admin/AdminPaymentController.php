<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['booking.user', 'booking.jalur.gunung']);

        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('booking', function($q) use ($request) {
                $q->where('kode_booking', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($qu) use ($request) {
                      $qu->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.payment.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking.user', 'booking.jalur.gunung']);
        return view('admin.payment.show', compact('payment'));
    }

    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $paymentService = app(PaymentService::class);
        $paymentService->verifyPayment($payment, $request->status);

        return redirect()->route('admin.payment.index')->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
