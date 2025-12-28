<!DOCTYPE html>
<html>
<head>
    <title>Tambah Ticket Type</title>
</head>
<body>
    <h1>Tambah Ticket Type Baru</h1>
    
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
    
    <form action="{{ route('ticket-types.store') }}" method="POST">
        @csrf
        
        <table>
            <tr>
                <td><label for="event_id">Event:</label></td>
                <td>
                    <select id="event_id" name="event_id" required>
                        <option value="">Pilih Event</option>
                        @foreach(\App\Models\Event::all() as $event)
                            <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                {{ $event->title }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="name">Name:</label></td>
                <td><input type="text" id="name" name="name" value="{{ old('name') }}" required></td>
            </tr>
            <tr>
                <td><label for="price">Price:</label></td>
                <td><input type="number" id="price" name="price" value="{{ old('price') }}" required></td>
            </tr>
            <tr>
                <td><label for="quota">Quota:</label></td>
                <td><input type="number" id="quota" name="quota" value="{{ old('quota') }}" required></td>
            </tr>
            <tr>
                <td><label for="sold">Sold:</label></td>
                <td><input type="number" id="sold" name="sold" value="{{ old('sold', 0) }}" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit">Simpan Ticket Type</button>
                    <a href="{{ route('ticket-types.index') }}">Batal</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
