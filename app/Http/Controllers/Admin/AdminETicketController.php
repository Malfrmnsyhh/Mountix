<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ETicket;
use Illuminate\Http\Request;

class AdminETicketController extends Controller
{
    public function index(Request $request)
    {
        $query = ETicket::with(['booking.user', 'booking.jalur.gunung']);

        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('qr_code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('booking', function($q) use ($request) {
                      $q->where('kode_booking', 'like', '%' . $request->search . '%');
                  });
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.eticket.index', compact('tickets'));
    }

    public function show(ETicket $eticket)
    {
        $eticket->load(['booking.user', 'booking.jalur.gunung']);
        return view('admin.eticket.show', compact('eticket'));
    }
}
