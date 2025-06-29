<?php include "_auth.php";?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Layanan - CleanlyGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto px-4 py-12 md:py-20">

        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-indigo-600">Pilih Layanan Anda</h1>
            <p class="text-lg text-gray-600 mt-4 max-w-2xl mx-auto">Kami siap membantu kebutuhan kebersihan dan pindahan Anda. Pilih salah satu layanan di bawah ini untuk memulai.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <div class="service-card bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
                <div class="p-8 text-center bg-indigo-50">
                    <i class="fas fa-broom fa-4x text-indigo-500"></i>
                </div>
                <div class="p-8 flex flex-col flex-grow">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Layanan Kebersihan</h3>
                    <p class="text-gray-600 mb-6 flex-grow">Rumah atau kantor Anda akan berkilau dengan layanan pembersihan profesional kami. Cocok untuk perawatan rutin atau pembersihan mendalam.</p>
                    <a href="/pelanggan/layanan?pesan=kebersihan" class="mt-auto w-full text-center bg-indigo-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-indigo-700 transition duration-300">
                        Pesan Sekarang
                    </a>
                </div>
            </div>

            <div class="service-card bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
                <div class="p-8 text-center bg-purple-50">
                    <i class="fas fa-truck-moving fa-4x text-purple-500"></i>
                </div>
                <div class="p-8 flex flex-col flex-grow">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Layanan Pindahan</h3>
                    <p class="text-gray-600 mb-6 flex-grow">Proses pindahan tanpa stres. Tim kami yang andal akan menangani barang-barang Anda dengan hati-hati, mulai dari pengepakan hingga pengangkutan.</p>
                    <a href="/pesan?layanan=pindahan" class="mt-auto w-full text-center bg-purple-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-purple-700 transition duration-300">
                        Pesan Sekarang
                    </a>
                </div>
            </div>

            <div class="service-card bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:col-span-2 lg:col-span-1">
                 <div class="p-8 text-center bg-green-50 relative">
                    <i class="fas fa-broom fa-3x text-indigo-400"></i>
                    <i class="fas fa-plus fa-2x text-gray-400 mx-4"></i>
                    <i class="fas fa-truck-moving fa-3x text-purple-400"></i>
                </div>
                <div class="p-8 flex flex-col flex-grow">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Paket Lengkap</h3>
                    <p class="text-gray-600 mb-6 flex-grow">Dapatkan penawaran terbaik dengan menggabungkan layanan kebersihan dan pindahan. Selesaikan dua pekerjaan besar sekaligus dengan lebih hemat.</p>
                    <a href="/pesan?layanan=kombo" class="mt-auto w-full text-center bg-green-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-700 transition duration-300">
                        Pesan Sekarang
                    </a>
                </div>
            </div>

        </div>

        <div class="text-center mt-12">
            <a href="/" class="text-indigo-600 hover:text-indigo-800 font-medium transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Homepage
            </a>
        </div>

    </div>

</body>
</html>