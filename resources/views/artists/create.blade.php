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
    
    <form action="{{ route('artists.store') }}" method="POST">
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
                <td><label for="photo">Photo URL:</label></td>
                <td><input type="text" id="photo" name="photo" value="{{ old('photo') }}" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit">Simpan Artist</button>
                    <a href="{{ route('artists.index') }}">Batal</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
