<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gunung;
use Illuminate\Http\Request;

class AdminGunungPopulerController extends Controller
{
    public function index()
    {
        $gunungs = Gunung::orderBy('nama')->get();
        $popularCount = Gunung::where('is_popular', true)->count();
        
        return view('admin.gunung_populer.index', compact('gunungs', 'popularCount'));
    }

    public function toggle(Request $request, Gunung $gunung)
    {
        $gunung->update([
            'is_popular' => !$gunung->is_popular
        ]);

        $status = $gunung->is_popular ? 'diaktifkan' : 'dinonaktifkan';
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Status populer untuk {$gunung->nama} berhasil {$status}.",
                'is_popular' => $gunung->is_popular
            ]);
        }

        return redirect()->back()->with('success', "Status populer untuk {$gunung->nama} berhasil {$status}.");
    }
}
