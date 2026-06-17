@extends('admin.layouts.app')

@section('title', 'Detail Booking - Admin Mountix')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.booking.index') }}" class="text-xs font-bold text-neutral-dark/40 hover:text-primary transition-all flex items-center gap-1 mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
    </a>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-neutral-dark">Booking: {{ $booking->kode_booking }}</h1>
            <p class="text-neutral-dark/60">Dibuat pada {{ $booking->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div>
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
            <span class="px-6 py-2 rounded-2xl text-xs font-black uppercase tracking-widest {{ $statusColor }} border border-transparent shadow-lg shadow-neutral-dark/5">
                {{ str_replace('_', ' ', $booking->status) }}
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-neutral-light shadow-sm">
                <h3 class="text-[10px] font-bold text-neutral-dark/40 uppercase tracking-widest mb-4">Informasi Pendakian</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-dark/60">Gunung</span>
                        <span class="text-sm font-bold text-neutral-dark">{{ $booking->jalur->gunung->nama }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-dark/60">Jalur</span>
                        <span class="text-sm font-bold text-neutral-dark">{{ $booking->jalur->nama_jalur }}</span>
                    </div>
                    <div class="flex justify-between pt-3 border-t border-neutral-light">
                        <span class="text-sm text-neutral-dark/60">Tanggal Naik</span>
                        <span class="text-sm font-bold text-primary">{{ \Carbon\Carbon::parse($booking->tanggal_naik)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-dark/60">Tanggal Turun</span>
                        <span class="text-sm font-bold text-primary">{{ \Carbon\Carbon::parse($booking->tanggal_turun)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-neutral-light shadow-sm">
                <h3 class="text-[10px] font-bold text-neutral-dark/40 uppercase tracking-widest mb-4">Informasi Kontak</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-dark/60">Nama User</span>
                        <span class="text-sm font-bold text-neutral-dark">{{ $booking->user->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-dark/60">Email</span>
                        <span class="text-sm font-bold text-neutral-dark">{{ $booking->user->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-dark/60">Telepon</span>
                        <span class="text-sm font-bold text-neutral-dark">{{ $booking->user->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Members Table -->
        <div class="bg-white rounded-3xl border border-neutral-light shadow-sm overflow-hidden">
            <div class="p-6 border-b border-neutral-light flex items-center justify-between">
                <h3 class="font-bold text-neutral-dark flex items-center gap-2">
                    <i data-lucide="users" class="w-5 h-5 text-primary"></i>
                    Daftar Peserta ({{ $booking->jumlah_orang }} Orang)
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-neutral-light/50 text-[10px] font-bold uppercase tracking-wider text-neutral-dark/40">
                        <tr>
                            <th class="px-6 py-4">Nama Lengkap</th>
                            <th class="px-6 py-4">NIK</th>
                            <th class="px-6 py-4 text-center">Gender</th>
                            <th class="px-6 py-4 text-right">Tgl Lahir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-light">
                        @foreach($booking->members as $member)
                            <tr class="hover:bg-neutral-light/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-neutral-dark">{{ $member->nama_lengkap }}</div>
                                    <div class="text-[10px] text-neutral-dark/40">{{ $member->alamat }}</div>
                                </td>
                                <td class="px-6 py-4 font-mono text-xs">{{ $member->nik }}</td>
                                <td class="px-6 py-4 text-center text-xs font-bold">{{ $member->jenis_kelamin }}</td>
                                <td class="px-6 py-4 text-right text-xs">{{ \Carbon\Carbon::parse($member->tanggal_lahir)->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sidebar Info & Actions -->
    <div class="space-y-8">
        <!-- Update Status -->
        <div class="bg-white p-8 rounded-3xl border border-neutral-light shadow-sm space-y-6">
            <h3 class="font-black text-neutral-dark flex items-center gap-2">
                <i data-lucide="settings" class="w-5 h-5 text-secondary"></i>
                Kelola Status
            </h3>
            <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[10px] font-bold text-neutral-dark uppercase tracking-wider mb-2">Pilih Status Baru</label>
                    <select name="status" class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all appearance-none">
                        @foreach(['draft', 'pending_upload', 'waiting_verification', 'verified', 'completed', 'cancelled', 'rejected'] as $st)
                            <option value="{{ $st }}" {{ $booking->status == $st ? 'selected' : '' }}>{{ strtoupper(str_replace('_', ' ', $st)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-neutral-dark uppercase tracking-wider mb-2">Catatan Admin (Opsional)</label>
                    <textarea name="catatan_admin" rows="3" class="w-full px-4 py-3 bg-neutral-light border border-transparent rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white outline-none transition-all">{{ $booking->catatan_admin }}</textarea>
                </div>
                <button type="submit" class="w-full py-4 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                    Perbarui Status
                </button>
            </form>
        </div>

        <!-- Payment Info -->
        @if($booking->payment)
            <div class="bg-white p-8 rounded-3xl border border-neutral-light shadow-sm space-y-6">
                <h3 class="font-black text-neutral-dark flex items-center gap-2">
                    <i data-lucide="credit-card" class="w-5 h-5 text-success"></i>
                    Pembayaran
                </h3>
                <div class="aspect-square bg-neutral-light rounded-2xl overflow-hidden cursor-pointer hover:opacity-90 transition-all border border-neutral-light" onclick="window.open('{{ asset('storage/' . $booking->payment->bukti_bayar) }}', '_blank')">
                    <img src="{{ asset('storage/' . $booking->payment->bukti_bayar) }}" class="w-full h-full object-cover">
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-xs">
                        <span class="text-neutral-dark/60">Metode</span>
                        <span class="font-bold">{{ $booking->payment->metode_pembayaran }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-neutral-dark/60">Jumlah</span>
                        <span class="font-black text-success">Rp {{ number_format($booking->payment->jumlah_bayar, 0, ',', '.') }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.payment.show', $booking->payment->id) }}" class="block w-full py-3 bg-neutral-light text-neutral-dark text-center font-bold rounded-2xl hover:bg-neutral-dark/10 transition-all">
                    Verifikasi Pembayaran
                </a>
            </div>
        @else
            <div class="bg-warning/5 p-8 rounded-3xl border border-warning/10 text-center">
                <i data-lucide="alert-circle" class="w-10 h-10 text-warning/40 mx-auto mb-4"></i>
                <p class="text-xs font-bold text-warning/60">Belum ada data pembayaran diunggah.</p>
            </div>
        @endif
    </div>
</div>
@endsection
