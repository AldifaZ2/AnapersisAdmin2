<?php include "_auth.php";

// Database connection
include __DIR__ . "/../../../config/connect.php";

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch($action) {
        case 'create':
            try {
                $nama = $_POST['nama_pekerja'] ?? '';
                $email = $_POST['email'] ?? '';
                $telepon = $_POST['telepon'] ?? '';
                $role = $_POST['role'] ?? '';
                $status = $_POST['status'] ?? 'Tersedia';
                $password = $_POST['password'] ?? '';
                
                // Hash password
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                
                // Start transaction
                $pdo->beginTransaction();
                
                // Insert into users table first
                $stmt = $pdo->prepare("INSERT INTO users (email, passwordHash, role) VALUES (?, ?, 'pekerja')");
                $stmt->execute([$email, $passwordHash]);
                $userId = $pdo->lastInsertId();
                
                // Map role to database enum values
                $roleMapping = [
                    'Cleaning Staff' => 'Pembersih',
                    'Supervisor' => 'Pembersih',
                    'Manager' => 'Pembersih',
                    'Mover' => 'Pindahan'
                ];
                $dbRole = $roleMapping[$role] ?? 'Pembersih';
                
                // Map status to database enum values
                $statusMapping = [
                    'aktif' => 'Tersedia',
                    'tidak_aktif' => 'TidakTersedia',
                    'terjadwal' => 'Terjadwalkan'
                ];
                $dbStatus = $statusMapping[$status] ?? 'Tersedia';
                
                // Insert into pekerja table
                $stmt = $pdo->prepare("INSERT INTO pekerja (idUser, nama, rolePekerja, statusPekerja) VALUES (?, ?, ?, ?)");
                $stmt->execute([$userId, $nama, $dbRole, $dbStatus]);
                
                $pdo->commit();
                $success_message = "Pekerja berhasil ditambahkan!";
                
            } catch (Exception $e) {
                $pdo->rollBack();
                $error_message = "Gagal menambahkan pekerja: " . $e->getMessage();
            }
            break;
            
        case 'update':
            try {
                $id = $_POST['id'] ?? '';
                $nama = $_POST['nama_pekerja'] ?? '';
                $email = $_POST['email'] ?? '';
                $telepon = $_POST['telepon'] ?? '';
                $role = $_POST['role'] ?? '';
                $status = $_POST['status'] ?? '';
                
                // Map role to database enum values
                $roleMapping = [
                    'Cleaning Staff' => 'Pembersih',
                    'Supervisor' => 'Pembersih', 
                    'Manager' => 'Pembersih',
                    'Mover' => 'Pindahan'
                ];
                $dbRole = $roleMapping[$role] ?? 'Pembersih';
                
                // Map status to database enum values
                $statusMapping = [
                    'aktif' => 'Tersedia',
                    'tidak_aktif' => 'TidakTersedia',
                    'terjadwal' => 'Terjadwalkan'
                ];
                $dbStatus = $statusMapping[$status] ?? 'Tersedia';
                
                // Start transaction
                $pdo->beginTransaction();
                
                // Update users table
                $stmt = $pdo->prepare("UPDATE users SET email=? WHERE idUser=(SELECT idUser FROM pekerja WHERE idPekerja=?)");
                $stmt->execute([$email, $id]);
                
                // Update pekerja table
                $stmt = $pdo->prepare("UPDATE pekerja SET nama=?, rolePekerja=?, statusPekerja=? WHERE idPekerja=?");
                $stmt->execute([$nama, $dbRole, $dbStatus, $id]);
                
                $pdo->commit();
                $success_message = "Data pekerja berhasil diperbarui!";
                
            } catch (Exception $e) {
                $pdo->rollBack();
                $error_message = "Gagal memperbarui pekerja: " . $e->getMessage();
            }
            break;
            
        case 'delete':
            try {
                $id = $_POST['id'] ?? '';
                
                // Start transaction
                $pdo->beginTransaction();
                
                // Get user ID first
                $stmt = $pdo->prepare("SELECT idUser FROM pekerja WHERE idPekerja=?");
                $stmt->execute([$id]);
                $userId = $stmt->fetchColumn();
                
                // Delete from pekerja table first (foreign key constraint)
                $stmt = $pdo->prepare("DELETE FROM pekerja WHERE idPekerja=?");
                $stmt->execute([$id]);
                
                // Delete from users table
                $stmt = $pdo->prepare("DELETE FROM users WHERE idUser=?");
                $stmt->execute([$userId]);
                
                $pdo->commit();
                $success_message = "Pekerja berhasil dihapus!";
                
            } catch (Exception $e) {
                $pdo->rollBack();
                $error_message = "Gagal menghapus pekerja: " . $e->getMessage();
            }
            break;
    }
}

