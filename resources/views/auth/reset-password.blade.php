<div>
    <div class="min-h-[80vh] flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-black/50 backdrop-blur-lg p-8 rounded-3xl border border-white/10 shadow-2xl">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-white">New Password</h2>
                <p class="text-gray-400 mt-2 text-sm">Enter your new password for your WalkAtWallClouds account.</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-xs font-bold text-indigo-400 uppercase tracking-widest mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                        placeholder="Enter your email">
                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-indigo-400 uppercase tracking-widest mb-2">New Password</label>
                    <input type="password" name="password" required
                        class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-indigo-400 uppercase tracking-widest mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-indigo-500/20">
                    Update Password
                </button>
            </form>
        </div>
    </div>
</div>