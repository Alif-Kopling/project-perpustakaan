<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Rute Web
|--------------------------------------------------------------------------
|
| Disini tempat Anda mendaftarkan rute-rute web untuk aplikasi.
| Rute-rute ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditetapkan ke grup middleware "web". Buat sesuatu yang hebat!
|
*/

// Rute-rute untuk otentikasi (login, logout, registrasi)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk registrasi siswa
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rute untuk lupa password
use App\Http\Controllers\Auth\PasswordResetController;

Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

// Rute-rute untuk admin (memerlukan otentikasi dan role admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/chart-data', [\App\Http\Controllers\Admin\DashboardController::class, 'getChartData'])->name('admin.dashboard.chart-data');

    // Rute-rute untuk pengelolaan buku
    Route::resource('books', \App\Http\Controllers\Admin\BookController::class)->names([
        'index' => 'admin.books.index',      // Halaman daftar buku
        'create' => 'admin.books.create',    // Halaman tambah buku
        'store' => 'admin.books.store',      // Proses tambah buku
        'show' => 'admin.books.show',        // Halaman detail buku
        'edit' => 'admin.books.edit',        // Halaman edit buku
        'update' => 'admin.books.update',    // Proses edit buku
        'destroy' => 'admin.books.destroy'   // Proses hapus buku
    ]);

    // Rute untuk impor data buku dari CSV
    Route::post('/books/import', [\App\Http\Controllers\Admin\BookController::class, 'importCsv'])->name('admin.books.import');

    // Rute-rute untuk pengelolaan anggota
    Route::resource('members', \App\Http\Controllers\Admin\MemberController::class)->names([
        'index' => 'admin.members.index',    // Halaman daftar anggota
        'create' => 'admin.members.create',  // Halaman tambah anggota
        'store' => 'admin.members.store',    // Proses tambah anggota
        'show' => 'admin.members.show',      // Halaman detail anggota
        'edit' => 'admin.members.edit',      // Halaman edit anggota
        'update' => 'admin.members.update',  // Proses edit anggota
        'destroy' => 'admin.members.destroy' // Proses hapus anggota
    ]);

    // Rute untuk impor data anggota dari CSV
    Route::post('/members/import', [\App\Http\Controllers\Admin\MemberController::class, 'importCsv'])->name('admin.members.import');

    // Rute-rute untuk pengelolaan transaksi
    Route::resource('transactions', \App\Http\Controllers\Admin\TransactionController::class)->names([
        'index' => 'admin.transactions.index',  // Halaman daftar transaksi
        'create' => 'admin.transactions.create', // Halaman tambah transaksi
        'store' => 'admin.transactions.store',   // Proses tambah transaksi
        'show' => 'admin.transactions.show',     // Halaman detail transaksi
        'edit' => 'admin.transactions.edit',     // Halaman edit transaksi
        'update' => 'admin.transactions.update', // Proses edit transaksi
        'destroy' => 'admin.transactions.destroy'// Proses hapus transaksi
    ]);

});

// Rute-rute untuk siswa (memerlukan otentikasi dan role siswa)
Route::middleware(['auth', 'role:siswa'])->prefix('student')->group(function () {
    // Dashboard siswa
    Route::get('/dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/dashboard/chart-data', [\App\Http\Controllers\Student\DashboardController::class, 'getChartData'])->name('student.dashboard.chart-data');

    // Rute-rute untuk buku
    Route::get('/books', [\App\Http\Controllers\Student\BookController::class, 'index'])->name('student.books.index');           // Halaman daftar buku
    Route::post('/books/{book}/borrow', [\App\Http\Controllers\Student\BookController::class, 'borrow'])->name('student.books.borrow'); // Proses peminjaman buku

    // Rute-rute untuk transaksi
    Route::get('/transactions', [\App\Http\Controllers\Student\TransactionController::class, 'index'])->name('student.transactions.index'); // Halaman daftar transaksi siswa
    Route::put('/transactions/{transaction}/return', [\App\Http\Controllers\Student\TransactionController::class, 'returnBook'])->name('student.transactions.return'); // Proses pengembalian buku
});

// Rute utama - jika user sudah login, arahkan ke dashboard sesuai role
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdmin()) {
            // Jika user adalah admin, arahkan ke dashboard admin
            return redirect()->route('admin.dashboard');
        } else {
            // Jika user adalah siswa, arahkan ke dashboard siswa
            return redirect()->route('student.dashboard');
        }
    }
    // Jika user belum login, arahkan ke halaman login
    return redirect()->route('login');
});