// Fetch data pekerja from database
try {
    $stmt = $pdo->query("
        SELECT p.idPekerja as id, p.nama as nama_pekerja, u.email, 
               p.rolePekerja, p.statusPekerja, '' as telepon
        FROM pekerja p 
        JOIN users u ON p.idUser = u.idUser 
        ORDER BY p.idPekerja DESC
    ");
    $data_pekerja = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Map database values to display values
    foreach ($data_pekerja as &$pekerja) {
        // Map role from database to display
        $roleDisplayMapping = [
            'Pembersih' => 'Cleaning Staff',
            'Pindahan' => 'Mover'
        ];
        $pekerja['rolePekerja'] = $roleDisplayMapping[$pekerja['rolePekerja']] ?? $pekerja['rolePekerja'];
        
        // Map status from database to display
        $statusDisplayMapping = [
            'Tersedia' => 'aktif',
            'TidakTersedia' => 'tidak_aktif',
            'Terjadwalkan' => 'terjadwal'
        ];
        $pekerja['statusPekerja'] = $statusDisplayMapping[$pekerja['statusPekerja']] ?? $pekerja['statusPekerja'];
    }
    
} catch (Exception $e) {
    $error_message = "Gagal memuat data pekerja: " . $e->getMessage();
    $data_pekerja = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pekerja - CleanlyGo</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
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
                <a href="/admin/dashboard" class="flex items-center p-3 rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    <span>Dasbor</span>
                </a>
                <a href="/admin/kelola_pekerja" class="flex items-center p-3 rounded-lg bg-indigo-900 text-white font-semibold">
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
                    <h1 class="text-2xl font-bold text-gray-800">Kelola Pekerja</h1>
                    <p class="text-sm text-gray-500">Manajemen data pekerja CleanlyGo</p>
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
                    
                    <!-- Success Message -->
                    <?php if (isset($success_message)): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                        <span class="block sm:inline"><?= $success_message ?></span>
                    </div>
                    <?php endif; ?>

                    <!-- Error Message -->
                    <?php if (isset($error_message)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                        <span class="block sm:inline"><?= $error_message ?></span>
                    </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex space-x-2">
                            <button onclick="openModal('addModal')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah Pekerja
                            </button>
                        </div>
                        <div class="flex space-x-2">
                            <input type="text" id="searchInput" placeholder="Cari pekerja..." class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                                    <?php foreach ($data_pekerja as $pekerja): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <?php 
                                                $nama_pekerja = trim($pekerja['nama_pekerja']);
                                                $parts = preg_split('/\s+/', $nama_pekerja);
                                                $inisial = "";
                                                foreach ($parts as $part) {
                                                    if (!empty($part)) {
                                                        $inisial .= strtoupper($part[0]);
                                                    }
                                                }
                                                $inisial = substr($inisial, 0, 2);
                                                ?>
                                                <img class="h-10 w-10 rounded-full" src="https://placehold.co/100x100/C4B5FD/4338CA?text=<?= urlencode($inisial) ?>" alt="<?= htmlspecialchars($pekerja['nama_pekerja']) ?>">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($pekerja['nama_pekerja']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($pekerja['email']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($pekerja['rolePekerja']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php if ($pekerja['statusPekerja'] == 'aktif'): ?>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                            <?php elseif ($pekerja['statusPekerja'] == 'terjadwal'): ?>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Terjadwal</span>
                                            <?php else: ?>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button onclick="editPekerja(<?= htmlspecialchars(json_encode($pekerja)) ?>)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                            <button onclick="deletePekerja(<?= $pekerja['id'] ?>, '<?= htmlspecialchars($pekerja['nama_pekerja']) ?>')" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Pekerja Baru</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="create">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_pekerja" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                        <input type="tel" name="telepon" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <select name="role" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Role</option>
                            <option value="Cleaning Staff">Cleaning Staff</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Manager">Manager</option>
                            <option value="Mover">Mover</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="aktif">Aktif</option>
                            <option value="terjadwal">Terjadwal</option>
                            <option value="tidak_aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Pekerja</h3>
                <form method="POST" id="editForm">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_pekerja" id="editNama" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="editEmail" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                        <input type="tel" name="telepon" id="editTelepon" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <select name="role" id="editRole" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Role</option>
                            <option value="Cleaning Staff">Cleaning Staff</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Manager">Manager</option>
                            <option value="Mover">Mover</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="editStatus" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="aktif">Aktif</option>
                            <option value="terjadwal">Terjadwal</option>
                            <option value="tidak_aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <svg class="mx-auto h-12 w-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v9l0 9c0 1.657 1.343 3 3 3h15c1.657 0 3-1.343 3-3v-9V9m-21 3h21M19 14v6m4-6v6m4-6v6" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mt-2">
                <script>
    // Fungsi untuk membuka modal
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Fungsi untuk menutup modal
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.style.overflow = 'auto';
        
        if (modalId === 'addModal') {
            document.querySelector('#addModal form').reset();
        }
    }

    // Fungsi untuk edit pekerja
    function editPekerja(data) {
        document.getElementById('editId').value = data.id;
        document.getElementById('editNama').value = data.nama_pekerja;
        document.getElementById('editEmail').value = data.email;
        document.getElementById('editTelepon').value = data.telepon || '';
        document.getElementById('editRole').value = data.rolePekerja;
        document.getElementById('editStatus').value = data.statusPekerja;
        
        openModal('editModal');
    }

    // Fungsi untuk delete pekerja
    function deletePekerja(id, nama) {
        const modal = document.getElementById('deleteModal');
        const modalContent = modal.querySelector('.mt-3.text-center');
        
        modalContent.innerHTML = `
            <svg class="mx-auto h-12 w-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v9l0 9c0 1.657 1.343 3 3 3h15c1.657 0 3-1.343 3-3v-9V9m-21 3h21M19 14v6m4-6v6m4-6v6" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mt-2">Hapus Pekerja</h3>
            <p class="text-sm text-gray-500 mt-2">Apakah Anda yakin ingin menghapus <strong>${nama}</strong>? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex justify-center space-x-2 mt-4">
                <button type="button" onclick="closeModal('deleteModal')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Batal</button>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="${id}">
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">Hapus</button>
                </form>
            </div>
        `;
        
        openModal('deleteModal');
    }

    // Fungsi untuk search
    function setupSearch() {
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('tableBody');
        const rows = tableBody.getElementsByTagName('tr');
        
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const nama = row.cells[0].textContent.toLowerCase();
                const email = row.cells[1].textContent.toLowerCase();
                const role = row.cells[2].textContent.toLowerCase();
                
                if (nama.includes(filter) || email.includes(filter) || role.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    }

    // Setup modal click outside
    function setupModalClickOutside() {
        const modals = ['addModal', 'editModal', 'deleteModal'];
        
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal(modalId);
                }
            });
        });
    }

    // Setup ESC key
    function setupEscapeKey() {
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modals = ['addModal', 'editModal', 'deleteModal'];
                modals.forEach(modalId => {
                    const modal = document.getElementById(modalId);
                    if (!modal.classList.contains('hidden')) {
                        closeModal(modalId);
                    }
                });
            }
        });
    }

    // Auto-hide messages
    function setupAutoHideMessages() {
        const successMsg = document.querySelector('.bg-green-100');
        const errorMsg = document.querySelector('.bg-red-100');
        
        if (successMsg) {
            setTimeout(() => {
                successMsg.style.opacity = '0';
                setTimeout(() => successMsg.remove(), 300);
            }, 5000);
        }
        
        if (errorMsg) {
            setTimeout(() => {
                errorMsg.style.opacity = '0';
                setTimeout(() => errorMsg.remove(), 300);
            }, 7000);
        }
    }

    // Initialize semua fungsi
    document.addEventListener('DOMContentLoaded', function() {
        setupSearch();
        setupModalClickOutside();
        setupEscapeKey();
        setupAutoHideMessages();
    });
    </script>

</body>
</html>