@extends('admin.layouts.app')

@section('title', 'Manajemen User - Admin Mountix')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-neutral-dark">Manajemen User</h1>
    <p class="text-neutral-dark/60">Kelola pengguna sistem dan pantau aktivitas mereka.</p>
</div>

<div class="bg-white rounded-3xl border border-neutral-light shadow-sm overflow-hidden">
    <!-- Filter & Search -->
    <div class="p-6 border-b border-neutral-light bg-neutral-light/20">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-grow">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-dark/40"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full pl-12 pr-4 py-3 bg-white border border-neutral-light rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
            </div>
            <div class="md:w-48">
                <select name="role" class="w-full px-4 py-3 bg-white border border-neutral-light rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
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
                    <th class="px-6 py-4">Pengguna</th>
                    <th class="px-6 py-4 text-center">Role</th>
                    <th class="px-6 py-4 text-center">Total Booking</th>
                    <th class="px-6 py-4 text-center">Tgl Join</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-light">
                @forelse($users as $user)
                    <tr class="hover:bg-neutral-light/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-neutral-dark">{{ $user->name }}</div>
                            <div class="text-[10px] text-neutral-dark/40">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->role === 'admin')
                                <span class="bg-primary/10 text-primary text-[10px] font-black uppercase px-3 py-1 rounded-full border border-primary/20">Admin</span>
                            @else
                                <span class="bg-secondary/10 text-secondary text-[10px] font-black uppercase px-3 py-1 rounded-full border border-secondary/20">User</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-bold text-neutral-dark">{{ $user->bookings_count }}</span>
                        </td>
                        <td class="px-6 py-4 text-center text-xs text-neutral-dark/60">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="p-2 text-neutral-dark/40 hover:text-primary hover:bg-primary/5 rounded-lg transition-all" title="Detail">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-neutral-dark/40 text-sm">Tidak ada data user ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="p-6 border-t border-neutral-light bg-neutral-light/10">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
