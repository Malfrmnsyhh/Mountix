<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\GunungRequest;
use App\Http\Resources\V1\GunungResource;
use App\Models\Gunung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GunungController extends Controller
{
  /**
   * Menampilkan daftar gunung dengan fitur filtering, sorting, dan pagination.
   */
  public function index(Request $request)
  {
    $query = Gunung::query();

    // Filtering
    if ($request->filled('nama')) {
      $query->where('nama', 'like', '%' . $request->nama . '%');
    }
    if ($request->filled('lokasi')) {
      $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
    }
    if ($request->has('status_buka')) {
      $query->where('status_buka', $request->boolean('status_buka'));
    }

    // Sorting
    $sortBy = $request->get('sort_by', 'nama');
    $sortDir = $request->get('sort_dir', 'asc');
    $query->orderBy($sortBy, $sortDir);

    // Pagination (default 10 per page)
    $gunungs = $query->paginate($request->get('per_page', 10));

    return GunungResource::collection($gunungs);
  }

  public function store(GunungRequest $request)
  {
    $data = $request->validated();

    if ($request->hasFile('foto_cover')) {
      $data['foto_cover'] = $request->file('foto_cover')->store('gunung_covers', 'public');
    }

    $gunung = Gunung::create($data);

    return response()->json([
      'message' => 'Data gunung berhasil ditambahkan',
      'data' => new GunungResource($gunung)
    ], 201);
  }

  public function show(Gunung $gunung)
  {
    // Load relasi jalur agar muncul di output response
    $gunung->load('jalurs');
    return new GunungResource($gunung);
  }

  public function update(GunungRequest $request, Gunung $gunung)
  {
    $data = $request->validated();

    if ($request->hasFile('foto_cover')) {
      if ($gunung->foto_cover)
        Storage::disk('public')->delete($gunung->foto_cover);
      $data['foto_cover'] = $request->file('foto_cover')->store('gunung_covers', 'public');
    }

    $gunung->update($data);
    return new GunungResource($gunung);
  }
}