<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ETicketController extends Controller
{
    public function show($booking_id)
    {
        return view('pages.eticket.show', compact('booking_id'));
    }
}
