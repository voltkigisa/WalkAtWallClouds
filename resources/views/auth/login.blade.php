<?php $title = 'Login'; ?>
<div>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <body class="bg-gray-900 min-h-screen">
        <div class="relative text-white max-w-md mx-auto mt-20 mb-40 bg-black p-20 rounded-lg shadow-md border border-gray-800">
            
            <a href="/" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>

            <h2 class="text-2xl font-bold mb-6 text-center text-white">Login</h2> 

            @if ($errors->any())
                <div class="mb-4 p-3 rounded bg-red-500/20 border border-red-500 text-red-100 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="Account" class="block text-white font-semibold mb-2">Account</label> 
                    <input type="text" id="Account" name="email" required
                        class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-blue-500 text-white placeholder-gray-500"
                        placeholder="Enter your email or account">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-white font-semibold mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-blue-500 text-white placeholder-gray-500"
                        placeholder="Enter your password">
                </div>

                 <div class="mb-4">
                    <a href="#" class="text-blue-400 hover:underline font-semibold text-sm">
                        Forgot Password?
                    </a>
                 </div>

                <button type="submit" id="loginBtn"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Login
                </button>
            </form>

            <p class="text-center mt-4 text-gray-300">
                No have account?
                <a href="{{ route('register') }}" class="text-blue-400 hover:underline font-semibold">
                    Register
                </a>
            </p>
        </div>

        <script src="{{ asset('js/login-validation.js') }}"></script>
    </body>
</div>