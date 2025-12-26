<!DOCTYPE html>
<html>
<head>
    <title>Tambah Order Item</title>
</head>
<body>
    <h1>Tambah Order Item Baru</h1>
    
    @if($errors->any())
        <div>
            <strong>Error:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('order-items.store') }}" method="POST">
        @csrf
        
        <table>
            <tr>
                <td><label for="order_id">Order:</label></td>
                <td>
                    <select id="order_id" name="order_id" required>
                        <option value="">Pilih Order</option>
                        @foreach(\App\Models\Order::with('user')->get() as $order)
                            <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                Order #{{ $order->id }} - {{ $order->user->name ?? 'Unknown' }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="ticket_type_id">Ticket Type:</label></td>
                <td>
                    <select id="ticket_type_id" name="ticket_type_id" required>
                        <option value="">Pilih Ticket Type</option>
                        @foreach(\App\Models\TicketType::with('event')->get() as $ticketType)
                            <option value="{{ $ticketType->id }}" {{ old('ticket_type_id') == $ticketType->id ? 'selected' : '' }}>
                                {{ $ticketType->name }} - {{ $ticketType->event->title ?? 'Unknown Event' }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="quantity">Quantity:</label></td>
                <td><input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" required></td>
            </tr>
            <tr>
                <td><label for="price">Price:</label></td>
                <td><input type="number" id="price" name="price" value="{{ old('price') }}" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit">Simpan Order Item</button>
                    <a href="{{ route('order-items.index') }}">Batal</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
