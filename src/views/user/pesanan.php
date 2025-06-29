<?php
// Memastikan hanya pengguna yang sudah login yang bisa mengakses
include "_auth.php"; //

// --- FUNGSI UNTUK DATABASE ---
// Anda HARUS mengganti bagian ini dengan koneksi database dan query Anda yang sebenarnya.
// Kode di bawah ini adalah data tiruan (dummy data) untuk tujuan demonstrasi.

$idPelanggan = $_SESSION['id_user'];

/**
 * Fungsi ini mengambil data pesanan dari database.
 * Ganti dengan implementasi query database Anda.
 * @param int $idPelanggan
 * @return array
 */
function getPesananByPelanggan($idPelanggan) {
    // CONTOH KONEKSI & QUERY DATABASE (GANTI DENGAN KODE ANDA)
    /*
    require __DIR__ . '/../../../config/database.php'; // Ganti dengan path koneksi DB Anda
    $pdo = getPdo(); // Ganti dengan fungsi koneksi Anda
    $query = "SELECT * FROM pesanan WHERE idPelanggan = ? ORDER BY tanggalPesanan DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$idPelanggan]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    */

    // Data Tiruan (Hapus atau ganti bagian ini saat terhubung ke database)
    return [
        [
            'idPesanan' => 'ORD-1001', 'idPelanggan' => $idPelanggan,
            'namaPesanan' => 'Layanan Kebersihan Rumah', 'detailPesanan' => 'Pembersihan menyeluruh 3 kamar, 2 kamar mandi.',
            'catatanPesanan' => 'Fokus pada area dapur.', 'statusPesanan' => 'Selesai',
            'tanggalPesanan' => '2025-06-01', 'tanggalLayanan' => '2025-06-05'
        ],
        [
            'idPesanan' => 'ORD-1002', 'idPelanggan' => $idPelanggan,
            'namaPesanan' => 'Layanan Pindahan Apartemen', 'detailPesanan' => 'Pindahan dari apartemen lama ke baru.',
            'catatanPesanan' => 'Ada barang pecah belah, harap hati-hati.', 'statusPesanan' => 'Diproses',
            'tanggalPesanan' => '2025-06-10', 'tanggalLayanan' => '2025-06-15'
        ],
        [
            'idPesanan' => 'ORD-1003', 'idPelanggan' => $idPelanggan,
            'namaPesanan' => 'Paket Lengkap', 'detailPesanan' => 'Pindahan dan pembersihan setelah pindahan.',
            'catatanPesanan' => '', 'statusPesanan' => 'Menunggu Jadwal',
            'tanggalPesanan' => '2025-06-12', 'tanggalLayanan' => '2025-06-20'
        ],
        [
            'idPesanan' => 'ORD-1004', 'idPelanggan' => $idPelanggan,
            'namaPesanan' => 'Layanan Kebersihan Kantor', 'detailPesanan' => 'Pembersihan ruang kerja dan lobi.',
            'catatanPesanan' => 'Jadwal dibatalkan oleh pelanggan.', 'statusPesanan' => 'Dibatalkan',
            'tanggalPesanan' => '2025-05-20', 'tanggalLayanan' => '2025-05-25'
        ]
    ];
}

$daftar_pesanan = getPesananByPelanggan($idPelanggan);

// Fungsi bantuan untuk menentukan warna status
function getStatusBadgeClass($status) {
    switch (strtolower($status)) {
        case 'selesai':
            return 'bg-green-100 text-green-800';
        case 'diproses':
            return 'bg-yellow-100 text-yellow-800';
        case 'dibatalkan':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-blue-100 text-blue-800'; // Untuk status 'Menunggu Jadwal' atau lainnya
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - CleanlyGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto px-4 py-12">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Riwayat Pesanan Saya</h1>
            <p class="text-gray-600 mt-2">Lihat status dan detail semua pesanan Anda di sini.</p>
        </div>

        <?php if (empty($daftar_pesanan)): ?>
            <div class="text-center bg-white p-10 rounded-lg shadow-md">
                <i class="fas fa-box-open fa-4x text-gray-300 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-700">Anda Belum Memiliki Pesanan</h2>
                <p class="text-gray-500 mt-2">Sepertinya Anda belum pernah memesan layanan kami.</p>
                <a href="/layanan" class="mt-6 inline-block bg-indigo-600 text-white font-semibold py-2 px-5 rounded-lg hover:bg-indigo-700 transition duration-300">
                    Lihat Layanan Kami
                </a>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php foreach ($daftar_pesanan as $pesanan): ?>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-500">
                    <div class="flex flex-col md:flex-row justify-between md:items-center mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800"><?= htmlspecialchars($pesanan['namaPesanan']) ?></h2>
                            <p class="text-sm text-gray-500">ID Pesanan: <?= htmlspecialchars($pesanan['idPesanan']) ?></p>
                        </div>
                        <span class="text-sm font-medium px-3 py-1 rounded-full mt-2 md:mt-0 <?= getStatusBadgeClass($pesanan['statusPesanan']) ?>">
                            <?= htmlspecialchars($pesanan['statusPesanan']) ?>
                        </span>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="text-gray-700">
                                <strong class="font-medium">Tanggal Pesan:</strong>
                                <span><?= date('d F Y', strtotime($pesanan['tanggalPesanan'])) ?></span>
                            </div>
                            <div class="text-gray-700">
                                <strong class="font-medium">Jadwal Layanan:</strong>
                                <span><?= date('d F Y', strtotime($pesanan['tanggalLayanan'])) ?></span>
                            </div>
                        </div>
                        <?php if (!empty($pesanan['detailPesanan'])): ?>
                        <div class="mt-4 text-gray-700 text-sm">
                            <strong class="font-medium">Detail:</strong>
                            <p class="text-gray-600"><?= htmlspecialchars($pesanan['detailPesanan']) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="text-center mt-12">
            <a href="/" class="text-indigo-600 hover:text-indigo-800 font-medium transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Homepage
            </a>
        </div>
    </div>

</body>
</html>