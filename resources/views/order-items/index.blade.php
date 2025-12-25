<!DOCTYPE html>
<html>
<head>
    <title>Daftar Order Item</title>
</head>
<body>
    <h1>Daftar Order Item</h1>
    
    @if(session('success'))
        <p><strong>{{ session('success') }}</strong></p>
    @endif
    
    <p>
        <a href="{{ route('order-items.create') }}">+ Tambah Order Item Baru</a>
    </p>
    
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Order Code</th>
                <th>Ticket Type</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orderItems as $orderItem)
                <tr>
                    <td>{{ $orderItem->id }}</td>
                    <td>{{ $orderItem->order->order_code ?? '-' }}</td>
                    <td>{{ $orderItem->ticketType->name ?? '-' }}</td>
                    <td>{{ $orderItem->quantity }}</td>
                    <td>Rp {{ number_format($orderItem->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('order-items.show', $orderItem->id) }}">View</a> |
                        <a href="{{ route('order-items.edit', $orderItem->id) }}">Edit</a> |
                        <form action="{{ route('order-items.destroy', $orderItem->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus order item ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Tidak ada data order item</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <p><a href="/admin/dashboard">Kembali ke Dashboard</a></p>
</body>
</html>
