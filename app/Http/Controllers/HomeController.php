<?php

namespace App\Http\Controllers;

use App\Models\Gunung;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $popularMountains = Gunung::with('jalurs')->limit(3)->get();
        return view('pages.home', compact('popularMountains'));
    }
}
