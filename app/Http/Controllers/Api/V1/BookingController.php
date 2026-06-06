<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
  protected $bookingService;

  public function __construct(BookingService $bookingService)
  {
    $this->bookingService = $bookingService;
  }

  public function index(Request $request)
  {
    $user = auth('api')->user();
    $query = Booking::with(['jalur.gunung']);

    // Jika user bukan admin, hanya bisa melihat booking miliknya sendiri
    if ($user->role !== 'admin') {
      $query->where('user_id', $user->id);
    }

    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    $bookings = $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 10));
    return BookingResource::collection($bookings);
  }

  public function store(Request $request)
  {
    $request->validate([
      'jalur_id' => 'required|exists:jalurs,id',
      'tanggal_naik' => 'required|date|after_or_equal:today',
      'tanggal_turun' => 'required|date|after_or_equal:tanggal_naik',
      'members' => 'required|array|min:1',
      'members.*.nama_lengkap' => 'required|string',
      'members.*.nik' => 'required|string|size:16',
      'members.*.tanggal_lahir' => 'required|date',
      'members.*.jenis_kelamin' => 'required|in:L,P',
      'members.*.alamat' => 'required|string',
      // KTP/Surat Sehat disederhanakan sebagai string/path (Anda bisa expand dengan file upload nanti)
      'members.*.ktp_path' => 'nullable|string',
      'members.*.surat_sehat_path' => 'nullable|string',
    ]);

    try {
      $booking = $this->bookingService->createBooking(auth('api')->user(), $request->all());
      $booking->load('jalur.gunung');
      return (new BookingResource($booking))->additional(['message' => 'Booking berhasil dibuat']);

    } catch (\Exception $e) {
      return response()->json(['message' => 'Gagal membuat booking: ' . $e->getMessage()], 400);
    }
  }

  public function ticket(Booking $booking)
  {
    if ($booking->user_id !== auth('api')->id() && auth('api')->user()->role !== 'admin') {
      return response()->json(['message' => 'Unauthorized'], 403);
    }

    $booking->load('eTickets');
    return response()->json(['data' => $booking->eTickets]);
  }
}