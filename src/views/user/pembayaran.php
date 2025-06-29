<?php
// views.zip/user/pembayaran.php
include "_auth.php"; // Memastikan pengguna sudah login

// Di sini Anda akan mengambil data pesanan yang akan dibayar.
// Untuk demonstrasi, kita akan gunakan data dummy.
// Dalam aplikasi nyata, ini bisa datang dari session, database, atau parameter URL.
$pesanan = [
    'id' => 'ORD-12345',
    'deskripsi' => 'Layanan Kebersihan Mendalam',
    'jumlah' => $harga,
    'mata_uang' => 'IDR'
];

// Anda juga bisa memiliki data pengguna dari sesi seperti di settings.php
$nama_pengguna = $_SESSION['nama'] ?? 'Pengguna CleanlyGo';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pesanan - CleanlyGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Style untuk menyembunyikan div detail pembayaran secara default */
        .payment-detail {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-600 mb-2">Konfirmasi Pembayaran</h1>
            <p class="text-gray-600">Pesanan Anda: <span class="font-semibold"><?= htmlspecialchars($pesanan['deskripsi']) ?></span></p>
            <p class="text-gray-800 text-2xl font-bold mt-2">Total: Rp<?= number_format($pesanan['jumlah'], 0, ',', '.') ?></p>
        </div>

        <form id="payment-form">
            <input type="hidden" name="id_pesanan" value="<?= htmlspecialchars($pesanan['id']) ?>">
            <input type="hidden" name="jumlah_pembayaran" value="<?= htmlspecialchars($pesanan['jumlah']) ?>">

            <div class="space-y-6 mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Pilih Metode Pembayaran</h3>

                <div class="border border-gray-200 rounded-lg p-4 flex items-center">
                    <input type="radio" id="qris" name="payment_method" value="qris" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                    <label for="qris" class="ml-3 text-lg font-medium text-gray-700 flex-1 cursor-pointer">QRIS</label>
                    <img src="https://via.placeholder.com/40x40?text=QR" alt="QRIS Logo" class="h-10 w-10">
                </div>

                <div class="border border-gray-200 rounded-lg p-4 flex items-center">
                    <input type="radio" id="kredit" name="payment_method" value="kredit" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                    <label for="kredit" class="ml-3 text-lg font-medium text-gray-700 flex-1 cursor-pointer">Transfer Bank / Kartu Kredit</label>
                    <i class="fas fa-credit-card text-purple-600 text-2xl"></i>
                </div>

                <div class="border border-gray-200 rounded-lg p-4 flex items-center">
                    <input type="radio" id="cash" name="payment_method" value="cash" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                    <label for="cash" class="ml-3 text-lg font-medium text-gray-700 flex-1 cursor-pointer">Cash / Bayar di Tempat</label>
                    <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
                </div>
            </div>

            <div id="qris-details" class="payment-detail bg-indigo-50 border border-indigo-200 rounded-lg p-6 mb-6 text-center">
                <h4 class="text-xl font-semibold text-indigo-700 mb-4">Scan untuk Membayar dengan QRIS</h4>
                <div class="flex justify-center mb-4">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=CleanlyGo-ORD-<?= htmlspecialchars($pesanan['id']) ?>" alt="QR Code Pembayaran" class="w-48 h-48 border border-gray-300 rounded-md p-2">
                </div>
                <p class="text-gray-700 text-sm">Gunakan aplikasi e-wallet atau mobile banking Anda untuk memindai QR code di atas.</p>
                <p class="text-sm font-medium text-indigo-600 mt-2">Pastikan jumlah pembayaran Rp<?= number_format($pesanan['jumlah'], 0, ',', '.') ?></p>
            </div>

            <div id="kredit-details" class="payment-detail bg-purple-50 border border-purple-200 rounded-lg p-6 mb-6">
                <h4 class="text-xl font-semibold text-purple-700 mb-4">Informasi Transfer Bank</h4>
                <div class="space-y-4">
                    <div>
                        <label for="bank-name" class="block text-sm font-medium text-gray-700 mb-1">Nama Bank</label>
                        <input type="text" id="bank-name" name="bank_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Contoh: BCA / Mandiri">
                    </div>
                    <div>
                        <label for="account-number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Rekening</label>
                        <input type="text" id="account-number" name="account_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Masukkan nomor rekening Anda">
                    </div>
                    <div>
                        <label for="account-holder" class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik Rekening</label>
                        <input type="text" id="account-holder" name="account_holder" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Nama sesuai rekening bank">
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Mohon lakukan transfer ke rekening virtual CleanlyGo yang akan diberikan setelah konfirmasi.</p>
                </div>
            </div>

            <div id="cash-details" class="payment-detail bg-green-50 border border-green-200 rounded-lg p-6 mb-6 text-center">
                <h4 class="text-xl font-semibold text-green-700 mb-4">Pembayaran Tunai di Tempat</h4>
                <p class="text-gray-700 mb-4">Anda telah memilih pembayaran tunai. Petugas kami akan menerima pembayaran langsung saat layanan selesai diberikan.</p>
                <p class="text-sm font-medium text-green-600">Mohon siapkan uang tunai sejumlah Rp<?= number_format($pesanan['jumlah'], 0, ',', '.') ?>.</p>
            </div>

            <div class="mt-8 flex justify-between items-center">
                <a href="/pelanggan/layanan" class="text-gray-600 hover:text-gray-800 font-medium transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <button type="submit" id="submit-payment" class="bg-indigo-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> Konfirmasi Pembayaran
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
            const qrisDetails = document.getElementById('qris-details');
            const kreditDetails = document.getElementById('kredit-details');
            const cashDetails = document.getElementById('cash-details');
            const paymentForm = document.getElementById('payment-form');
            const submitButton = document.getElementById('submit-payment');

            function showPaymentDetails(method) {
                // Sembunyikan semua detail terlebih dahulu
                qrisDetails.style.display = 'none';
                kreditDetails.style.display = 'none';
                cashDetails.style.display = 'none';

                // Tampilkan detail yang sesuai
                if (method === 'qris') {
                    qrisDetails.style.display = 'block';
                } else if (method === 'kredit') {
                    kreditDetails.style.display = 'block';
                } else if (method === 'cash') {
                    cashDetails.style.display = 'block';
                }
            }

            // Tambahkan event listener untuk setiap radio button
            paymentMethodRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    showPaymentDetails(this.value);
                });
            });

            // Handle form submission
            paymentForm.addEventListener('submit', async function(event) {
                event.preventDefault(); // Mencegah form dari submit secara default

                const selectedMethod = document.querySelector('input[name="payment_method"]:checked');

                if (!selectedMethod) {
                    alert('Mohon pilih metode pembayaran terlebih dahulu!');
                    return;
                }

                // Nonaktifkan tombol submit untuk mencegah double click
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';

                const formData = new FormData(paymentForm);
                formData.append('selected_method', selectedMethod.value);

                // Tambahkan data spesifik berdasarkan metode pembayaran
                if (selectedMethod.value === 'kredit') {
                    formData.append('bank_name', document.getElementById('bank-name').value);
                    formData.append('account_number', document.getElementById('account-number').value);
                    formData.append('account_holder', document.getElementById('account-holder').value);
                }
                // Untuk QRIS dan Cash, data yang dibutuhkan sudah ada di hidden input atau tidak ada input tambahan

                try {
                    // Dalam aplikasi nyata, endpoint ini akan memproses pembayaran di sisi server
                    const response = await fetch('/api/process-payment', { // Ganti dengan endpoint PHP Anda
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json(); // Asumsi server mengembalikan JSON

                    if (result.success) {
                        alert('Pembayaran berhasil dikonfirmasi! ' + result.message);
                        // Redirect ke halaman sukses atau riwayat pesanan
                        window.location.href = '/pelanggan/pesanan'; // Contoh redirect
                    } else {
                        alert('Pembayaran gagal: ' + result.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
                } finally {
                    // Aktifkan kembali tombol submit
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Konfirmasi Pembayaran';
                }
            });
        });
    </script>

</body>
</html>