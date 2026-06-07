<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gunung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGunungController extends Controller
{
    public function index(Request $request)
    {
        $query = Gunung::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $request->search . '%');
        }

        $gunungs = $query->withCount('jalurs')->paginate(10);

        return view('admin.gunung.index', compact('gunungs'));
    }

    public function create()
    {
        return view('admin.gunung.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'ketinggian' => 'required|integer',
            'syarat_pendakian' => 'required|string',
            'deskripsi' => 'required|string',
            'status_buka' => 'required|boolean',
            'foto_cover' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto_cover')) {
            $validated['foto_cover'] = $request->file('foto_cover')->store('gunung', 'public');
        }

        Gunung::create($validated);

        return redirect()->route('admin.gunung.index')->with('success', 'Data gunung berhasil ditambahkan.');
    }

    public function show(Gunung $gunung)
    {
        $gunung->load('jalurs');
        return view('admin.gunung.show', compact('gunung'));
    }

    public function edit(Gunung $gunung)
    {
        return view('admin.gunung.edit', compact('gunung'));
    }

    public function update(Request $request, Gunung $gunung)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'ketinggian' => 'required|integer',
            'syarat_pendakian' => 'required|string',
            'deskripsi' => 'required|string',
            'status_buka' => 'required|boolean',
            'foto_cover' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto_cover')) {
            if ($gunung->foto_cover) {
                Storage::disk('public')->delete($gunung->foto_cover);
            }
            $validated['foto_cover'] = $request->file('foto_cover')->store('gunung', 'public');
        }

        $gunung->update($validated);

        return redirect()->route('admin.gunung.index')->with('success', 'Data gunung berhasil diperbarui.');
    }

    public function destroy(Gunung $gunung)
    {
        if ($gunung->foto_cover) {
            Storage::disk('public')->delete($gunung->foto_cover);
        }
        
        $gunung->delete();

        return redirect()->route('admin.gunung.index')->with('success', 'Data gunung berhasil dihapus.');
    }
}
