<!DOCTYPE html>
<html>
<head>
    <title>Detail Ticket Type</title>
</head>
<body>
    <h1>Detail Ticket Type</h1>
    
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
            <td>{{ $ticketType->id }}</td>
        </tr>
        <tr>
            <td>Event</td>
            <td>{{ $ticketType->event->title ?? '-' }}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{ $ticketType->name }}</td>
        </tr>
        <tr>
            <td>Price</td>
            <td>Rp {{ number_format($ticketType->price, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Quota</td>
            <td>{{ $ticketType->quota }}</td>
        </tr>
        <tr>
            <td>Sold</td>
            <td>{{ $ticketType->sold }}</td>
        </tr>
        <tr>
            <td>Available</td>
            <td>{{ $ticketType->quota - $ticketType->sold }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $ticketType->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $ticketType->updated_at }}</td>
        </tr>
    </table>
    
    <p>
        <a href="{{ route('ticket-types.edit', $ticketType->id) }}">Edit Ticket Type</a> |
        <a href="{{ route('ticket-types.index') }}">Kembali ke Daftar Ticket Type</a>
    </p>
    
    <form action="{{ route('ticket-types.destroy', $ticketType->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Yakin ingin menghapus ticket type ini?')">Hapus Ticket Type</button>
    </form>
</body>
</html>
