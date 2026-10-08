<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $book = Book::all();
        return response()->json([
            'data' => $book,
            'status' => 'success',
        ], 200);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        $book = Book::create($validate);
        return response()->json([
            'data' => $book,
            'status' => 'success',
        ], 201);
    }

    public function show(int $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
                'status' => 'error',
            ], 404);
        }
        return response()->json([
            'data' => $book,
            'status' => 'success',
        ], 200);
    }

    public function update(Request $request, int $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
                'status' => 'error',
            ], 404);
        }
        $validate = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|max:255',
        ]);
        $book->update($validate);
        return response()->json([
            'data' => $book,
            'status' => 'success',
        ], 200);
    }

    public function destroy(int $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
                'status' => 'error',
            ], 404);
        }
        $book->delete();
        return response()->json([
            'message' => 'Book deleted successfully',
            'status' => 'success',
        ], 200);
    }
}
