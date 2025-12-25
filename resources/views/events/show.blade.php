<!DOCTYPE html>
<html>
<head>
    <title>Detail Event</title>
</head>
<body>
    <h1>Detail Event</h1>
    
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
            <td>{{ $event->id }}</td>
        </tr>
        <tr>
            <td>Title</td>
            <td>{{ $event->title }}</td>
        </tr>
        <tr>
            <td>Description</td>
            <td>{{ $event->description }}</td>
        </tr>
        <tr>
            <td>Location</td>
            <td>{{ $event->location }}</td>
        </tr>
        <tr>
            <td>Event Date</td>
            <td>{{ $event->event_date }}</td>
        </tr>
        <tr>
            <td>Start Time</td>
            <td>{{ $event->start_time }}</td>
        </tr>
        <tr>
            <td>End Time</td>
            <td>{{ $event->end_time }}</td>
        </tr>
        <tr>
            <td>Poster</td>
            <td>{{ $event->poster }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{ $event->status }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $event->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $event->updated_at }}</td>
        </tr>
    </table>
    
    <p>
        <a href="{{ route('events.edit', $event->id) }}">Edit Event</a> |
        <a href="{{ route('events.index') }}">Kembali ke Daftar Event</a>
    </p>
    
    <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Yakin ingin menghapus event ini?')">Hapus Event</button>
    </form>
</body>
</html>
