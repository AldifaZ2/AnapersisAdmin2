<?php
if (session_status() === PHP_SESSION_NONE) {
    require __DIR__ . '/../../config/session.php';
}

if (isset($_SESSION['id_user'])) {
    header('Location: /');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Menggunakan font Inter sebagai default */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Menyembunyikan form register secara default */
        #register-form {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-50">

    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
             <a href="#" class="text-4xl font-bold text-indigo-600">CleanlyGo</a>
        </div>

        <div class="max-w-md w-full bg-white p-8 md:p-10 rounded-xl shadow-lg space-y-8">

            <div class="flex border-b border-gray-200">
                <button id="login-tab" class="flex-1 py-2 px-4 text-center font-medium text-indigo-600 border-b-2 border-indigo-600 focus:outline-none" onclick="showForm('login')">
                    Login
                </button>
                <button id="register-tab" class="flex-1 py-2 px-4 text-center font-medium text-gray-500 hover:text-gray-700 focus:outline-none" onclick="showForm('register')">
                    Register
                </button>
            </div>

            <div id="login-form">
                <h2 class="text-center text-2xl font-bold text-gray-900 mb-6">
                    Masuk ke Akun Anda
                </h2>
                <form class="space-y-6" action="/auth/login" method="POST">
                    <input type="hidden" name="remember" value="true">
                    <div class="rounded-md shadow-sm -space-y-px">
                        <div>
                            <label for="login-email-address" class="sr-only">Alamat Email</label>
                            <input id="login-email-address" name="email" type="email" autocomplete="email" required
                                   class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                   placeholder="Alamat Email">
                        </div>
                        <div>
                            <label for="login-password" class="sr-only">Password</label>
                            <input id="login-password" name="password" type="password" autocomplete="current-password" required
                                   class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                   placeholder="Password">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                                Ingat saya
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                Lupa password?
                            </a>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                            Login
                        </button>

                        <?php if (!empty($error) && $form === 'login'): ?>
                            <p class="mt-2 text-sm text-red-600 text-center"><?= $error?></p>
                        <?php endif; ?>
                    </div>
                     <p class="mt-4 text-center text-sm text-gray-600">
                        Belum punya akun?
                        <button type="button" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none" onclick="showForm('register')">
                            Daftar di sini
                        </button>
                    </p>
                </form>
            </div>

            <div id="register-form">
                 <h2 class="text-center text-2xl font-bold text-gray-900 mb-6">
                    Buat Akun Baru
                </h2>
                <form class="space-y-6" action="/auth/signup" method="POST">
                     <div class="rounded-md shadow-sm -space-y-px">
                         <div>
                            <label for="register-name" class="sr-only">Nama Lengkap</label>
                            <input id="register-name" name="name" type="text" autocomplete="name" required
                                   class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                   placeholder="Nama Lengkap">
                        </div>
                        <div>
                            <label for="register-email-address" class="sr-only">Alamat Email</label>
                            <input id="register-email-address" name="email" type="email" autocomplete="email" required
                                   class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                   placeholder="Alamat Email">
                        </div>
                        <div>
                            <label for="register-password" class="sr-only">Password</label>
                            <input id="register-password" name="password" type="password" autocomplete="new-password" required
                                   class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                   placeholder="Password">
                        </div>
                         <div>
                            <label for="confirm-password" class="sr-only">Konfirmasi Password</label>
                            <input id="confirm-password" name="confirmPassword" type="password" autocomplete="new-password" required
                                   class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                   placeholder="Konfirmasi Password">
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                            Register
                        </button>

                        <?php if (!empty($error) && $form === 'signup'): ?>
                            <p class="mt-2 text-sm text-red-600 text-center"><?= $error?></p>
                        <?php endif; ?>
                    </div>
                     <p class="mt-4 text-center text-sm text-gray-600">
                        Sudah punya akun?
                        <button type="button" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none" onclick="showForm('login')">
                            Login di sini
                        </button>
                    </p>
                </form>
            </div>

        </div> <div class="mt-6 text-center text-sm text-gray-600">
            <a href="/" class="font-medium text-indigo-600 hover:text-indigo-500">
                &larr; Kembali ke Homepage
            </a>
        </div>

    </div> 
    
    <script>
        // Mengambil elemen-elemen yang dibutuhkan
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const loginTab = document.getElementById('login-tab');
        const registerTab = document.getElementById('register-tab');

        // Fungsi untuk menampilkan form yang dipilih dan menyembunyikan yang lain
        function showForm(formType) {
            if (formType === 'login') {
                // Tampilkan form login, sembunyikan register
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
                // Atur gaya tab aktif/non-aktif
                loginTab.classList.add('text-indigo-600', 'border-indigo-600');
                loginTab.classList.remove('text-gray-500', 'hover:text-gray-700');
                registerTab.classList.add('text-gray-500', 'hover:text-gray-700');
                registerTab.classList.remove('text-indigo-600', 'border-indigo-600');
            } else if (formType === 'register') {
                // Tampilkan form register, sembunyikan login
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
                // Atur gaya tab aktif/non-aktif
                registerTab.classList.add('text-indigo-600', 'border-indigo-600');
                registerTab.classList.remove('text-gray-500', 'hover:text-gray-700');
                loginTab.classList.add('text-gray-500', 'hover:text-gray-700');
                loginTab.classList.remove('text-indigo-600', 'border-indigo-600');
            }
        }

        // Inisialisasi: Tampilkan form login saat halaman dimuat
        window.onload = function () {
        <?php if (!empty($form) && $form === 'signup'): ?>
            showForm('register');
        <?php else: ?>
            showForm('login');
        <?php endif; ?>
        };
    </script>
</body>
</html>