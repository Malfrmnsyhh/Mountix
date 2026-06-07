<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Gunung;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalGunung = Gunung::count();
        $totalBooking = Booking::count();
        $totalRevenue = Payment::where('status_verifikasi', 'approved')->sum('jumlah_bayar');
        $bookingHariIni = Booking::whereDate('created_at', today())->count();
        $pendingPayments = Payment::where('status_verifikasi', 'pending')->count();

        $recentBookings = Booking::with(['user', 'jalur.gunung'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalGunung',
            'totalBooking',
            'totalRevenue',
            'bookingHariIni',
            'pendingPayments',
            'recentBookings'
        ));
    }
}
