<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GunungController extends Controller
{
    public function index()
    {
        return view('pages.gunung.index');
    }

    public function show($id)
    {
        return view('pages.gunung.show', compact('id'));
    }
}
