<?php $title = 'Login'; ?>
<div>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <main class="bg-gray-900 min-h-screen flex items-center justify-center">
        <div class="relative text-white w-full max-w-md bg-black p-10 rounded-lg shadow-md border border-gray-800">
            
            <a href="/" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>

            <h2 class="text-2xl font-bold mb-6 text-center text-white uppercase tracking-wider">Login</h2> 

            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="Account" class="block text-white font-semibold mb-2 text-sm uppercase">Email Address</label> 
                    <input type="email" id="Account" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-blue-500 text-white placeholder-gray-500"
                        placeholder="Enter your email">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-white font-semibold mb-2 text-sm uppercase">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-blue-500 text-white placeholder-gray-500"
                        placeholder="Enter your password">
                </div>

                <div class="mb-4">
                    <a href="{{ route('password.request') }}" class="text-blue-400 hover:underline font-semibold text-xs uppercase">
                        Forgot Password?
                    </a>
                </div>

                <button type="submit" id="loginBtn"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition uppercase tracking-widest">
                    Login
                </button>
            </form>

            <p class="text-center mt-6 text-gray-400 text-sm">
                No have account?
                <a href="{{ route('register') }}" class="text-blue-400 hover:underline font-bold uppercase">
                    Register
                </a>
            </p>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Pop-up Gagal (Email/Password Salah)
            // Dipicu jika Controller mengirim redirect()->back()->withErrors(...)
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: '{{ $errors->first() }}',
                    background: '#111827', // Gray-900
                    color: '#ffffff',
                    confirmButtonColor: '#2563eb' // Blue-600
                });
            @endif
        });
    </script>
</div>