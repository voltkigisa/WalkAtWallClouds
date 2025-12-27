<!DOCTYPE html>
<html>
<head>
    <title>Tambah Artist</title>
</head>
<body>
    <h1>Tambah Artist Baru</h1>
    
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
    
    <form action="{{ route('artists.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <table>
            <tr>
                <td><label for="name">Name:</label></td>
                <td><input type="text" id="name" name="name" value="{{ old('name') }}" required></td>
            </tr>
            <tr>
                <td><label for="country">Country:</label></td>
                <td><input type="text" id="country" name="country" value="{{ old('country') }}" required></td>
            </tr>
            <tr>
                <td><label for="genre">Genre:</label></td>
                <td><input type="text" id="genre" name="genre" value="{{ old('genre') }}" required></td>
            </tr>
            <tr>
                <td><label for="events">Events:</label></td>
                <td>
                    <select id="events" name="events[]" multiple size="5" style="width: 100%;">
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ in_array($event->id, old('events', [])) ? 'selected' : '' }}>
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
                    <input type="file" id="photo" name="photo" accept="image/*" required onchange="previewImage(event)">
                    <br><small>Max 5MB, Format: JPG, PNG, JPEG</small>
                    <br><img id="preview" src="" alt="Preview" style="max-width: 200px; margin-top: 10px; display: none;">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit">Simpan Artist</button>
                    <a href="{{ route('artists.index') }}">Batal</a>
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
