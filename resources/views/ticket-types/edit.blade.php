<!DOCTYPE html>
<html>
<head>
    <title>Edit Ticket Type</title>
</head>
<body>
    <h1>Edit Ticket Type</h1>
    
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
    
    <form action="{{ route('ticket-types.update', $ticketType->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <table>
            <tr>
                <td><label for="event_id">Event:</label></td>
                <td>
                    <select id="event_id" name="event_id" required>
                        <option value="">Pilih Event</option>
                        @foreach(\App\Models\Event::all() as $event)
                            <option value="{{ $event->id }}" {{ old('event_id', $ticketType->event_id) == $event->id ? 'selected' : '' }}>
                                {{ $event->title }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="name">Name:</label></td>
                <td><input type="text" id="name" name="name" value="{{ old('name', $ticketType->name) }}" required></td>
            </tr>
            <tr>
                <td><label for="price">Price:</label></td>
                <td><input type="number" id="price" name="price" value="{{ old('price', $ticketType->price) }}" required></td>
            </tr>
            <tr>
                <td><label for="quota">Quota:</label></td>
                <td><input type="number" id="quota" name="quota" value="{{ old('quota', $ticketType->quota) }}" required></td>
            </tr>
            <tr>
                <td><label for="sold">Sold:</label></td>
                <td><input type="number" id="sold" name="sold" value="{{ old('sold', $ticketType->sold) }}" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit">Update Ticket Type</button>
                    <a href="{{ route('ticket-types.show', $ticketType->id) }}">Batal</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
