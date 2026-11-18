<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
        @page { margin: 8pt; }
        body { margin: 0; font-family: monospace; font-size: 8pt; }
        .header, .footer { text-align: center; }
        h1 { font-size: 10pt; margin: 0 0 4pt; }
        p { margin: 2pt 0; }
        table { width: 100%; border-collapse: collapse; margin: 8pt 0; }
        td { padding: 4pt 0; vertical-align: top; }
        .amount { text-align: right; white-space: nowrap; }
        tbody { border-top: 1pt dashed #000; }
        tfoot { border-top: 1pt dashed #000; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>TOKO CONTOH</h1>
        <p>Jl. Contoh No. 123</p>
        <p>Telp: (021) 12345678</p>
    </div>

    <table>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['qty'] }} x</td>
                    <td class="amount">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td class="amount" colspan="2">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <p>Pembayaran: {{ $method }}</p>
    <p>Dibayar: Rp {{ number_format($payment, 0, ',', '.') }}</p>
    <p>Kembalian: Rp {{ number_format($change, 0, ',', '.') }}</p>

    <p class="footer">Terima kasih</p>
</body>
</html>
