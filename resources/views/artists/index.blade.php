<!DOCTYPE html>
<html>
<head>
    <title>Daftar Artist</title>
</head>
<body>
    <h1>Daftar Artist</h1>
    
    @if(session('success'))
        <p><strong>{{ session('success') }}</strong></p>
    @endif
    
    <p>
        <a href="{{ route('artists.create') }}">+ Tambah Artist Baru</a>
    </p>
    
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Country</th>
                <th>Genre</th>
                <th>Events</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($artists as $artist)
                <tr>
                    <td>{{ $artist->id }}</td>
                    <td>{{ $artist->name }}</td>
                    <td>{{ $artist->country }}</td>
                    <td>{{ $artist->genre }}</td>
                    <td>
                        @if($artist->events->count() > 0)
                            {{ $artist->events->pluck('title')->join(', ') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($artist->photo)
                            <img src="{{ asset('storage/'.$artist->photo) }}" alt="{{ $artist->name }}" style="max-width: 50px;">
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('artists.show', $artist->id) }}">View</a> |
                        <a href="{{ route('artists.edit', $artist->id) }}">Edit</a> |
                        <form action="{{ route('artists.destroy', $artist->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus artist ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Tidak ada data artist</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <p><a href="/admin/dashboard">Kembali ke Dashboard</a></p>
</body>
</html>
