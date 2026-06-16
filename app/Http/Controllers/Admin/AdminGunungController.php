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

        try {
            if ($request->hasFile('foto_cover')) {
                $validated['foto_cover'] = $request->file('foto_cover')->store('gunung', 'public');
            }

            Gunung::create($validated);

            return redirect()->route('admin.gunung.index')->with('success', 'Data gunung berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
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

        try {
            if ($request->hasFile('foto_cover')) {
                if ($gunung->foto_cover && !filter_var($gunung->foto_cover, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($gunung->foto_cover);
                }
                $validated['foto_cover'] = $request->file('foto_cover')->store('gunung', 'public');
            }

            $gunung->update($validated);

            return redirect()->route('admin.gunung.index')->with('success', 'Data gunung berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(Gunung $gunung)
    {
        try {
            // Cek apakah ada booking yang terhubung ke jalur-jalur di gunung ini
            $hasBookings = \App\Models\Booking::whereIn('jalur_id', $gunung->jalurs()->pluck('id'))->exists();
            if ($hasBookings) {
                return redirect()->route('admin.gunung.index')->with('error', 'Gagal menghapus data gunung: Terdapat riwayat booking pada jalur gunung ini. Silakan ubah "Status" menjadi Tutup sebagai gantinya.');
            }

            if ($gunung->foto_cover && !filter_var($gunung->foto_cover, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($gunung->foto_cover);
            }
            
            $gunung->delete();

            return redirect()->route('admin.gunung.index')->with('success', 'Data gunung berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->route('admin.gunung.index')->with('error', 'Gagal menghapus data gunung: Data ini masih terkait dengan data lain di sistem.');
            }
            return redirect()->route('admin.gunung.index')->with('error', 'Gagal menghapus data gunung: Terjadi kesalahan pada database.');
        } catch (\Exception $e) {
            return redirect()->route('admin.gunung.index')->with('error', 'Gagal menghapus data gunung: Terjadi kesalahan sistem.');
        }
    }
}
