<!DOCTYPE html>
<html>
<head>
    <title>Detail Artist</title>
</head>
<body>
    <h1>Detail Artist</h1>
    
    @if(session('success'))
        <p><strong>{{ session('success') }}</strong></p>
    @endif
    
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>ID</td>
            <td>{{ $artist->id }}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{ $artist->name }}</td>
        </tr>
        <tr>
            <td>Country</td>
            <td>{{ $artist->country }}</td>
        </tr>
        <tr>
            <td>Genre</td>
            <td>{{ $artist->genre }}</td>
        </tr>
        <tr>
            <td>Photo</td>
            <td>{{ $artist->photo }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $artist->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $artist->updated_at }}</td>
        </tr>
    </table>
    
    <p>
        <a href="{{ route('artists.edit', $artist->id) }}">Edit Artist</a> |
        <a href="{{ route('artists.index') }}">Kembali ke Daftar Artist</a>
    </p>
    
    <form action="{{ route('artists.destroy', $artist->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Yakin ingin menghapus artist ini?')">Hapus Artist</button>
    </form>
</body>
</html>
