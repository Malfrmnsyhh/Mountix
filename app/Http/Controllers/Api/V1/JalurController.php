<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\JalurResource;
use App\Models\Gunung;
use App\Models\Jalur;
use Illuminate\Http\Request;

class JalurController extends Controller
{
  // Mengambil semua jalur berdasarkan ID Gunung spesifik
  public function index(Request $request, $gunung_id)
  {
    $gunung = Gunung::findOrFail($gunung_id);
    return JalurResource::collection($gunung->jalurs);
  }

  public function show($gunung_id, $jalur_id)
  {
    return new JalurResource(Jalur::where('gunung_id', $gunung_id)->findOrFail($jalur_id));
  }
}