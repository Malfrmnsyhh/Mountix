@extends('admin.layouts.app')

@section('title', 'Monitor Pembayaran - Admin Mountix')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-neutral-dark">Monitor Pembayaran</h1>
    <p class="text-neutral-dark/60">Verifikasi bukti bayar.</p>
</div>

<div class="bg-white rounded-3xl border border-neutral-light shadow-sm overflow-hidden">
    <!-- Filter & Search -->
    <div class="p-6 border-b border-neutral-light bg-neutral-light/20">
        <form action="{{ route('admin.payment.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-grow">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-dark/40"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode booking atau nama pendaki..." class="w-full pl-12 pr-4 py-3 bg-white border border-neutral-light rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
            </div>
            <div class="md:w-64">
                <select name="status" class="w-full px-4 py-3 bg-white border border-neutral-light rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>PENDING</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>APPROVED</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>REJECTED</option>
                </select>
            </div>
            <button type="submit" class="bg-neutral-dark text-white px-8 py-3 rounded-2xl font-bold hover:bg-neutral-dark/90 transition-all">
                Filter
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-neutral-light/50 text-[10px] font-bold uppercase tracking-wider text-neutral-dark/40">
                <tr>
                    <th class="px-6 py-4">Tgl Bayar</th>
                    <th class="px-6 py-4">Booking</th>
                    <th class="px-6 py-4">Pendaki</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Jumlah</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-light">
                @forelse($payments as $payment)
                    <tr class="hover:bg-neutral-light/30 transition-colors">
                        <td class="px-6 py-4 text-sm text-neutral-dark/60">
                            {{ \Carbon\Carbon::parse($payment->tanggal_bayar)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 font-mono text-xs font-bold text-primary">
                            {{ $payment->booking->kode_booking }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-neutral-dark">{{ $payment->booking->user->name }}</div>
                            <div class="text-[10px] text-neutral-dark/40">{{ $payment->metode_pembayaran }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-warning/10 text-warning',
                                    'approved' => 'bg-success/10 text-success',
                                    'rejected' => 'bg-danger/10 text-danger',
                                ];
                                $statusColor = $statusColors[$payment->status_verifikasi] ?? 'bg-neutral-light';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter {{ $statusColor }} border border-transparent">
                                {{ $payment->status_verifikasi }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-black text-neutral-dark">
                            Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.payment.show', $payment->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-neutral-light hover:bg-secondary hover:text-white text-neutral-dark text-xs font-bold rounded-xl transition-all">
                                Periksa <i data-lucide="zoom-in" class="w-3 h-3"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-neutral-dark/40 text-sm">Tidak ada data pembayaran ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($payments->hasPages())
        <div class="p-6 border-t border-neutral-light bg-neutral-light/10">
            {{ $payments->links() }}
        </div>
    @endif
</div>
@endsection
