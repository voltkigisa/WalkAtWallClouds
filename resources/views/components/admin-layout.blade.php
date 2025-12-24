<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Admin' }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 text-white">

    {{ $slot }}

</body>
</html>