@extends('admin.layouts.app')

@section('title', 'Metode Pembayaran - Admin Mountix')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-black text-neutral-dark">Metode Pembayaran</h1>
        <p class="text-neutral-dark/60">Kelola akun bank dan QRIS untuk pembayaran manual user.</p>
    </div>
    <a href="{{ route('admin.payment-method.create') }}" class="bg-primary text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2 hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 w-fit">
        <i data-lucide="plus" class="w-5 h-5"></i>
        Tambah Metode
    </a>
</div>

<div class="bg-white rounded-3xl border border-neutral-light shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-neutral-light/50 text-[10px] font-bold uppercase tracking-wider text-neutral-dark/40">
                <tr>
                    <th class="px-6 py-4">Tipe</th>
                    <th class="px-6 py-4">Nama / Bank</th>
                    <th class="px-6 py-4">No. Rekening / QR</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-light">
                @forelse($methods as $method)
                    <tr class="hover:bg-neutral-light/30 transition-colors">
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-lg text-[10px] font-bold uppercase {{ $method->type === 'bank' ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600' }}">
                                {{ $method->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-neutral-dark">{{ $method->name }}</div>
                            @if($method->account_name)
                                <div class="text-[10px] text-neutral-dark/40 uppercase">{{ $method->account_name }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($method->type === 'bank')
                                <span class="font-mono text-sm text-neutral-dark">{{ $method->account_number }}</span>
                            @else
                                <div class="w-10 h-10 rounded-lg overflow-hidden border border-neutral-light">
                                    <img src="{{ asset('storage/' . $method->qr_image) }}" class="w-full h-full object-cover" alt="QRIS">
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($method->is_active)
                                <span class="text-success flex items-center justify-center gap-1 text-xs font-bold">
                                    <i data-lucide="check-circle" class="w-4 h-4"></i> Aktif
                                </span>
                            @else
                                <span class="text-neutral-dark/20 flex items-center justify-center gap-1 text-xs font-bold">
                                    <i data-lucide="x-circle" class="w-4 h-4"></i> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.payment-method.edit', $method->id) }}" class="p-2 bg-neutral-light text-neutral-dark rounded-xl hover:bg-neutral-dark hover:text-white transition-all">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.payment-method.destroy', $method->id) }}" method="POST" onsubmit="return confirm('Hapus metode ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-danger/10 text-danger rounded-xl hover:bg-danger hover:text-white transition-all">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <i data-lucide="credit-card" class="w-12 h-12 mx-auto text-neutral-dark/10 mb-4"></i>
                            <p class="text-neutral-dark/40 font-medium">Belum ada metode pembayaran.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
