<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

/**
 * Controller untuk mengelola data buku
 * Termasuk CRUD (Create, Read, Update, Delete) dan impor dari CSV
 */
class BookController extends Controller
{
    /**
     * Menampilkan daftar semua buku
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Book::query();

        // Tambahkan pencarian jika ada parameter pencarian
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('judul', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('penulis', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('penerbit', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('kategori', 'LIKE', "%{$searchTerm}%");
            });
        }

        $books = $query->paginate(10); // Gunakan paginate untuk mendukung pagination

        return view('admin.books.index', compact('books'));
    }

    /**
     * Menampilkan form untuk membuat buku baru
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Menyimpan buku baru ke database
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        // Simpan data buku baru ke database
        Book::create($request->all());

        // Redirect ke halaman daftar buku dengan pesan sukses
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail buku tertentu
     * @param Book $book
     * @return \Illuminate\View\View
     */
    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    /**
     * Menampilkan form untuk mengedit buku
     * @param Book $book
     * @return \Illuminate\View\View
     */
    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Memperbarui data buku di database
     * @param Request $request
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Book $book)
    {
        // Validasi input dari form edit
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        // Update data buku
        $book->update($request->all());

        // Redirect ke halaman daftar buku dengan pesan sukses
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Menghapus buku dari database
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Book $book)
    {
        // Hapus data buku
        $book->delete();

        // Redirect ke halaman daftar buku dengan pesan sukses
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }

    /**
     * Impor data buku dari file CSV
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importCsv(Request $request)
    {
        // Validasi file yang diupload
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan file sementara
        $file = $request->file('file');
        $path = $file->store('temp');
        $filePath = storage_path('app/' . $path);

        // Baca data dari file CSV
        $data = array_map('str_getcsv', file($filePath));
        $header = array_shift($data);

        // Loop melalui setiap baris data
        foreach ($data as $row) {
            // Pastikan jumlah kolom cukup (judul, penulis, penerbit, kategori, stok)
            if (count($row) >= 5) {
                // Buat atau update data buku berdasarkan judul
                Book::updateOrCreate(
                    ['judul' => $row[0]], // Cek keberadaan buku berdasarkan judul
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

        // Hapus file sementara setelah selesai
        Storage::delete($path);

        // Redirect ke halaman daftar buku dengan pesan sukses
        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diimpor dari CSV.');
    }
}