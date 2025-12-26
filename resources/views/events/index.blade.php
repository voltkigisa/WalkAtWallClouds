<!DOCTYPE html>
<html>
<head>
    <title>Daftar Event</title>
</head>
<body>
    <h1>Daftar Event</h1>
    
    @if(session('success'))
        <p><strong>{{ session('success') }}</strong></p>
    @endif
    
    <p>
        <a href="{{ route('events.create') }}">+ Tambah Event Baru</a>
    </p>
    
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Location</th>
                <th>Event Date</th>
                <th>Start Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr>
                    <td>{{ $event->id }}</td>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->location }}</td>
                    <td>{{ $event->event_date }}</td>
                    <td>{{ $event->start_time }}</td>
                    <td>{{ $event->status }}</td>
                    <td>
                        <a href="{{ route('events.show', $event->id) }}">View</a> |
                        <a href="{{ route('events.edit', $event->id) }}">Edit</a> |
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus event ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Tidak ada data event</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <p><a href="/admin/dashboard">Kembali ke Dashboard</a></p>
</body>
</html>
