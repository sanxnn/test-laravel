<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReceiptController extends Controller
{
    public function print(Request $request): Response
    {
        $products = [
            1 => ['name' => 'Indomie Goreng', 'price' => 3500],
            2 => ['name' => 'Aqua 600ml', 'price' => 4000],
            3 => ['name' => 'Teh Botol Sosro', 'price' => 5000],
            4 => ['name' => 'Beras 5 Kg', 'price' => 75000],
        ];

        $requestedItems = json_decode((string) $request->query('items'), true);
        $requestedItems = is_array($requestedItems) ? $requestedItems : [
            ['id' => 1, 'qty' => 1],
            ['id' => 2, 'qty' => 1],
        ];

        $items = [];
        foreach ($requestedItems as $requestedItem) {
            $id = (int) ($requestedItem['id'] ?? 0);
            $quantity = max(1, (int) ($requestedItem['qty'] ?? 1));

            if (! isset($products[$id])) {
                continue;
            }

            $items[] = [
                ...$products[$id],
                'qty' => $quantity,
                'subtotal' => $products[$id]['price'] * $quantity,
            ];
        }

        $total = array_sum(array_column($items, 'subtotal'));
        $payment = max(0, (int) $request->query('payment', $total));
        $change = max(0, $payment - $total);
        $method = (string) $request->query('method', 'Tunai');

        return Pdf::loadView('receipt', compact('items', 'total', 'payment', 'change', 'method'))
            ->setPaper([0, 0, 164.41, 340.16])
            ->stream('struk-pembayaran.pdf');
    }
}
