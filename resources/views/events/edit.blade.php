<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
</head>
<body>
    <h1>Edit Event</h1>
    
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
    
    <form action="{{ route('events.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <table>
            <tr>
                <td><label for="title">Title:</label></td>
                <td><input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" required></td>
            </tr>
            <tr>
                <td><label for="description">Description:</label></td>
                <td><textarea id="description" name="description" rows="5">{{ old('description', $event->description) }}</textarea></td>
            </tr>
            <tr>
                <td><label for="location">Location:</label></td>
                <td><input type="text" id="location" name="location" value="{{ old('location', $event->location) }}" required></td>
            </tr>
            <tr>
                <td><label for="event_date">Event Date:</label></td>
                <td><input type="date" id="event_date" name="event_date" value="{{ old('event_date', $event->event_date) }}" required></td>
            </tr>
            <tr>
                <td><label for="start_time">Start Time:</label></td>
                <td><input type="time" id="start_time" name="start_time" value="{{ old('start_time', $event->start_time) }}" required></td>
            </tr>
            <tr>
                <td><label for="end_time">End Time:</label></td>
                <td><input type="time" id="end_time" name="end_time" value="{{ old('end_time', $event->end_time) }}" required></td>
            </tr>
            <tr>
                <td><label for="poster">Poster URL:</label></td>
                <td><input type="text" id="poster" name="poster" value="{{ old('poster', $event->poster) }}"></td>
            </tr>
            <tr>
                <td><label for="status">Status:</label></td>
                <td>
                    <select id="status" name="status">
                        <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="active" {{ old('status', $event->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit">Update Event</button>
                    <a href="{{ route('events.show', $event->id) }}">Batal</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
