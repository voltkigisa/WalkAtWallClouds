@props(['title' => null])
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Application') }}</title>
    <link rel="icon" href="/favicon.ico">
    @stack('styles')
</head>
<body class="bg-gray-900 min-h-screen text-gray-100">
    {{ $slot }}
    @stack('scripts')
    
</body>
</html>
