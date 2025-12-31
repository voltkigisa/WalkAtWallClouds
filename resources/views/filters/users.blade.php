<?php $title = 'Users Filter - WalkAtWallClouds'; ?>
<x-admin-layout :$title>
    <main class="bg-gray-900 min-h-screen text-white py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mb-10">
                <h1 class="text-4xl font-black uppercase italic tracking-tighter text-white mb-2">Filter Users</h1>
                <p class="text-gray-500 text-sm font-bold uppercase tracking-widest">Kelola dan filter data pengguna</p>
            </div>
            
            <!-- Filter Form -->
            <div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden mb-10">
                <div class="p-6 border-b border-gray-800">
                    <h2 class="text-lg font-black uppercase italic tracking-tighter text-indigo-400 mb-1">Filter Users</h2>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Temukan user yang sesuai dengan kriteria</p>
                </div>
                
                <form method="GET" action="{{ route('filters.users') }}" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Nama:</label>
                            <input type="text" name="name" value="{{ request('name') }}" placeholder="Cari nama user..." class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Email:</label>
                            <input type="text" name="email" value="{{ request('email') }}" placeholder="Cari email..." class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Role:</label>
                            <select name="role" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="">Semua Role</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>

                        <!-- Filter Tanggal Registrasi -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Tanggal Registrasi:</label>
                            <select name="date_filter" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="">Semua Tanggal</option>
                                <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                                <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                                <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                            </select>
                        </div>

                        <!-- Tanggal Dari -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Tanggal Dari:</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Tanggal Sampai -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Tanggal Sampai:</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Urutkan Berdasarkan -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Urutkan Berdasarkan:</label>
                            <select name="sort_by" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Tanggal Registrasi</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama</option>
                                <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                            </select>
                        </div>

                        <!-- Urutan -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Urutan:</label>
                            <select name="sort_order" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>A-Z / Terlama</option>
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Z-A / Terbaru</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 mt-6">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-indigo-600/20 flex items-center gap-2">
                            <i class="fa-solid fa-filter"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('filters.users') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition flex items-center gap-2">
                            <i class="fa-solid fa-rotate-right"></i> Reset Filter
                        </a>
                    </div>
                </form>
            </div>

            <!-- Results Info -->
            <div class="mb-6">
                <p class="text-gray-400 text-sm font-bold">Menampilkan <span class="text-indigo-400 font-black">{{ $users->count() }}</span> dari <span class="text-indigo-400 font-black">{{ $users->total() }}</span> users</p>
            </div>

            <!-- Users Table -->
            <div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-900/50 text-[10px] text-gray-500 font-black uppercase tracking-widest">
                                <th class="p-5">User Details</th>
                                <th class="p-5 text-center">Email</th>
                                <th class="p-5 text-center">Role</th>
                                <th class="p-5 text-center">Orders</th>
                                <th class="p-5 text-center">Registered</th>
                                <th class="p-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($users as $user)
                            <tr class="border-t border-gray-800 hover:bg-indigo-500/5 transition duration-300">
                                <td class="p-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center font-black">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-black text-white">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">ID: {{ $user->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-center text-xs text-gray-400">{{ $user->email }}</td>
                                <td class="p-5 text-center">
                                    @if($user->role === 'admin')
                                        <span class="px-3 py-1 bg-indigo-500/10 text-indigo-400 text-[9px] font-black rounded-full border border-indigo-500/20 uppercase tracking-widest">Admin</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-500/10 text-gray-400 text-[9px] font-black rounded-full border border-gray-500/20 uppercase tracking-widest">User</span>
                                    @endif
                                </td>
                                <td class="p-5 text-center text-xs font-mono">{{ $user->orders_count }}</td>
                                <td class="p-5 text-center text-xs font-mono text-gray-400">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
                                <td class="p-5">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('users.show', $user->id) }}" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg text-xs font-black uppercase tracking-widest transition border border-gray-700">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-black uppercase tracking-widest transition">
                                            <i class="fa-solid fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr class="border-t border-gray-800">
                                <td colspan="6" class="p-12 text-center text-gray-500">
                                    <i class="fa-solid fa-inbox text-5xl mb-4 opacity-20"></i>
                                    <p class="text-sm font-bold uppercase">Tidak ada user yang sesuai dengan filter Anda.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    </main>
</x-admin-layout>
