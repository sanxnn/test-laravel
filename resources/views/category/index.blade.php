<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori</title>
</head>

<body>
    <h1>Data Kategori</h1>

    @if (session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    <a href="{{ route('category.create') }}">
        + Tambah Kategori
    </a>

    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Dibuat Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($kategori as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <a href="{{ route('category.edit', $item->id) }}">
                            Edit
                        </a>

                        <form action="{{ route('category.destroy', $item->id) }}" method="POST"
                            style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        Belum ada data kategori.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
