@extends('admin.layouts.app')

@section('title', 'Detail User - Admin Mountix')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-neutral-dark/40 hover:text-primary transition-all flex items-center gap-1 mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
    </a>
    <h1 class="text-3xl font-black text-neutral-dark">Profil Pengguna</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- User Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-white p-8 rounded-3xl border border-neutral-light shadow-sm text-center space-y-6">
            <div class="w-32 h-32 rounded-full bg-secondary/10 flex items-center justify-center text-secondary text-4xl font-black mx-auto border-4 border-white shadow-xl">
                {{ substr($user->name, 0, 2) }}
            </div>
            <div>
                <h2 class="text-xl font-black text-neutral-dark">{{ $user->name }}</h2>
                <p class="text-neutral-dark/40 text-sm font-medium">{{ $user->email }}</p>
            </div>
            <div class="flex justify-center gap-2">
                @if($user->role === 'admin')
                    <span class="bg-primary/10 text-primary text-[10px] font-black uppercase px-4 py-1 rounded-full border border-primary/20 tracking-widest">Administrator</span>
                @else
                    <span class="bg-secondary/10 text-secondary text-[10px] font-black uppercase px-4 py-1 rounded-full border border-secondary/20 tracking-widest">Pendaki</span>
                @endif
            </div>
            <div class="pt-6 border-t border-neutral-light grid grid-cols-2 gap-4">
                <div class="text-center">
                    <div class="text-xl font-black text-primary">{{ $user->bookings->count() }}</div>
                    <div class="text-[10px] font-bold text-neutral-dark/40 uppercase">Total Booking</div>
                </div>
                <div class="text-center">
                    <div class="text-xl font-black text-secondary">{{ $user->bookings->where('status', 'completed')->count() }}</div>
                    <div class="text-[10px] font-bold text-neutral-dark/40 uppercase">Selesai</div>
                </div>
            </div>
            <div class="pt-6 space-y-3">
                <div class="flex justify-between text-xs">
                    <span class="text-neutral-dark/40">Telepon</span>
                    <span class="font-bold">{{ $user->phone ?? '-' }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-neutral-dark/40">Tgl Bergabung</span>
                    <span class="font-bold">{{ $user->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- User Booking History -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-3xl border border-neutral-light shadow-sm overflow-hidden">
            <div class="p-6 border-b border-neutral-light">
                <h3 class="font-bold text-neutral-dark flex items-center gap-2">
                    <i data-lucide="history" class="w-5 h-5 text-primary"></i>
                    Riwayat Booking
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-neutral-light/50 text-[10px] font-bold uppercase tracking-wider text-neutral-dark/40">
                        <tr>
                            <th class="px-6 py-4">Kode</th>
                            <th class="px-6 py-4">Gunung</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-light">
                        @forelse($user->bookings as $booking)
                            <tr class="hover:bg-neutral-light/30 transition-colors">
                                <td class="px-6 py-4 font-mono text-xs font-bold text-primary">{{ $booking->kode_booking }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-neutral-dark">{{ $booking->jalur->gunung->nama }}</div>
                                    <div class="text-[10px] text-neutral-dark/40">{{ \Carbon\Carbon::parse($booking->tanggal_naik)->format('d/m/Y') }}</div>
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
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $statusColor }}">
                                        {{ str_replace('_', ' ', $booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.booking.show', $booking->id) }}" class="p-2 text-neutral-dark/40 hover:text-primary transition-all">
                                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-neutral-dark/40 text-sm">User belum pernah melakukan booking.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
