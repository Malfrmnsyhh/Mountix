<?php

namespace App\Http\Controllers;

use App\Models\Gunung;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $popularMountains = Gunung::with('jalurs')
            ->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->limit(6)
            ->get();

        return view('pages.home', compact('popularMountains'));
    }
}
