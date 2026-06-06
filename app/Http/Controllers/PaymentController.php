<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create($booking_id)
    {
        return view('pages.payment.create', compact('booking_id'));
    }

    public function success($booking_id)
    {
        return view('pages.payment.success', compact('booking_id'));
    }
}
