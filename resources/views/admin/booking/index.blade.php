@extends('admin.layouts.app')

@section('title', 'Manajemen Booking - Admin Mountix')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-neutral-dark">Manajemen Booking</h1>
    <p class="text-neutral-dark/60">Pantau dan kelola semua reservasi pendakian.</p>
</div>

<div class="bg-white rounded-3xl border border-neutral-light shadow-sm overflow-hidden">
    <!-- Filter & Search -->
    <div class="p-6 border-b border-neutral-light bg-neutral-light/20">
        <form action="{{ route('admin.booking.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-grow">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-dark/40"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode booking atau nama pendaki..." class="w-full pl-12 pr-4 py-3 bg-white border border-neutral-light rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
            </div>
            <div class="md:w-64">
                <select name="status" class="w-full px-4 py-3 bg-white border border-neutral-light rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none">
                    <option value="">Semua Status</option>
                    @foreach(['draft', 'pending_upload', 'waiting_verification', 'verified', 'completed', 'cancelled', 'rejected'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ strtoupper(str_replace('_', ' ', $st)) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-neutral-dark text-white px-8 py-3 rounded-2xl font-bold hover:bg-neutral-dark/90 transition-all">
                Filter
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.booking.index') }}" class="bg-neutral-light text-neutral-dark px-6 py-3 rounded-2xl font-bold hover:bg-neutral-dark/10 transition-all flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-neutral-light/50 text-[10px] font-bold uppercase tracking-wider text-neutral-dark/40">
                <tr>
                    <th class="px-6 py-4">Booking</th>
                    <th class="px-6 py-4">Gunung/Jalur</th>
                    <th class="px-6 py-4 text-center">Tgl Naik</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Total</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-light">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-neutral-light/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-mono text-xs font-bold text-primary mb-1">{{ $booking->kode_booking }}</div>
                            <div class="text-sm font-bold text-neutral-dark">{{ $booking->user->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-neutral-dark">{{ $booking->jalur->gunung->nama }}</div>
                            <div class="text-[10px] text-neutral-dark/40">{{ $booking->jalur->nama_jalur }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="text-sm font-bold text-neutral-dark">{{ \Carbon\Carbon::parse($booking->tanggal_naik)->format('d M Y') }}</div>
                            <div class="text-[10px] text-neutral-dark/40">{{ $booking->jumlah_orang }} Orang</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusColors = [
                                    'draft' => 'bg-neutral-light text-neutral-dark/60',
                                    'pending_upload' => 'bg-warning/10 text-warning',
                                    'waiting_verification' => 'bg-secondary/10 text-secondary',
                                    'verified' => 'bg-success/10 text-success',
                                    'ticket_issued' => 'bg-primary/10 text-primary',
                                    'completed' => 'bg-success text-white',
                                    'cancelled' => 'bg-danger/10 text-danger',
                                    'rejected' => 'bg-danger text-white',
                                ];
                                $statusColor = $statusColors[$booking->status] ?? 'bg-neutral-light';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter {{ $statusColor }} border border-transparent">
                                {{ str_replace('_', ' ', $booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-black text-neutral-dark">
                            Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.booking.show', $booking->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-neutral-light hover:bg-primary hover:text-white text-neutral-dark text-xs font-bold rounded-xl transition-all">
                                Detail <i data-lucide="chevron-right" class="w-3 h-3"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-neutral-dark/40 text-sm">Tidak ada data booking ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($bookings->hasPages())
        <div class="p-6 border-t border-neutral-light bg-neutral-light/10">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection
