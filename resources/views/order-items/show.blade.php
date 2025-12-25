<!DOCTYPE html>
<html>
<head>
    <title>Detail Order Item</title>
</head>
<body>
    <h1>Detail Order Item</h1>
    
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
            <td>{{ $orderItem->id }}</td>
        </tr>
        <tr>
            <td>Order Code</td>
            <td>{{ $orderItem->order->order_code ?? '-' }}</td>
        </tr>
        <tr>
            <td>User</td>
            <td>{{ $orderItem->order->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>Ticket Type</td>
            <td>{{ $orderItem->ticketType->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>Event</td>
            <td>{{ $orderItem->ticketType->event->title ?? '-' }}</td>
        </tr>
        <tr>
            <td>Quantity</td>
            <td>{{ $orderItem->quantity }}</td>
        </tr>
        <tr>
            <td>Price</td>
            <td>Rp {{ number_format($orderItem->price, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total</td>
            <td>Rp {{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{ $orderItem->created_at }}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{ $orderItem->updated_at }}</td>
        </tr>
    </table>
    
    <p>
        <a href="{{ route('order-items.edit', $orderItem->id) }}">Edit Order Item</a> |
        <a href="{{ route('order-items.index') }}">Kembali ke Daftar Order Item</a>
    </p>
    
    <form action="{{ route('order-items.destroy', $orderItem->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Yakin ingin menghapus order item ini?')">Hapus Order Item</button>
    </form>
</body>
</html>
