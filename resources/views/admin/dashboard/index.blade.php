@extends('admin.layouts.app')

@section('title', 'Dashboard - Admin Mountix')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-neutral-dark">Overview</h1>
    <p class="text-neutral-dark/60">Selamat datang kembali, <span class="font-bold text-primary">{{ auth()->user()->name }}</span>.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <x-admin.stats-card 
        title="Total Gunung" 
        :value="$totalGunung" 
        icon="mountain" 
        color="primary" 
    />
    <x-admin.stats-card 
        title="Booking Hari Ini" 
        :value="$bookingHariIni" 
        icon="calendar-days" 
        color="secondary" 
    />
    <x-admin.stats-card 
        title="Total Revenue" 
        value="Rp {{ number_format($totalRevenue, 0, ',', '.') }}" 
        icon="banknote" 
        color="success" 
    />
    <x-admin.stats-card 
        title="Pending Payment" 
        :value="$pendingPayments" 
        icon="clock" 
        color="warning" 
    />
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Bookings -->
    <div class="lg:col-span-2 bg-white rounded-3xl border border-neutral-light shadow-sm overflow-hidden">
        <div class="p-6 border-b border-neutral-light flex items-center justify-between">
            <h3 class="font-bold text-neutral-dark flex items-center gap-2">
                <i data-lucide="history" class="w-5 h-5 text-primary"></i>
                Booking Terbaru
            </h3>
            <a href="{{ route('admin.booking.index') }}" class="text-xs font-bold text-primary hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-neutral-light/50 text-[10px] font-bold uppercase tracking-wider text-neutral-dark/40">
                    <tr>
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Pendaki</th>
                        <th class="px-6 py-4">Gunung</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-light">
                    @forelse($recentBookings as $booking)
                        <tr class="hover:bg-neutral-light/30 transition-colors">
                            <td class="px-6 py-4 font-mono text-xs font-bold text-primary">{{ $booking->kode_booking }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-neutral-dark">{{ $booking->user->name }}</div>
                                <div class="text-[10px] text-neutral-dark/40">{{ $booking->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-dark/70">
                                {{ $booking->jalur->gunung->nama }}
                            </td>
                            <td class="px-6 py-4">
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
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter {{ $statusColor }}">
                                    {{ str_replace('_', ' ', $booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-neutral-dark">
                                Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-neutral-dark/40 text-sm">Belum ada data booking.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="space-y-6">
        <div class="bg-white p-6 rounded-3xl border border-neutral-light shadow-sm">
            <h3 class="font-bold text-neutral-dark mb-6 flex items-center gap-2">
                <i data-lucide="zap" class="w-5 h-5 text-secondary"></i>
                Aksi Cepat
            </h3>
            <div class="grid grid-cols-1 gap-3">
                <a href="{{ route('admin.gunung.create') }}" class="flex items-center gap-3 p-4 bg-primary/5 hover:bg-primary/10 text-primary rounded-2xl transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i data-lucide="plus" class="w-5 h-5"></i>
                    </div>
                    <span class="font-bold text-sm">Tambah Gunung</span>
                </a>
                <a href="{{ route('admin.jalur.create') }}" class="flex items-center gap-3 p-4 bg-secondary/5 hover:bg-secondary/10 text-secondary rounded-2xl transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-secondary text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                    </div>
                    <span class="font-bold text-sm">Tambah Jalur</span>
                </a>
            </div>
        </div>

        <!-- System Info -->
        <div class="bg-neutral-dark p-6 rounded-3xl text-white shadow-xl shadow-primary/10">
            <h3 class="font-bold mb-4 flex items-center gap-2">
                <i data-lucide="info" class="w-5 h-5 text-secondary"></i>
                System Info
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between text-xs">
                    <span class="text-white/60">Laravel Version</span>
                    <span class="font-mono">v{{ app()->version() }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-white/60">PHP Version</span>
                    <span class="font-mono">v{{ phpversion() }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-white/60">Environment</span>
                    <span class="font-bold uppercase text-secondary">{{ app()->environment() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
