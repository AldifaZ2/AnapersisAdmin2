<?php include "../_auth.php";?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Layanan Kebersihan - CleanlyGo</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }
        /* Kustomisasi untuk input range/slider */
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: #4f46e5; /* indigo-600 */
            cursor: pointer;
            border-radius: 50%;
        }
        input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: #4f46e5; /* indigo-600 */
            cursor: pointer;
            border-radius: 50%;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto px-4 py-12 md:py-20">

        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800">Pesan Layanan Kebersihan</h1>
            <p class="text-lg text-gray-600 mt-4 max-w-2xl mx-auto">Lengkapi detail di bawah ini untuk mendapatkan estimasi biaya dan jadwal.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-8">
            
            <div class="lg:col-span-2 bg-white p-8 rounded-xl shadow-lg">
                <form id="booking-form" action="/pelanggan/prosespesanan" method="POST">
                    <div class="space-y-8">
                        
                        <div>
                            <label for="luas-ruangan" class="block text-lg font-semibold text-gray-800 mb-2">Luas Ruangan</label>
                            <div class="flex items-center space-x-4">
                                <input type="range" id="luas-ruangan" name="luas_ruangan" min="20" max="200" value="50" step="5" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                <span class="font-bold text-indigo-600 text-xl w-24 text-center"><span id="luas-value">50</span> m²</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-2">Geser untuk menyesuaikan perkiraan luas area yang akan dibersihkan.</p>
                        </div>

                        <div>
                            <label class="block text-lg font-semibold text-gray-800 mb-3">Tingkat Kekotoran</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <label class="p-4 border rounded-lg cursor-pointer flex items-center space-x-3 hover:border-indigo-500 hover:bg-indigo-50 transition">
                                    <input type="radio" name="tingkat_kotor" value="1.0" class="form-radio text-indigo-600 focus:ring-indigo-500" checked>
                                    <span class="font-medium text-gray-700">Ringan</span>
                                </label>
                                <label class="p-4 border rounded-lg cursor-pointer flex items-center space-x-3 hover:border-indigo-500 hover:bg-indigo-50 transition">
                                    <input type="radio" name="tingkat_kotor" value="1.25" class="form-radio text-indigo-600 focus:ring-indigo-500">
                                    <span class="font-medium text-gray-700">Sedang</span>
                                </label>
                                <label class="p-4 border rounded-lg cursor-pointer flex items-center space-x-3 hover:border-indigo-500 hover:bg-indigo-50 transition">
                                    <input type="radio" name="tingkat_kotor" value="1.5" class="form-radio text-indigo-600 focus:ring-indigo-500">
                                    <span class="font-medium text-gray-700">Berat</span>
                                </label>
                            </div>
                             <p class="text-sm text-gray-500 mt-2">Level kotor akan mempengaruhi durasi dan biaya pembersihan.</p>
                        </div>

                        <div>
                            <label for="jumlah-pekerja" class="block text-lg font-semibold text-gray-800 mb-2">Jumlah Pekerja</label>
                            <select id="jumlah-pekerja" name="jumlah_pekerja" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="1">1 Orang (Rekomendasi)</option>
                                <option value="2">2 Orang (Lebih Cepat)</option>
                                <option value="3">3 Orang (Area Luas/Sangat Kotor)</option>
                            </select>
                            <p class="text-sm text-gray-500 mt-2">Menambah jumlah pekerja akan menyelesaikan pekerjaan lebih cepat.</p>
                        </div>

                        <div>
                             <label for="catatan" class="block text-lg font-semibold text-gray-800 mb-2">Catatan Tambahan (Opsional)</label>
                             <textarea id="catatan" name="catatan" rows="4" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Fokus pada area dapur, ada hewan peliharaan, dll."></textarea>
                        </div>

                        <input type="hidden" name="totalbiaya" id="total_biaya_hidden">
                    </div>
                </form>
            </div>

            <div class="lg:col-span-1 mt-8 lg:mt-0">
                <div class="sticky top-24 bg-white p-8 rounded-xl shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-800 border-b pb-4 mb-4">Estimasi Biaya</h3>
                    <div class="space-y-4 text-gray-600">
                        <div class="flex justify-between items-center">
                            <span>Biaya Dasar Layanan</span>
                            <span id="biaya-dasar" class="font-medium">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Faktor Kebersihan</span>
                            <span id="faktor-kotor" class="font-medium">x1.0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Biaya Tambahan Pekerja</span>
                            <span id="biaya-pekerja" class="font-medium">Rp 0</span>
                        </div>
                    </div>
                    <div class="border-t mt-4 pt-4">
                        <div class="flex justify-between items-center text-xl font-bold text-gray-900">
                            <span>Total Estimasi</span>
                            <span id="total-biaya" class="text-indigo-600">Rp 0</span>
                        </div>
                    </div>
                    <button type="submit" form="booking-form" class="mt-8 w-full block text-center bg-indigo-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-indigo-700 transition duration-300 transform hover:scale-105">
                        <i class="fas fa-credit-card mr-2"></i>
                        Lanjutkan ke Pembayaran
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-20">
            <h2 class="text-3xl font-bold text-center mb-10 text-gray-800">Apa Kata Mereka?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full mr-4" src="https://i.pravatar.cc/150?u=a042581f4e29026704d" alt="Avatar">
                        <div>
                            <p class="font-semibold text-gray-800">Sarah Wijayanti</p>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Pekerjaannya sangat rapi dan detail. Rumah jadi kinclong seperti baru lagi. Sangat direkomendasikan!"</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                     <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full mr-4" src="https://i.pravatar.cc/150?u=a042581f4e29026704e" alt="Avatar">
                        <div>
                            <p class="font-semibold text-gray-800">Budi Santoso</p>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Cukup memuaskan. Datang tepat waktu dan hasilnya bersih. Mungkin bisa lebih cepat jika pekerjanya ditambah."</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                     <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full mr-4" src="https://i.pravatar.cc/150?u=a042581f4e29026704f" alt="Avatar">
                        <div>
                            <p class="font-semibold text-gray-800">Rina Amelia</p>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Layanan terbaik! Proses pemesanan mudah dan estimasi biayanya akurat. Akan pesan lagi bulan depan."</p>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Konfigurasi Harga ---
            const BASE_PRICE_PER_METER = 2500;
            const PRICE_PER_EXTRA_WORKER = 50000;

            // --- Elemen DOM ---
            const bookingForm = document.getElementById('booking-form'); // Mengambil form
            const luasSlider = document.getElementById('luas-ruangan');
            const luasValueDisplay = document.getElementById('luas-value');
            const tingkatKotorRadios = document.querySelectorAll('input[name="tingkat_kotor"]');
            const jumlahPekerjaSelect = document.getElementById('jumlah-pekerja');
            
            // Elemen Tampilan Biaya & Input Tersembunyi
            const biayaDasarDisplay = document.getElementById('biaya-dasar');
            const faktorKotorDisplay = document.getElementById('faktor-kotor');
            const biayaPekerjaDisplay = document.getElementById('biaya-pekerja');
            const totalBiayaDisplay = document.getElementById('total-biaya');
            const totalBiayaHiddenInput = document.getElementById('total_biaya_hidden');

            // --- Fungsi untuk Kalkulasi Biaya ---
            function calculateCost() {
                const luas = parseInt(luasSlider.value);
                const tingkatKotorFactor = parseFloat(document.querySelector('input[name="tingkat_kotor"]:checked').value);
                const jumlahPekerja = parseInt(jumlahPekerjaSelect.value);

                let biayaDasar = luas * BASE_PRICE_PER_METER;
                let finalBiayaDasar = biayaDasar * tingkatKotorFactor;
                let biayaPekerja = (jumlahPekerja - 1) * PRICE_PER_EXTRA_WORKER;
                let totalEstimasi = finalBiayaDasar + biayaPekerja;

                const formatCurrency = (amount) => `Rp ${amount.toLocaleString('id-ID')}`;
                
                luasValueDisplay.textContent = luas;
                biayaDasarDisplay.textContent = formatCurrency(biayaDasar);
                faktorKotorDisplay.textContent = `x${tingkatKotorFactor.toFixed(2)}`;
                biayaPekerjaDisplay.textContent = formatCurrency(biayaPekerja);
                totalBiayaDisplay.textContent = formatCurrency(totalEstimasi);

                // Mengisi nilai ke input tersembunyi
                totalBiayaHiddenInput.value = totalEstimasi;
            }

            // --- Event Listeners untuk Kalkulasi Otomatis ---
            luasSlider.addEventListener('input', calculateCost);
            tingkatKotorRadios.forEach(radio => radio.addEventListener('change', calculateCost));
            jumlahPekerjaSelect.addEventListener('change', calculateCost);

            // Panggil kalkulasi saat halaman pertama kali dimuat
            calculateCost();

            // --- Event Listener untuk Form Submission ---
            // Kode ini tidak lagi diperlukan karena kita menggunakan form submission standar
            // Tombol submit akan secara otomatis mengirimkan data dari form
            // ke 'action' yang telah ditentukan, yaitu '/proses-pesanan'.
            // Pastikan Anda telah membuat skrip PHP di '/proses-pesanan' untuk menangani data ini.

        });
    </script>

</body>
</html>