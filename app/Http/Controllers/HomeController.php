<?php

namespace App\Http\Controllers;

use App\Models\Gunung;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $popularMountains = Gunung::with('jalurs')
            ->where('is_popular', true)
            ->latest()
            ->limit(6)
            ->get();
            
        // Fallback jika belum ada yang di-set popular
        if ($popularMountains->isEmpty()) {
            $popularMountains = Gunung::with('jalurs')
                ->withCount('bookings')
                ->orderBy('bookings_count', 'desc')
                ->limit(6)
                ->get();
        }

        return view('pages.home', compact('popularMountains'));
    }
}
