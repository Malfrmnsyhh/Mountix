<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\ETicketService;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'jalur.gunung']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('kode_booking', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.booking.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'jalur.gunung', 'members', 'payment']);
        return view('admin.booking.show', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,pending_upload,waiting_verification,verified,ticket_issued,completed,cancelled,rejected',
            'catatan_admin' => 'nullable|string',
        ]);

        $booking->update($validated);

        // Logic auto generate ticket if status verified -> ticket_issued
        if ($validated['status'] === 'ticket_issued' && $booking->getOriginal('status') !== 'ticket_issued') {
            app(ETicketService::class)->generateTicket($booking);
        }

        return redirect()->route('admin.booking.show', $booking->id)->with('success', 'Status booking berhasil diperbarui.');
    }
}
