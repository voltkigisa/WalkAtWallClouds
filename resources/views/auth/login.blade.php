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

                <div class="mb-4 mt-4">
                    <a href="/auth/google" 
                        class="w-full flex items-center justify-center gap-2 bg-transparent text-white py-3 rounded-lg font-bold hover:bg-gray-800 transition uppercase tracking-widest border border-gray-700">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        Login with Google
                    </a>
                </div>
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

    @php
        $loginErrorMsg = $errors->any() ? $errors->first() : null;
    @endphp
    
    @if ($loginErrorMsg)
    <div id="login-error-data" data-error="{!! addslashes($loginErrorMsg) !!}" style="display:none;"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorEl = document.getElementById('login-error-data');
            const errorMsg = errorEl ? errorEl.getAttribute('data-error') : null;
            if (errorMsg) {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: errorMsg,
                    background: '#111827',
                    color: '#ffffff',
                    confirmButtonColor: '#2563eb'
                });
            }
        });
    </script>
    @endif
</div>