<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gunung;
use App\Models\Jalur;
use Illuminate\Http\Request;

class AdminJalurController extends Controller
{
    public function index(Request $request)
    {
        $query = Jalur::with('gunung');

        if ($request->filled('gunung_id')) {
            $query->where('gunung_id', $request->gunung_id);
        }

        if ($request->filled('search')) {
            $query->where('nama_jalur', 'like', '%' . $request->search . '%')
                  ->orWhereHas('gunung', function($q) use ($request) {
                      $q->where('nama', 'like', '%' . $request->search . '%');
                  });
        }

        $jalurs = $query->paginate(10);
        $gunungs = Gunung::orderBy('nama')->get();

        return view('admin.jalur.index', compact('jalurs', 'gunungs'));
    }

    public function create(Request $request)
    {
        $gunungs = Gunung::orderBy('nama')->get();
        $selected_gunung_id = $request->gunung_id;
        return view('admin.jalur.create', compact('gunungs', 'selected_gunung_id'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gunung_id' => 'required|exists:gunungs,id',
            'nama_jalur' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_per_orang' => 'required|integer|min:0',
            'kuota_default' => 'required|integer|min:1',
            'estimasi_jam' => 'required|integer|min:1',
        ]);

        Jalur::create($validated);

        return redirect()->route('admin.jalur.index', ['gunung_id' => $request->gunung_id])
            ->with('success', 'Jalur pendakian berhasil ditambahkan.');
    }

    public function show(Jalur $jalur)
    {
        return redirect()->route('admin.gunung.show', $jalur->gunung_id);
    }

    public function edit(Jalur $jalur)
    {
        $gunungs = Gunung::orderBy('nama')->get();
        return view('admin.jalur.edit', compact('jalur', 'gunungs'));
    }

    public function update(Request $request, Jalur $jalur)
    {
        $validated = $request->validate([
            'gunung_id' => 'required|exists:gunungs,id',
            'nama_jalur' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_per_orang' => 'required|integer|min:0',
            'kuota_default' => 'required|integer|min:1',
            'estimasi_jam' => 'required|integer|min:1',
        ]);

        $jalur->update($validated);

        return redirect()->route('admin.jalur.index', ['gunung_id' => $request->gunung_id])
            ->with('success', 'Jalur pendakian berhasil diperbarui.');
    }

    public function destroy(Jalur $jalur)
    {
        // Check if has active bookings (simplified: just check existence)
        if ($jalur->bookings()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus jalur yang sudah memiliki data booking.');
        }

        $jalur->delete();

        return back()->with('success', 'Jalur pendakian berhasil dihapus.');
    }
}
