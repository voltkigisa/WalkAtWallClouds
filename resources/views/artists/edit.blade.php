<!DOCTYPE html>
<html>
<head>
    <title>Edit Artist</title>
</head>
<body>
    <h1>Edit Artist</h1>
    
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
    
    <form action="{{ route('artists.update', $artist->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <table>
            <tr>
                <td><label for="name">Name:</label></td>
                <td><input type="text" id="name" name="name" value="{{ old('name', $artist->name) }}" required></td>
            </tr>
            <tr>
                <td><label for="country">Country:</label></td>
                <td><input type="text" id="country" name="country" value="{{ old('country', $artist->country) }}" required></td>
            </tr>
            <tr>
                <td><label for="genre">Genre:</label></td>
                <td><input type="text" id="genre" name="genre" value="{{ old('genre', $artist->genre) }}" required></td>
            </tr>
            <tr>
                <td><label for="events">Events:</label></td>
                <td>
                    <select id="events" name="events[]" multiple size="5" style="width: 100%;">
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" 
                                {{ in_array($event->id, old('events', $artist->events->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $event->title }} - {{ $event->event_date }}
                            </option>
                        @endforeach
                    </select>
                    <br><small>Tekan Ctrl (atau Cmd di Mac) untuk memilih lebih dari satu event</small>
                </td>
            </tr>
            <tr>
                <td><label for="photo">Photo:</label></td>
                <td>
                    @if($artist->photo)
                        <div>
                            <img src="{{ asset('storage/'.$artist->photo) }}" alt="Current Photo" style="max-width: 200px; margin-bottom: 10px;">
                            <p><small>Current photo</small></p>
                        </div>
                    @endif
                    <input type="file" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
                    <br><small>Kosongkan jika tidak ingin mengubah foto. Max 5MB, Format: JPG, PNG, JPEG</small>
                    <br><img id="preview" src="" alt="Preview" style="max-width: 200px; margin-top: 10px; display: none;">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit">Update Artist</button>
                    <a href="{{ route('artists.show', $artist->id) }}">Batal</a>
                </td>
            </tr>
        </table>
    </form>
    
    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
