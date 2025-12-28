<x-admin-layout title="Manage Users - WalkAtWallClouds">
    <main class="bg-gray-900 min-h-screen text-white py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-black uppercase tracking-tighter italic">Manage <span class="text-indigo-500">Users</span></h1>
                    <div class="h-1 w-20 bg-indigo-500 mt-2"></div>
                </div>
                <a href="{{ route('users.create') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-xl font-bold transition flex items-center gap-2 uppercase tracking-widest text-xs">
                    + Create Admin User
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 text-green-400 rounded-xl text-sm font-bold uppercase italic">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 text-red-400 rounded-xl text-sm font-bold uppercase italic">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-black/40 border border-white/10 rounded-3xl overflow-hidden shadow-2xl backdrop-blur-md">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/5 text-indigo-400 uppercase text-[10px] font-black tracking-widest">
                            <th class="p-5">ID</th>
                            <th class="p-5">Name</th>
                            <th class="p-5">Email</th>
                            <th class="p-5">Role</th>
                            <th class="p-5 text-center">Orders</th>
                            <th class="p-5 text-center">Login Via</th>
                            <th class="p-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($users as $user)
                            <tr class="hover:bg-white/[0.02] transition">
                                <td class="p-5 text-gray-500 font-mono text-xs">{{ $user->id }}</td>
                                <td class="p-5 font-bold">
                                    {{ $user->name }}
                                    @if($user->name === 'Admin Walk At Wall Clouds')
                                        <span class="ml-2 px-2 py-1 bg-yellow-500/10 border border-yellow-500/30 text-yellow-500 text-[8px] rounded-full font-black uppercase">Protected</span>
                                    @endif
                                </td>
                                <td class="p-5 text-sm">{{ $user->email }}</td>
                                <td class="p-5">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border 
                                        {{ $user->role === 'admin' ? 'bg-purple-500/10 border-purple-500 text-purple-500' : 'bg-blue-500/10 border-blue-500 text-blue-500' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="p-5 text-center text-sm font-bold">{{ $user->orders_count }}</td>
                                <td class="p-5 text-center">
                                    @if($user->provider)
                                        <span class="px-2 py-1 bg-green-500/10 text-green-400 text-[9px] font-black uppercase rounded-full border border-green-500/20">{{ $user->provider }}</span>
                                    @else
                                        <span class="text-gray-500 text-[9px] uppercase">Email</span>
                                    @endif
                                </td>
                                <td class="p-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('users.show', $user->id) }}" class="p-2 bg-white/5 rounded-lg text-gray-400 hover:bg-indigo-600 hover:text-white transition text-xs font-bold uppercase">View</a>
                                        @if($user->name !== 'Admin Walk At Wall Clouds' && $user->role === 'admin')
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin ingin menghapus admin ini?')" class="p-2 bg-white/5 rounded-lg text-red-500 hover:bg-red-600 hover:text-white transition text-xs font-bold uppercase">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="p-20 text-center text-gray-600 uppercase font-black text-xs tracking-widest">Tidak ada data user</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($users->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="flex gap-2">
                    {{-- Previous Page Link --}}
                    @if ($users->onFirstPage())
                        <span class="px-4 py-2 bg-white/5 text-gray-600 rounded-xl text-xs font-bold uppercase cursor-not-allowed">Previous</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="px-4 py-2 bg-white/5 hover:bg-indigo-600 text-gray-400 hover:text-white rounded-xl text-xs font-bold uppercase transition">Previous</a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($users->links()->elements[0] as $page => $url)
                        @if ($page == $users->currentPage())
                            <span class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 bg-white/5 hover:bg-indigo-600 text-gray-400 hover:text-white rounded-xl text-xs font-bold transition">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="px-4 py-2 bg-white/5 hover:bg-indigo-600 text-gray-400 hover:text-white rounded-xl text-xs font-bold uppercase transition">Next</a>
                    @else
                        <span class="px-4 py-2 bg-white/5 text-gray-600 rounded-xl text-xs font-bold uppercase cursor-not-allowed">Next</span>
                    @endif
                </div>
            </div>
            @endif

            <div class="mt-8">
                <a href="{{ route('admin') }}" class="text-gray-500 hover:text-white text-xs font-bold uppercase tracking-widest transition">← Kembali ke Dashboard</a>
            </div>
        </div>
    </main>
</x-admin-layout>
