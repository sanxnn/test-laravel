<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        $kategori = Category::latest()->get();

        return view('category.index', compact('kategori'));
    }

    // Menampilkan form tambah kategori
    public function create()
    {
        return view('category.create');
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($validated);

        return redirect()
            ->route('category.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Menampilkan form edit kategori
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    // Memperbarui kategori
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return redirect()
            ->route('category.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    // Menghapus kategori
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('category.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
