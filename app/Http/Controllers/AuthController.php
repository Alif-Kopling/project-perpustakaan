<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Member;

/**
 * Controller untuk mengelola otentikasi pengguna
 * Termasuk login, registrasi, dan logout
 */
class AuthController extends Controller
{
    /**
     * Menampilkan form login
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menampilkan form registrasi
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Proses login pengguna
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input dari form login
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek apakah kombinasi username dan password cocok
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            $user = Auth::user();

            // Arahkan pengguna ke dashboard sesuai dengan perannya (admin atau siswa)
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } else {
                return redirect()->intended(route('student.dashboard'));
            }
        }

        // Jika login gagal, kembalikan ke halaman sebelumnya dengan pesan error
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    }

    /**
     * Proses registrasi pengguna baru
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validasi input dari form registrasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nit' => 'required|string|max:255',
            'kelas' => 'required|in:X,XI,XII',
            'jurusan' => 'required|in:ATPH,APHP,ATU,APAT,NKN,TKN,NKPI,RPL,TBSM,TITL,TPM,TAB,TLOG,TBG,TBS,UPW',
        ]);

        // Buat akun pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        // Buat data member terkait dengan pengguna
        Member::create([
            'nama' => $request->name,
            'nit' => $request->nit,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'username' => $request->username,
        ]);

        // Login otomatis setelah registrasi berhasil
        Auth::login($user);

        return redirect()->intended(route('student.dashboard'))->with('success', 'Akun berhasil dibuat!');
    }

    /**
     * Proses logout pengguna
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Hapus session otentikasi
        Auth::logout();

        // Hapus semua data session
        $request->session()->invalidate();

        // Regenerasi token CSRF untuk keamanan
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
