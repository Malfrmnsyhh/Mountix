<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create($booking_id)
    {
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get();
        return view('pages.payment.create', compact('booking_id', 'paymentMethods'));
    }

    public function success($booking_id)
    {
        return view('pages.payment.success', compact('booking_id'));
    }
}
