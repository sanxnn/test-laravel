<?php

namespace App\Http\Controllers;

use App\Events\ProductCreated;
use App\Models\Category;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    public function index()
    {
        $produk = Product::with('category')->latest()->get();

        return view('product.index', compact('produk'));
    }

    public function create()
    {
        $kategori = Category::orderBy('name')->get();

        return view('product.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'sku' => 'required|string|max:100|unique:produk,sku',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ✅ PERBAIKAN: Gunakan helper method untuk proses gambar
        if ($request->hasFile('image')) {
            $validated['image'] = $this->processImage($request->file('image'));
        }

        $product = Product::create($validated);

        event(new ProductCreated($product));

        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $kategori = Category::orderBy('name')->get();

        return view('product.edit', compact('product', 'kategori'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'sku' => ['required', 'string', 'max:100', Rule::unique('produk', 'sku')->ignore($product->id)],
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ✅ LOGIKA UPDATE GAMBAR YANG SAMA DENGAN STORE
        if ($request->hasFile('image')) {
            // 1. Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // 2. Proses gambar baru menggunakan helper method
            $validated['image'] = $this->processImage($request->file('image'));
        }

        // 3. Update data
        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function invoice(Product $product)
    {
        $order = Product::with('category')->findOrFail($product->id);
        $invoice = $order;
        foreach ($invoice as $item) {
            $item->total_price = $item->price * $item->stock;
        }

        $invoice->total = $invoice->sum('total_price');

        $pdf = Pdf::loadView('product.invoice', compact('invoice'));

        return $pdf->download('invoice_'.$product->sku.'.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper: Proses Gambar (Resize & Compress)
    |--------------------------------------------------------------------------
    */
    private function processImage($file): string
    {
        $original = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = strtolower($file->getClientOriginalExtension());

        // Bersihkan nama file dari karakter aneh
        $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $original);
        $filename = time().'_'.$cleanName.'.'.$ext;
        $path = 'products/'.$filename;

        $manager = new ImageManager(Driver::class);

        // Resize dan crop ke 800x800 (cover)
        $image = $manager->decodePath($file->getRealPath())->cover(800, 800);

        // Encode berdasarkan tipe file untuk optimasi ukuran
        if ($ext === 'png') {
            $encoded = $image->encodeUsingFileExtension('png', quality: 90);
        } else {
            $encoded = $image->encodeUsingFileExtension('jpg', quality: 85);
        }

        // Simpan ke storage
        Storage::disk('public')->put($path, $encoded->toString());

        return $path;
    }
}
