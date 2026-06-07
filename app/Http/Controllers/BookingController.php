<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()->bookings()->with(['jalur.gunung', 'payment'])->latest()->get();
        return view('pages.booking.index', compact('bookings'));
    }

    public function create()
    {
        return view('pages.booking.create');
    }

    public function show($id)
    {
        $booking = auth()->user()->bookings()->with(['jalur.gunung', 'members', 'payment'])->findOrFail($id);
        return view('pages.booking.show', compact('booking'));
    }
}
