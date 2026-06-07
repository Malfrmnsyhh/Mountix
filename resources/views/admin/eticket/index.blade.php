@extends('admin.layouts.app')

@section('title', 'E-Ticket Management - Admin Mountix')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-neutral-dark">E-Ticket Issued</h1>
    <p class="text-neutral-dark/60">Daftar tiket digital yang telah diterbitkan sistem.</p>
</div>

<div class="bg-white rounded-3xl border border-neutral-light shadow-sm overflow-hidden">
    <!-- Filter & Search -->
    <div class="p-6 border-b border-neutral-light bg-neutral-light/20">
        <form action="{{ route('admin.eticket.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-grow">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-dark/40"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, QR code, atau kode booking..." class="w-full pl-12 pr-4 py-3 bg-white border border-neutral-light rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
            </div>
            <button type="submit" class="bg-neutral-dark text-white px-8 py-3 rounded-2xl font-bold hover:bg-neutral-dark/90 transition-all">
                Cari Tiket
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-neutral-light/50 text-[10px] font-bold uppercase tracking-wider text-neutral-dark/40">
                <tr>
                    <th class="px-6 py-4">QR Code / ID</th>
                    <th class="px-6 py-4">Nama Pendaki</th>
                    <th class="px-6 py-4">Gunung</th>
                    <th class="px-6 py-4 text-center">Booking</th>
                    <th class="px-6 py-4 text-right">Tgl Terbit</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-light">
                @forelse($tickets as $ticket)
                    <tr class="hover:bg-neutral-light/30 transition-colors">
                        <td class="px-6 py-4 font-mono text-xs font-bold text-primary">
                            {{ $ticket->qr_code }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-neutral-dark">{{ $ticket->nama_lengkap }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-neutral-dark">{{ $ticket->booking->jalur->gunung->nama }}</div>
                            <div class="text-[10px] text-neutral-dark/40">{{ $ticket->booking->jalur->nama_jalur }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.booking.show', $ticket->booking_id) }}" class="text-xs font-bold text-secondary hover:underline">{{ $ticket->booking->kode_booking }}</a>
                        </td>
                        <td class="px-6 py-4 text-right text-xs text-neutral-dark/60">
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.eticket.show', $ticket->id) }}" class="p-2 text-neutral-dark/40 hover:text-primary transition-all">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-neutral-dark/40 text-sm">Tidak ada data tiket ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($tickets->hasPages())
        <div class="p-6 border-t border-neutral-light bg-neutral-light/10">
            {{ $tickets->links() }}
        </div>
    @endif
</div>
@endsection
