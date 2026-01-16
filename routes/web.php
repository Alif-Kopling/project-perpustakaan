<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Routes untuk autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Routes untuk admin (memerlukan autentikasi dan role admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Routes untuk buku
    Route::resource('books', \App\Http\Controllers\Admin\BookController::class)->names([
        'index' => 'admin.books.index',
        'create' => 'admin.books.create',
        'store' => 'admin.books.store',
        'show' => 'admin.books.show',
        'edit' => 'admin.books.edit',
        'update' => 'admin.books.update',
        'destroy' => 'admin.books.destroy'
    ]);

    // Routes untuk import buku
    Route::post('/books/import', [\App\Http\Controllers\Admin\BookController::class, 'importCsv'])->name('admin.books.import');

    // Routes untuk anggota
    Route::resource('members', \App\Http\Controllers\Admin\MemberController::class)->names([
        'index' => 'admin.members.index',
        'create' => 'admin.members.create',
        'store' => 'admin.members.store',
        'show' => 'admin.members.show',
        'edit' => 'admin.members.edit',
        'update' => 'admin.members.update',
        'destroy' => 'admin.members.destroy'
    ]);

    // Routes untuk import anggota
    Route::post('/members/import', [\App\Http\Controllers\Admin\MemberController::class, 'importCsv'])->name('admin.members.import');

    // Routes untuk transaksi
    Route::resource('transactions', \App\Http\Controllers\Admin\TransactionController::class)->names([
        'index' => 'admin.transactions.index',
        'create' => 'admin.transactions.create',
        'store' => 'admin.transactions.store',
        'show' => 'admin.transactions.show',
        'edit' => 'admin.transactions.edit',
        'update' => 'admin.transactions.update',
        'destroy' => 'admin.transactions.destroy'
    ]);

});

// Routes untuk siswa (memerlukan autentikasi dan role siswa)
Route::middleware(['auth', 'role:siswa'])->prefix('student')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student.dashboard');


    // Routes untuk buku
    Route::get('/books', [\App\Http\Controllers\Student\BookController::class, 'index'])->name('student.books.index');

    // Routes untuk transaksi
    Route::get('/transactions', [\App\Http\Controllers\Student\TransactionController::class, 'index'])->name('student.transactions.index');
});

// Jika user sudah login, arahkan ke dashboard sesuai role
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('student.dashboard');
        }
    }
    return redirect()->route('login');
});
