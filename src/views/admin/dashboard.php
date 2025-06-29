<?php include "_auth.php";?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - CleanlyGo</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar for a cleaner look */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db; /* gray-300 */
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af; /* gray-400 */
        }
    </style>
</head>
<body class="antialiased bg-gray-100 text-gray-800">

    <div class="flex h-screen">
        <aside class="w-64 flex-shrink-0 bg-indigo-800 text-white flex flex-col">
            <div class="h-20 flex items-center justify-center px-4 border-b border-indigo-900">
                <h1 class="text-2xl font-bold">CleanlyGo</h1>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-2">
                <a href="#" class="flex items-center p-3 rounded-lg bg-indigo-900 text-white font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    <span>Dasbor</span>
                </a>
                <a href="/admin/kelola_pekerja" class="flex items-center p-3 rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span>Kelola Pekerja</span>
                </a>
                <a href="kelola_pelanggan.php" class="flex items-center p-3 rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span>Kelola Pelanggan</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center p-6 bg-white border-b">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                    <p class="text-sm text-gray-500">Selamat datang kembali, <?= $nama?></p>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="p-2 rounded-full hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                    <?php $inisialAdmin = strtoupper(substr($nama, 0, 1));?>
                    <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/E2E8F0/4A5568?text=<?= $inisialAdmin?>" alt="Admin Avatar">
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <div class="container mx-auto">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Pekerja</p>
                                <p class="text-3xl font-bold text-gray-900"><?= $total_pekerja ?? 0 ?></p>
                            </div>
                            <div class="bg-indigo-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Pelanggan</p>
                                <p class="text-3xl font-bold text-gray-900"><?= $total_pelanggan ?? 0 ?></p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2" /></svg>
                            </div>
                        </div>
                         <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Pekerja Aktif</p>
                                <p class="text-3xl font-bold text-gray-900"><?= $total_pekerja_aktif ?? 0 ?></p>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Aduan Baru</p>
                                <p class="text-3xl font-bold text-gray-900">3</p>
                            </div>
                             <div class="bg-red-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

                        <div class="lg:col-span-3 bg-white p-6 rounded-lg shadow-md">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Pekerja Terbaru</h2>
                            <ul class="space-y-4">
                                <?php
                                if (!empty($daftar)) {
                                    foreach ($daftar as $row) {
                                        if (!empty($row['nama_pekerja'])) {
                                            // Ambil inisial dari nama_pekerja
                                            $nama = trim($row['nama_pekerja']);
                                            $parts = preg_split('/\s+/', $nama);
                                            $inisial = "";

                                            foreach ($parts as $part) {
                                                if (!empty($part)) {
                                                    $inisial .= strtoupper($part[0]);
                                                }
                                            }

                                            // Batasi maksimal 2 huruf
                                            $inisial = substr($inisial, 0, 2);
                                        
                                            echo '<li class="flex items-center space-x-4">';
                                            echo '<img class="h-10 w-10 rounded-full" src="https://placehold.co/100x100/C4B5FD/4338CA?text=' . urlencode($inisial) . '" alt="' . htmlspecialchars($row['nama_pekerja']) . '">';
                                            echo '<div class="flex-1">';
                                            echo '<p class="font-medium text-gray-900">' . htmlspecialchars($row['nama_pekerja']) . '</p>';
                                            echo '<p class="text-sm text-gray-500">' . htmlspecialchars($row['rolePekerja']) . '</p>';
                                            echo '</div>';
                                            echo '<span class="text-sm text-gray-400">' . htmlspecialchars($row['statusPekerja']) . '</span>';
                                            echo '</li>';
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </div>

                        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Status Pekerja</h2>
                            <div class="relative h-64">
                                <canvas id="workerStatusChart"></canvas>
                            </div>
                        </div>

                        <div class="lg:col-span-3 bg-white p-6 rounded-lg shadow-md">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Pelanggan Terbaru</h2>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="text-sm font-medium text-gray-500 border-b">
                                            <th class="py-2">Nama</th>
                                            <th class="py-2">Email</th>
                                            <th class="py-2">Tanggal Daftar</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y">
                                        <?php
                                        if (!empty($daftar)) {
                                            foreach ($daftar as $row) {
                                                if (!empty($row['nama_pelanggan'])) {
                                                    echo '<tr class="text-sm text-gray-700">';
                                                    echo '<td class="py-3">' . htmlspecialchars($row['nama_pelanggan']) . '</td>';
                                                    echo '<td class="py-3">' . htmlspecialchars($row['email']) . '</td>';
                                                    echo '<td class="py-3">~~~</td>';
                                                    echo '</tr>';
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md flex flex-col">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Aduan (Quick Preview)</h2>
                            <div class="flex-1 overflow-y-auto custom-scrollbar pr-2 space-y-4">
                                 <div class="p-4 rounded-lg bg-gray-50 border border-gray-200">
                                    <div class="flex justify-between items-start mb-1">
                                        <p class="font-medium text-gray-800">Koneksi Internet Lambat</p>
                                        <span class="text-xs font-semibold px-2 py-1 bg-red-100 text-red-800 rounded-full">Baru</span>
                                    </div>
                                    <p class="text-sm text-gray-500">Dari: Rina Amelia</p>
                                    <p class="text-xs text-gray-400 mt-2">2 jam yang lalu</p>
                                </div>
                                <div class="p-4 rounded-lg bg-gray-50 border border-gray-200">
                                    <div class="flex justify-between items-start mb-1">
                                        <p class="font-medium text-gray-800">Tagihan tidak sesuai</p>
                                        <span class="text-xs font-semibold px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">Diproses</span>
                                    </div>
                                    <p class="text-sm text-gray-500">Dari: Hendra Setiawan</p>
                                    <p class="text-xs text-gray-400 mt-2">Kemarin</p>
                                </div>
                                <div class="p-4 rounded-lg bg-gray-50 border border-gray-200">
                                    <div class="flex justify-between items-start mb-1">
                                        <p class="font-medium text-gray-800">Perangkat modem rusak</p>
                                         <span class="text-xs font-semibold px-2 py-1 bg-red-100 text-red-800 rounded-full">Baru</span>
                                    </div>
                                    <p class="text-sm text-gray-500">Dari: Bambang P.</p>
                                     <p class="text-xs text-gray-400 mt-2">2 hari yang lalu</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart.js initialization for Worker Status
            const ctx = document.getElementById('workerStatusChart').getContext('2d');
            
            const workerStatusChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Aktif', 'Terjadwal', 'Tidak Aktif'],
                    datasets: [{
                        label: 'Status Pekerja',
                        data: [<?= $total_pekerja_aktif?>, <?= $total_pekerja_terjadwalkan?>, <?= $total_pekerja_tidak_aktif?>],
                        backgroundColor: [
                            '#6366f1', // Indigo-500
                            '#fbbf24', // Amber-400
                            '#f87171'  // Red-400
                        ],
                        borderColor: [
                           '#ffffff',
                           '#ffffff',
                           '#ffffff'
                        ],
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed + ' orang';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

</body>
</html>