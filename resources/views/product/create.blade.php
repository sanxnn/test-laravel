<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
</head>

<body>
    <h1>Tambah Produk</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="name">Nama Produk</label><br>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <br>

        <div>
            <label for="category_id">Kategori</label><br>
            <select id="category_id" name="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $item)
                    <option value="{{ $item->id }}" @selected(old('category_id') == $item->id)>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>

        <div>
            <label for="sku">SKU</label><br>
            <input type="text" id="sku" name="sku" value="{{ old('sku') }}" required>
        </div>
        <br>

        <div>
            <label for="price">Harga</label><br>
            <input type="number" id="price" name="price" value="{{ old('price') }}" min="0"
                step="any" required>
        </div>
        <br>

        <div>
            <label for="stock">Stok</label><br>
            <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" min="0" required>
        </div>
        <br>

        <div>
            <label for="description">Deskripsi</label><br>
            <textarea id="description" name="description" rows="4">{{ old('description') }}</textarea>
        </div>
        <br>

        <div>
            <label for="image">Gambar Produk</label><br>
            <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp">
            <small>Format JPG, JPEG, PNG, WEBP. Maksimal 2 MB.</small>
        </div>
        <br>

        <button type="submit">Simpan Produk</button>
        <a href="{{ route('product.index') }}">Kembali</a>
    </form>
</body>

</html>
