<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        return view('pages.profile.show');
    }

    public function edit()
    {
        return view('pages.profile.edit');
    }
}
