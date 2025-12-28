<!DOCTYPE html>
<html>
<head>
    <title>Daftar Ticket Type</title>
</head>
<body>
    <h1>Daftar Ticket Type</h1>
    
    @if(session('success'))
        <p><strong>{{ session('success') }}</strong></p>
    @endif
    
    <p>
        <a href="{{ route('ticket-types.create') }}">+ Tambah Ticket Type Baru</a>
    </p>
    
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quota</th>
                <th>Sold</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ticketTypes as $ticketType)
                <tr>
                    <td>{{ $ticketType->id }}</td>
                    <td>{{ $ticketType->event->title ?? '-' }}</td>
                    <td>{{ $ticketType->name }}</td>
                    <td>Rp {{ number_format($ticketType->price, 0, ',', '.') }}</td>
                    <td>{{ $ticketType->quota }}</td>
                    <td>{{ $ticketType->sold }}</td>
                    <td>
                        <a href="{{ route('ticket-types.show', $ticketType->id) }}">View</a> |
                        <a href="{{ route('ticket-types.edit', $ticketType->id) }}">Edit</a> |
                        <form action="{{ route('ticket-types.destroy', $ticketType->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus ticket type ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Tidak ada data ticket type</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <p><a href="/admin/dashboard">Kembali ke Dashboard</a></p>
</body>
</html>
