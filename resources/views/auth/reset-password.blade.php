<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Aplikasi Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7ec 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .book-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c4a484' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zm6 30v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm-36-6h2v-4h4v-2h-4V8h-2v4H8v2h4zm0 6h2v4h4v2h-4v4h-2v-4H8v-2h4zm36-12h2v-4h4V8h-4V4h-2v4h-4v2h4zm-6 18v-2h-4v-4h-2v4h-4v2h4v4h2v-4h4zm-24-24v2h4v4h2v-4h4v-2h-4V8h-2v4h-4z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(196, 164, 132, 0.3);
            transform: translateY(-2px);
        }

        .btn-reset {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-reset::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-reset:hover::before {
            left: 100%;
        }

        .btn-reset:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #8B6F47;
        }

        .input-with-icon {
            padding-left: 2.5rem;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #8B6F47;
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .illustration-section {
                display: none;
            }

            .login-container {
                width: 100%;
                max-width: 100%;
                padding: 1rem;
            }
        }

        @media (max-width: 640px) {
            .mobile-padding {
                padding: 1rem;
            }

            .mobile-text {
                font-size: 0.9rem;
            }

            .mobile-icon {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body class="book-pattern flex items-center justify-center min-h-screen p-4">
    <div class="container mx-auto flex flex-col lg:flex-row items-center justify-between gap-8">
        <!-- Left side - Illustration -->
        <div class="illustration-section hidden lg:block w-full lg:w-1/2 text-center">
            <div class="floating">
                <i class="fas fa-unlock text-9xl text-amber-600 mb-6"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Reset Password</h1>
            <h2 class="text-3xl font-semibold text-amber-700 mb-6">Buat Password Baru</h2>
            <p class="text-gray-600 text-lg max-w-md mx-auto">
                Silakan masukkan password baru Anda untuk mengganti password lama Anda.
            </p>
            <div class="mt-8 flex justify-center space-x-4">
                <div class="bg-white p-4 rounded-xl shadow-lg transform rotate-6">
                    <i class="fas fa-lock text-3xl text-amber-600"></i>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-lg transform -rotate-3">
                    <i class="fas fa-key text-3xl text-amber-600"></i>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-lg transform rotate-2">
                    <i class="fas fa-shield-alt text-3xl text-amber-600"></i>
                </div>
            </div>
        </div>

        <!-- Right side - Reset Password Form -->
        <div class="login-container w-full lg:w-1/2 max-w-md">
            <div class="glass-effect rounded-2xl shadow-2xl p-8 md:p-10 mobile-padding">
                <div class="text-center mb-8">
                    <div class="mx-auto bg-amber-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-lock text-2xl text-amber-700"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800">Reset Password</h1>
                    <p class="text-gray-600 mt-2">Buat password baru untuk akun Anda</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="input-with-icon w-full px-4 py-3 pl-10 pr-12 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-500 input-focus bg-white bg-opacity-80"
                            placeholder="Masukkan password baru"
                            required
                        >
                        <span class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </span>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="input-with-icon w-full px-4 py-3 pl-10 pr-12 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-500 input-focus bg-white bg-opacity-80"
                            placeholder="Konfirmasi password baru"
                            required
                        >
                        <span class="password-toggle" id="togglePasswordConfirmation">
                            <i class="fas fa-eye"></i>
                        </span>
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-reset w-full bg-gradient-to-r from-amber-600 to-amber-700 text-white py-3 px-4 rounded-lg font-semibold text-lg shadow-lg">
                        <i class="fas fa-key mr-2"></i> Reset Password
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600 text-sm mobile-text">
                        Ingat password Anda?
                        <a href="{{ route('login') }}" class="text-amber-600 font-medium hover:text-amber-800 transition duration-200">
                            Kembali ke login
                        </a>
                    </p>
                </div>
            </div>

            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    © {{ date('Y') }} Aplikasi Perpustakaan. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Toggle password confirmation visibility
        document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
            const passwordInput = document.getElementById('password_confirmation');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Add subtle animation to inputs on focus
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-3px)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>