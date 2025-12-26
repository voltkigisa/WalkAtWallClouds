<?php $title = 'Forgot Password'; ?>
<div>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <main class="bg-gray-900 min-h-screen flex items-center justify-center px-6">
        <div class="relative text-white w-full max-w-md bg-black p-10 rounded-3xl shadow-2xl border border-gray-800">
            
            <a href="{{ route('login') }}" class="absolute top-6 right-6 text-gray-500 hover:text-white transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>

            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-500/10 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-black uppercase italic tracking-widest text-white">Forgot <span class="text-indigo-500">Password?</span></h2>
                <p class="text-gray-500 text-xs mt-3 uppercase font-bold tracking-tighter leading-relaxed">
                    Don't worry! Enter your email and we'll send you a link to reset your password.

                </p>
            </div>

            @if (session('status'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-xs font-bold text-center italic">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full px-5 py-4 bg-gray-900 border border-gray-800 rounded-2xl focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-white placeholder-gray-600 transition duration-300 shadow-inner"
                        placeholder="Enter your registered email">
                    
                    @error('email')
                        <p class="text-red-500 text-[10px] mt-2 font-bold uppercase italic ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-xs transition-all duration-300 shadow-lg shadow-indigo-600/20 active:scale-95">
                    Send Reset Link
                </button>
            </form>

            <div class="mt-10 text-center border-t border-gray-800 pt-6">
                <p class="text-gray-500 text-[10px] uppercase font-bold tracking-widest">
                    Do you remember your password?
 
                    <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 underline transition">Login Again</a>
                </p>
            </div>
        </div>
    </main>
</div>