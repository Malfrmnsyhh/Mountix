<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('pages.booking.index');
    }

    public function create()
    {
        return view('pages.booking.create');
    }

    public function show($id)
    {
        return view('pages.booking.show', compact('id'));
    }
}
