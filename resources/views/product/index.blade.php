<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>
    <style>
        #toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: min(380px, calc(100vw - 32px));
            pointer-events: none;
        }

        .toast {
            display: flex;
            align-items: flex-start;
            gap: 13px;
            padding: 16px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, .12);
            pointer-events: auto;
            animation: toast-in .35s ease forwards;
            overflow: hidden;
            position: relative;
        }

        .toast-icon {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            background: #dcfce7;
            color: #16a34a;
            border-radius: 50%;
            font-size: 20px;
            font-weight: bold;
        }

        .toast-content {
            flex: 1;
            min-width: 0;
        }

        .toast-title {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 4px;
        }

        .toast-message {
            font-size: 13px;
            color: #6b7280;
            overflow-wrap: anywhere;
        }

        .toast-close {
            border: none;
            background: transparent;
            color: #9ca3af;
            font-size: 20px;
            cursor: pointer;
            line-height: 1;
            padding: 0;
        }

        .toast-close:hover {
            color: #111827;
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: #22c55e;
            width: 100%;
            transform-origin: left;
            animation: toast-progress 4s linear forwards;
        }

        .toast.removing {
            animation: toast-out .3s ease forwards;
        }

        @keyframes toast-in {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes toast-out {
            to {
                opacity: 0;
                transform: translateX(30px);
            }
        }

        @keyframes toast-progress {
            to {
                transform: scaleX(0);
            }
        }

        @media (max-width: 480px) {
            #toast-container {
                top: 12px;
                right: 12px;
                width: calc(100vw - 24px);
            }
        }
    </style>
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

    <div id="toast-container" aria-live="polite" aria-atomic="false"></div>


    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@2/dist/echo.iife.js"></script>



    <script>
        const echo = new Echo.default({
            broadcaster: 'reverb',
            key: '{{ config('broadcasting.connections.reverb.key') }}',
            wsHost: '{{ config('broadcasting.connections.reverb.options.host') }}',
            wsPort: {{ config('broadcasting.connections.reverb.options.port', 8080) }},
            wssPort: {{ config('broadcasting.connections.reverb.options.port', 8080) }},
            forceTLS: false,
            enabledTransports: ['ws', 'wss'],
        });

        function showToast(productName) {
            const container = document.getElementById('toast-container');

            const toast = document.createElement('div');
            toast.className = 'toast';

            const icon = document.createElement('div');
            icon.className = 'toast-icon';
            icon.textContent = '✓';

            const content = document.createElement('div');
            content.className = 'toast-content';

            const title = document.createElement('div');
            title.className = 'toast-title';
            title.textContent = 'Produk berhasil ditambahkan!';

            const message = document.createElement('div');
            message.className = 'toast-message';
            message.textContent = `Produk "${productName}" baru saja ditambahkan.`;

            const close = document.createElement('button');
            close.className = 'toast-close';
            close.type = 'button';
            close.innerHTML = '&times;';
            close.setAttribute('aria-label', 'Tutup notifikasi');

            const progress = document.createElement('div');
            progress.className = 'toast-progress';

            content.append(title, message);
            toast.append(icon, content, close, progress);
            container.appendChild(toast);

            let timeout;

            function removeToast() {
                clearTimeout(timeout);

                if (toast.classList.contains('removing')) return;

                toast.classList.add('removing');

                toast.addEventListener('animationend', () => {
                    toast.remove();
                }, {
                    once: true
                });
            }

            close.addEventListener('click', removeToast);

            timeout = setTimeout(removeToast, 4000);
        }

        echo.channel('products')
            .listen('.product.created', (event) => {
                console.log('Product Created:', event.product);

                showToast(event.product.name);
            });
    </script>

</body>


</html>
