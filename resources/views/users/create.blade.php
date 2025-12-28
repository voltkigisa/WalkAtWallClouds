<x-admin-layout title="Create User - WalkAtWallClouds">
    <main class="fixed inset-0 bg-gray-900 flex items-center justify-center overflow-hidden ml-64 text-white">
        <div class="max-w-lg w-full px-8">
            
            {{-- Header --}}
            <div class="text-center mb-6 mt-12">
                <span class="text-indigo-500 font-black uppercase tracking-[0.2em] text-[10px]">Admin Mode</span>
                <h1 class="text-2xl font-black uppercase tracking-tighter mt-1 italic text-white">
                    Create <span class="text-indigo-500">New User</span>
                </h1>
            </div>

            {{-- Error Handling --}}
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-500/10 border border-red-500/50 text-red-400 rounded-xl text-[10px] font-bold uppercase">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Create --}}
            <form action="{{ route('users.store') }}" method="POST" class="space-y-4 bg-black/40 p-6 rounded-[2rem] border border-white/10 shadow-2xl backdrop-blur-md">
                @csrf
                
                <div class="space-y-3">
                    {{-- Name --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-white focus:border-indigo-500 outline-none transition font-medium" placeholder="John Doe">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-white focus:border-indigo-500 outline-none transition font-medium" placeholder="[email protected]">
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Password</label>
                        <input type="password" name="password" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-white focus:border-indigo-500 outline-none transition font-medium" placeholder="Min. 8 characters">
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Role</label>
                        <select name="role" required class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-gray-400 focus:border-indigo-500 outline-none transition font-medium appearance-none">
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-4 flex gap-3">
                    <button type="submit" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl transition shadow-lg shadow-indigo-500/20 uppercase tracking-widest text-[10px]">
                        Create User
                    </button>
                    <a href="{{ route('users.index') }}" class="flex-1 py-3 bg-white/5 hover:bg-white/10 text-white text-center font-black rounded-xl transition uppercase tracking-widest text-[10px] border border-white/10">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-admin-layout>
