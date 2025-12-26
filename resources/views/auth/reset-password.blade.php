<?php $title = 'Reset Password'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<main class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="relative text-white w-full max-w-md bg-black p-10 rounded-lg shadow-md border border-gray-800">

        {{-- Close --}}
        <a href="{{ route('login') }}"
           class="absolute top-4 right-4 text-gray-400 hover:text-white transition">
            ✕
        </a>

        <h2 class="text-2xl font-bold mb-6 text-center uppercase tracking-wider">
            Reset Password
        </h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            {{-- TOKEN WAJIB --}}
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            {{-- EMAIL --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold uppercase mb-2">
                    Email Address
                </label>
                <input type="email" name="email"
                       value="{{ old('email', request('email')) }}"
                       required
                       class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-blue-500 text-white">
            </div>

            {{-- PASSWORD --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold uppercase mb-2">
                    New Password
                </label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-blue-500 text-white">
            </div>

            {{-- CONFIRM PASSWORD --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold uppercase mb-2">
                    Confirm Password
                </label>
                <input type="password" name="password_confirmation" required
                       class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-blue-500 text-white">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 py-3 rounded-lg font-bold uppercase tracking-widest hover:bg-blue-700 transition">
                Reset Password
            </button>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Reset Password Gagal',
        text: '{{ $errors->first() }}',
        background: '#111827',
        color: '#ffffff',
        confirmButtonColor: '#2563eb'
    });
</script>
@endif

@if (session('status'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('status') }}',
        background: '#111827',
        color: '#ffffff',
        confirmButtonColor: '#2563eb'
    });
</script>
@endif
</body>
</html>