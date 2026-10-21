<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>
</head>

<body>
    <h1>Data Produk</h1>

    @if (session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    <a href="{{ route('product.create') }}">+ Tambah Produk</a>
    <a href="{{ route('category.index') }}">Data Kategori</a>

    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>SKU</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($produk as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" width="70">
                        @else
                            Tidak ada gambar
                        @endif
                    </td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category?->name ?? '-' }}</td>
                    <td>{{ $item->sku }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>
                        <a href="{{ route('product.edit', $item->id) }}">
                            Edit
                        </a>

                        <form action="{{ route('product.destroy', $item->id) }}" method="POST"
                            style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
