<!DOCTYPE html>
<html>
<head>
    <title>Edit Order Item</title>
</head>
<body>
    <h1>Edit Order Item</h1>
    
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
    
    <form action="{{ route('order-items.update', $orderItem->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <table>
            <tr>
                <td><label for="order_id">Order:</label></td>
                <td>
                    <select id="order_id" name="order_id" required>
                        <option value="">Pilih Order</option>
                        @foreach(\App\Models\Order::all() as $order)
                            <option value="{{ $order->id }}" {{ old('order_id', $orderItem->order_id) == $order->id ? 'selected' : '' }}>
                                {{ $order->order_code }} - {{ $order->user->name ?? '-' }}
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
                        @foreach(\App\Models\TicketType::all() as $ticketType)
                            <option value="{{ $ticketType->id }}" {{ old('ticket_type_id', $orderItem->ticket_type_id) == $ticketType->id ? 'selected' : '' }}>
                                {{ $ticketType->name }} - {{ $ticketType->event->title ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="quantity">Quantity:</label></td>
                <td><input type="number" id="quantity" name="quantity" value="{{ old('quantity', $orderItem->quantity) }}" required></td>
            </tr>
            <tr>
                <td><label for="price">Price:</label></td>
                <td><input type="number" id="price" name="price" value="{{ old('price', $orderItem->price) }}" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit">Update Order Item</button>
                    <a href="{{ route('order-items.show', $orderItem->id) }}">Batal</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
