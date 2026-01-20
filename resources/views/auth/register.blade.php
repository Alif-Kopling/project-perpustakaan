<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Aplikasi Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --soft-brown: #C4A484;
            --dark-tea-brown: #8B6F47;
            --cream: #F5EFE6;
            --light-beige: #E8DCC8;
            --white: #FFFFFF;
            --border-soft: #D6D3CE;
            --gradient-start: linear-gradient(135deg, #C4A484, #8B6F47);
            --gradient-end: linear-gradient(135deg, #8B6F47, #C4A484);
        }

        body {
            background: var(--gradient-start);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .register-illustration {
            flex: 1;
            background: var(--gradient-start);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .register-illustration::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            top: -100px;
            left: -100px;
        }

        .register-illustration::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            bottom: -80px;
            right: -80px;
        }

        .illustration-content {
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .illustration-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }

        .register-form-section {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 30px;
        }

        .form-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-tea-brown);
            margin-bottom: 8px;
        }

        .form-header p {
            color: #6B7280;
            font-size: 1rem;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #374151;
            font-size: 0.9rem;
        }

        .input-field {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--border-soft);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #FAFAFA;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--soft-brown);
            box-shadow: 0 0 0 3px rgba(196, 164, 132, 0.2);
            background-color: white;
        }

        .btn-register {
            width: 100%;
            padding: 16px;
            background: var(--gradient-start);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(139, 111, 71, 0.3);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .form-footer {
            margin-top: 25px;
            text-align: center;
        }

        .form-footer a {
            color: var(--soft-brown);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .form-footer a:hover {
            color: var(--dark-tea-brown);
            text-decoration: underline;
        }

        .error-message {
            color: #EF4444;
            font-size: 0.8rem;
            margin-top: 4px;
            display: block;
        }

        .success-message {
            background-color: #D1FAE5;
            border: 1px solid #A7F3D0;
            color: #065F46;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            z-index: 10;
        }

        .input-icon input,
        .input-icon select {
            padding-left: 45px;
        }

        .input-icon select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }

        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
                min-height: auto;
            }

            .register-illustration {
                padding: 30px 20px;
            }

            .register-form-section {
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Illustration Section -->
        <div class="register-illustration">
            <div class="illustration-content">
                <div class="illustration-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h2 class="text-2xl font-bold mb-3">Perpustakaan Digital</h2>
                <p class="text-lg opacity-90">Gabung komunitas pembaca dan akses ribuan buku digital</p>
                <div class="mt-8 bg-white bg-opacity-20 rounded-lg p-4 backdrop-blur-sm">
                    <p class="font-medium"><i class="fas fa-check-circle mr-2"></i> Akses Buku Digital</p>
                    <p class="font-medium"><i class="fas fa-check-circle mr-2"></i> Peminjaman Online</p>
                    <p class="font-medium"><i class="fas fa-check-circle mr-2"></i> Fitur Bookmark</p>
                </div>
            </div>
        </div>

        <!-- Registration Form Section -->
        <div class="register-form-section">
            <div class="form-header">
                <h1>Buat Akun Baru</h1>
                <p>Isi formulir di bawah untuk bergabung dengan kami</p>
            </div>

            @if(session('success'))
                <div class="success-message">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="input-group">
                        <label for="name" class="input-label">Nama Lengkap</label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                class="input-field"
                                placeholder="Masukkan nama lengkap"
                                required
                            >
                        </div>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="email" class="input-label">Email</label>
                        <div class="input-icon">
                            <i class="fas fa-envelope"></i>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="input-field"
                                placeholder="contoh@email.com"
                                required
                            >
                        </div>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="input-group">
                        <label for="username" class="input-label">Username</label>
                        <div class="input-icon">
                            <i class="fas fa-at"></i>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                class="input-field"
                                placeholder="Buat username unik"
                                required
                            >
                        </div>
                        @error('username')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="nit" class="input-label">NIT (Nomor Induk Siswa)</label>
                        <div class="input-icon">
                            <i class="fas fa-id-card"></i>
                            <input
                                type="text"
                                id="nit"
                                name="nit"
                                value="{{ old('nit') }}"
                                class="input-field"
                                placeholder="Masukkan NIT Anda"
                                required
                            >
                        </div>
                        @error('nit')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="input-group">
                        <label for="kelas" class="input-label">Kelas</label>
                        <div class="input-icon">
                            <i class="fas fa-school"></i>
                            <select
                                id="kelas"
                                name="kelas"
                                class="input-field"
                                required
                            >
                                <option value="" disabled selected>Pilih Kelas</option>
                                <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>X (Sepuluh)</option>
                                <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>XI (Sebelas)</option>
                                <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>XII (Duabelas)</option>
                            </select>
                        </div>
                        @error('kelas')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="jurusan" class="input-label">Jurusan</label>
                        <div class="input-icon">
                            <i class="fas fa-graduation-cap"></i>
                            <select
                                id="jurusan"
                                name="jurusan"
                                class="input-field"
                                required
                            >
                                <option value="" disabled selected>Pilih Jurusan</option>
                                <option value="ATPH" {{ old('jurusan') == 'ATPH' ? 'selected' : '' }}>Agribisnis Tanaman Pangan & Hortikultura (ATPH)</option>
                                <option value="APHP" {{ old('jurusan') == 'APHP' ? 'selected' : '' }}>Agribisnis Pengolahan Hasil Pertanian (APHP)</option>
                                <option value="ATU" {{ old('jurusan') == 'ATU' ? 'selected' : '' }}>Agribisnis Ternak Unggas (ATU)</option>
                                <option value="APAT" {{ old('jurusan') == 'APAT' ? 'selected' : '' }}>Agribisnis Perikanan Air Tawar (APAT)</option>
                                <option value="NKN" {{ old('jurusan') == 'NKN' ? 'selected' : '' }}>Nautika Kapal Niaga (NKN)</option>
                                <option value="TKN" {{ old('jurusan') == 'TKN' ? 'selected' : '' }}>Teknika Kapal Niaga (TKN)</option>
                                <option value="NKPI" {{ old('jurusan') == 'NKPI' ? 'selected' : '' }}>Nautika Kapal Penangkap Ikan (NKPI)</option>
                                <option value="RPL" {{ old('jurusan') == 'RPL' ? 'selected' : '' }}>Rekayasa Perangkat Lunak (RPL)</option>
                                <option value="TBSM" {{ old('jurusan') == 'TBSM' ? 'selected' : '' }}>Teknik dan Bisnis Sepeda Motor (TBSM)</option>
                                <option value="TITL" {{ old('jurusan') == 'TITL' ? 'selected' : '' }}>Teknik Instalasi Tenaga Listrik (TITL)</option>
                                <option value="TPM" {{ old('jurusan') == 'TPM' ? 'selected' : '' }}>Teknik Pemesinan (TPM)</option>
                                <option value="TAB" {{ old('jurusan') == 'TAB' ? 'selected' : '' }}>Teknik Alat Berat (TAB)</option>
                                <option value="TLOG" {{ old('jurusan') == 'TLOG' ? 'selected' : '' }}>Teknik Logistik (TLOG)</option>
                                <option value="TBG" {{ old('jurusan') == 'TBG' ? 'selected' : '' }}>Tata Boga (kuliner)</option>
                                <option value="TBS" {{ old('jurusan') == 'TBS' ? 'selected' : '' }}>Tata Busana (desain busana)</option>
                                <option value="UPW" {{ old('jurusan') == 'UPW' ? 'selected' : '' }}>Usaha Perjalanan Wisata (UPW)</option>
                            </select>
                        </div>
                        @error('jurusan')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="input-group">
                        <label for="password" class="input-label">Password</label>
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="input-field"
                                placeholder="Buat password kuat"
                                required
                            >
                        </div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="password_confirmation" class="input-label">Konfirmasi Password</label>
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="input-field"
                                placeholder="Ulangi password"
                                required
                            >
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </button>
            </form>

            <div class="form-footer">
                <p class="text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}">Login di sini</a>
                </p>
            </div>

            <div class="mt-8 text-center text-sm text-gray-500">
                <p>© {{ date('Y') }} Aplikasi Perpustakaan. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script>
        // Add focus effects to inputs
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-soft-brown');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-soft-brown');
            });
        });

        // Password strength indicator (optional enhancement)
        document.getElementById('password')?.addEventListener('input', function() {
            const password = this.value;
            const strengthIndicator = document.createElement('div');
            strengthIndicator.className = 'text-xs mt-1';

            if(password.length >= 8) {
                strengthIndicator.textContent = 'Password kuat';
                strengthIndicator.className += ' text-green-500';
            } else if(password.length >= 4) {
                strengthIndicator.textContent = 'Password sedang';
                strengthIndicator.className += ' text-yellow-500';
            } else if(password.length > 0) {
                strengthIndicator.textContent = 'Password lemah';
                strengthIndicator.className += ' text-red-500';
            } else {
                strengthIndicator.textContent = '';
            }

            // Add or update strength indicator
            const parentDiv = this.parentElement.parentElement;
            const existingStrength = parentDiv.querySelector('.password-strength');
            if(existingStrength) {
                existingStrength.remove();
            }
            if(strengthIndicator.textContent) {
                strengthIndicator.className += ' password-strength';
                parentDiv.appendChild(strengthIndicator);
            }
        });
    </script>
</body>
</html>