<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
</head>

<body>
    <h1>Edit Kategori</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('category.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Nama Kategori</label>
            <br>

            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                placeholder="Masukkan nama kategori" maxlength="255" required>
        </div>

        <br>

        <button type="submit">Update</button>

        <a href="{{ route('category.index') }}">
            Batal
        </a>
    </form>
</body>

</html>
