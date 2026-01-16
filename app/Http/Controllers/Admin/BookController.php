<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        Book::create($request->all());

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        $book->update($request->all());

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }
    
    /**
     * Import books from CSV
     */
    public function importCsv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file');
        $path = $file->store('temp');
        $filePath = storage_path('app/' . $path);

        $data = array_map('str_getcsv', file($filePath));
        $header = array_shift($data);

        foreach ($data as $row) {
            if (count($row) >= 5) { // Ensure we have enough columns (judul, penulis, penerbit, kategori, stok)
                Book::updateOrCreate(
                    ['judul' => $row[0]], // Assuming judul is in the first column
                    [
                        'judul' => $row[0],
                        'penulis' => $row[1],
                        'penerbit' => $row[2],
                        'kategori' => $row[3],
                        'stok' => $row[4]
                    ]
                );
            }
        }

        Storage::delete($path);

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diimpor dari CSV.');
    }
}