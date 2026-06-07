@extends('admin.layouts.app')

@section('title', 'Edit Metode Pembayaran - Admin Mountix')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.payment-method.index') }}" class="text-neutral-dark/40 hover:text-primary transition-colors flex items-center gap-2 mb-2 font-bold text-xs uppercase tracking-widest">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
    </a>
    <h1 class="text-3xl font-black text-neutral-dark">Edit Metode</h1>
</div>

<div class="max-w-4xl">
    <form action="{{ route('admin.payment-method.update', $paymentMethod->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="bg-white p-8 rounded-3xl border border-neutral-light shadow-sm space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Type -->
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-neutral-dark/60">Tipe Pembayaran</label>
                    <select name="type" id="type-select" class="w-full px-4 py-3 bg-neutral-light/30 border border-neutral-light rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium">
                        <option value="bank" {{ old('type', $paymentMethod->type) == 'bank' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="qris" {{ old('type', $paymentMethod->type) == 'qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>

                <!-- Name -->
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-neutral-dark/60">Nama (BCA / GoPay / Dll)</label>
                    <input type="text" name="name" value="{{ old('name', $paymentMethod->name) }}" placeholder="Contoh: BCA" class="w-full px-4 py-3 bg-neutral-light/30 border border-neutral-light rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium" required>
                </div>
            </div>

            <!-- Bank Fields -->
            <div id="bank-fields" class="{{ old('type', $paymentMethod->type) === 'bank' ? '' : 'hidden' }} grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-neutral-dark/60">Nomor Rekening</label>
                    <input type="text" name="account_number" value="{{ old('account_number', $paymentMethod->account_number) }}" placeholder="000-000-000" class="w-full px-4 py-3 bg-neutral-light/30 border border-neutral-light rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-neutral-dark/60">Atas Nama</label>
                    <input type="text" name="account_name" value="{{ old('account_name', $paymentMethod->account_name) }}" placeholder="NAMA PEMILIK" class="w-full px-4 py-3 bg-neutral-light/30 border border-neutral-light rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium">
                </div>
            </div>

            <!-- QRIS Fields -->
            <div id="qris-fields" class="{{ old('type', $paymentMethod->type) === 'qris' ? '' : 'hidden' }} space-y-4">
                <label class="text-xs font-bold uppercase tracking-wider text-neutral-dark/60">QR Code</label>
                @if($paymentMethod->qr_image)
                    <div class="w-32 h-32 rounded-2xl border-2 border-neutral-light overflow-hidden">
                        <img src="{{ asset('storage/' . $paymentMethod->qr_image) }}" class="w-full h-full object-cover">
                    </div>
                @endif
                <input type="file" name="qr_image" class="w-full px-4 py-3 bg-neutral-light/30 border border-neutral-light rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium">
                <p class="text-[10px] text-neutral-dark/40 italic">*Kosongkan jika tidak ingin mengubah QR Code. Max 2MB.</p>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }} class="w-5 h-5 rounded-lg accent-primary">
                <label for="is_active" class="text-sm font-bold text-neutral-dark">Aktifkan Metode Ini</label>
            </div>
        </div>

        <button type="submit" class="bg-primary text-white px-10 py-4 rounded-2xl font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Simpan Perubahan
        </button>
    </form>
</div>

@push('scripts')
<script>
    const typeSelect = document.getElementById('type-select');
    const bankFields = document.getElementById('bank-fields');
    const qrisFields = document.getElementById('qris-fields');

    typeSelect.addEventListener('change', function() {
        if (this.value === 'bank') {
            bankFields.classList.remove('hidden');
            qrisFields.classList.add('hidden');
        } else {
            bankFields.classList.add('hidden');
            qrisFields.classList.remove('hidden');
        }
    });
</script>
@endpush
@endsection
