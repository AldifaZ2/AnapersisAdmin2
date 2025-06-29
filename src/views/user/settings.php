<?php include "_auth.php";?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun - CleanlyGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        /* Menggunakan font Inter sebagai default */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Style untuk placeholder kustom */
        ::placeholder {
            color: #9ca3af; /* gray-400 */
        }
    </style>
</head>
<body class="bg-gray-50">

    <div class="flex flex-col items-center justify-center min-h-screen p-4">

        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
            
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-indigo-600">Pengaturan Akun</h1>
                <p class="text-gray-500 mt-2">Perbarui informasi profil Anda di sini.</p>
            </div>

            <form id="settings-form">
                <div class="space-y-6">
                    
                    <div>
                        <label for="fullname" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <div class="relative">
                           <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                               <i class="fas fa-user text-gray-400"></i>
                           </div>
                           <input type="text" id="fullname" name="fullname" class="w-full pl-10 pr-4 py-2 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed" value="<?= $nama?>" readonly>
                        </div>
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                            <input type="text" id="username" name="username" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan Username Anda" value="<?= $username?>">
                        </div>
                    </div>

                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                         <div class="relative">
                            <div class="absolute top-3.5 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                            <textarea id="alamat" name="alamat" rows="3" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan alamat lengkap Anda"><?= $alamat?></textarea>
                        </div>
                    </div>

                    <div>
                        <label for="noHp" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                            <input type="tel" id="noHp" name="noHp" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: 081234567890" value="<?= $nomorTelepon?>">
                        </div>
                    </div>
                </div>

                <div class="mt-8 space-y-4">
                    <button type="submit" id="save-button" class="w-full flex items-center justify-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 px-4 rounded-lg hover:shadow-lg hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-transform transform hover:scale-105 duration-300">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                    
                    <a href="/" class="w-full flex items-center justify-center bg-gray-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>

                    <button type="button" id="logout-button" class="w-full flex items-center justify-center bg-transparent border border-red-500 text-red-500 font-semibold py-3 px-4 rounded-lg hover:bg-red-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </div>
            </form>
            
        </div>
        
        <p class="text-center text-gray-500 text-sm mt-6">&copy; <span id="current-year"></span> CleanlyGo. Semua Hak Cipta Dilindungi.</p>

    </div>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // Ambil elemen-elemen yang diperlukan dari DOM
        const settingsForm = document.getElementById('settings-form');
        const logoutButton = document.getElementById('logout-button');

        // Event listener untuk form submission (tombol Simpan)
        settingsForm.addEventListener('submit', async function(event) {
            // Mencegah perilaku default form (yang akan me-refresh halaman)
            event.preventDefault();

            const formData = new FormData();
            formData.append("username", document.getElementById("username").value);
            formData.append("alamat", document.getElementById("alamat").value);
            formData.append("noHp", document.getElementById("noHp").value);

            try {
                const response = await fetch('/pelanggan/save', {
                    method: "POST",
                    body: formData
                })

                const result = await response.text();
                console.log(result);

                // Tampilkan notifikasi toast dengan ToastifyJS
                Toastify({
                    text: "Data Anda berhasil disimpan!",
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #4f46e5, #a855f7)", // Gradien indigo-ungu
                        borderRadius: "8px",
                    },
                    onClick: function(){} // Callback after click
                }).showToast();
            } catch (error) {
                console.log(error)

                // Tampilkan notifikasi toast dengan ToastifyJS
                Toastify({
                    text: "Data gagal disimpan",
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #4f46e5, #a855f7)", // Gradien indigo-ungu
                        borderRadius: "8px",
                    },
                    onClick: function(){} // Callback after click
                }).showToast();
            }
        });

        // Event listener untuk tombol Logout
        logoutButton.addEventListener('click', function() {
            // Simulasi proses logout
            if (confirm('Apakah Anda yakin ingin logout?')) {
                window.location.href = '/auth/logout'
            }
        });
    </script>

</body>
</html>