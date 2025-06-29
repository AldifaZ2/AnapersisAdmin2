<?php include "_auth.php";

// Database connection
include __DIR__ . "/../../../config/connect.php";

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch($action) {
        case 'create':
            try {
                $nama = $_POST['nama'] ?? '';
                $username = $_POST['username'] ?? '';
                $alamat = $_POST['alamat'] ?? '';
                $noHp = $_POST['noHp'] ?? '';
                $password = $_POST['password'] ?? '';

                // Hash password
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // Start transaction
                $pdo->beginTransaction();

                // Insert into users table
                $stmt = $pdo->prepare("INSERT INTO users (email, passwordHash, role) VALUES (?, ?, 'pelanggan')");
                $stmt->execute([$username, $passwordHash]);
                $userId = $pdo->lastInsertId();

                // Insert into pelanggan table
                $stmt = $pdo->prepare("INSERT INTO pelanggan (idUser, nama, alamat, noHp) VALUES (?, ?, ?, ?)");
                $stmt->execute([$userId, $nama, $alamat, $noHp]);

                $pdo->commit();
                $success_message = "Pelanggan berhasil ditambahkan!";
            } catch (Exception $e) {
                $pdo->rollBack();
                $error_message = "Gagal menambahkan pelanggan: " . $e->getMessage();
            }
            break;

        case 'update':
            try {
                $idPelanggan = $_POST['idPelanggan'] ?? '';
                $nama = $_POST['nama'] ?? '';
                $username = $_POST['username'] ?? '';
                $alamat = $_POST['alamat'] ?? '';
                $noHp = $_POST['noHp'] ?? '';
                
                // Start transaction
                $pdo->beginTransaction();
                
                // Update users table
                $stmt = $pdo->prepare("UPDATE users SET email=? WHERE idUser=(SELECT idUser FROM pelanggan WHERE idPelanggan=?)");
                $stmt->execute([$username, $idPelanggan]);
                
                // Update pelanggan table
                $stmt = $pdo->prepare("UPDATE pelanggan SET nama=?, alamat=?, noHp=? WHERE idPelanggan=?");
                $stmt->execute([$nama, $alamat, $noHp, $idPelanggan]);
                
                $pdo->commit();
                $success_message = "Data pelanggan berhasil diperbarui!";
                
            } catch (Exception $e) {
                $pdo->rollBack();
                $error_message = "Gagal memperbarui pelanggan: " . $e->getMessage();
            }
            break;

        case 'delete':
            try {
                $idUser = $_POST['idUser'] ?? '';
                
                // Start transaction
                $pdo->beginTransaction();
                
                // Delete from pelanggan table first (foreign key constraint)
                $stmt = $pdo->prepare("DELETE FROM pelanggan WHERE idUser=?");
                $stmt->execute([$idUser]);
                
                // Delete from users table
                $stmt = $pdo->prepare("DELETE FROM users WHERE idUser=?");
                $stmt->execute([$idUser]);
                
                $pdo->commit();
                $success_message = "Pelanggan berhasil dihapus!";
                
            } catch (Exception $e) {
                $pdo->rollBack();
                $error_message = "Gagal menghapus pelanggan: " . $e->getMessage();
            }
            break;
    }
}

// Fetch all pelanggan
try {
    $stmt = $pdo->query("
        SELECT p.idPelanggan, p.idUser, p.nama, u.email AS username, p.alamat, p.noHp
        FROM pelanggan p
        JOIN users u ON p.idUser = u.idUser
        ORDER BY p.idPelanggan DESC
    ");
    $pelanggan = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error_message = "Gagal memuat data pelanggan: " . $e->getMessage();
    $pelanggan = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pelanggan - CleanlyGo</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"
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
                <a href="kelola_pekerja.php" class="flex items-center p-3 rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span>Kelola Pekerja</span>
                </a>
                <a href="/admin/kelola_pelanggan" class="flex items-center p-3 rounded-lg bg-indigo-900 text-white font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span>Kelola Pelanggan</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center p-6 bg-white border-b">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Kelola Pelanggan</h1>
                    <p class="text-sm text-gray-500">Manajemen data pelanggan CleanlyGo</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="p-2 rounded-full hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                    <?php 
                    // Get admin name from session or database - adjust according to your auth system
                    $adminName = $_SESSION['nama'] ?? 'Admin';
                    $inisialAdmin = strtoupper(substr($adminName, 0, 1));
                    ?>
                    <img class="h-10 w-10 rounded-full object-cover" src="https://placehold.co/100x100/E2E8F0/4A5568?text=<?= $inisialAdmin?>" alt="Admin Avatar">
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <div class="container mx-auto">
                    
                    <!-- Success Message -->
                    <?php if (isset($success_message)): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                        <span class="block sm:inline"><?= htmlspecialchars($success_message) ?></span>
                    </div>
                    <?php endif; ?>

                    <!-- Error Message -->
                    <?php if (isset($error_message)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                        <span class="block sm:inline"><?= htmlspecialchars($error_message) ?></span>
                    </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex space-x-2">
                            <button onclick="openModal('addModal')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah Pelanggan
                            </button>
                        </div>
                        <div class="flex space-x-2">
                            <input type="text" id="searchInput" placeholder="Cari pelanggan..." class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
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
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No HP</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                                    <?php foreach ($pelanggan as $row): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <?php 
                                                $nama_pelanggan = trim($row['nama']);
                                                $parts = preg_split('/\s+/', $nama_pelanggan);
                                                $inisial = "";
                                                foreach ($parts as $part) {
                                                    if (!empty($part)) {
                                                        $inisial .= strtoupper($part[0]);
                                                    }
                                                }
                                                $inisial = substr($inisial, 0, 2);
                                                ?>
                                                <img class="h-10 w-10 rounded-full" src="https://placehold.co/100x100/DBEAFE/3B82F6?text=<?= urlencode($inisial) ?>" alt="<?= htmlspecialchars($row['nama']) ?>">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($row['nama']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($row['username']) ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="max-w-xs truncate" title="<?= htmlspecialchars($row['alamat']) ?>">
                                                <?= htmlspecialchars($row['alamat']) ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($row['noHp']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button onclick="editPelanggan(<?= htmlspecialchars(json_encode($row)) ?>)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                            <button onclick="deletePelanggan(<?= $row['idUser'] ?>, '<?= htmlspecialchars($row['nama']) ?>')" class="text-red-600 hover:text-red-900">Hapus</button>
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
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Pelanggan Baru</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="create">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="username" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <textarea name="alamat" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                        <input type="tel" name="noHp" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
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
                <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Pelanggan</h3>
                <form method="POST" id="editForm">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="idPelanggan" id="editIdPelanggan">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" id="editNama" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="username" id="editUsername" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <textarea name="alamat" id="editAlamat" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                        <input type="tel" name="noHp" id="editNoHp" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
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
                <h3 class="text-lg font-medium text-gray-900 mt-2">Hapus Pelanggan</h3>
                <p class="text-sm text-gray-500 mt-2">Apakah Anda yakin ingin menghapus pelanggan ini? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex justify-center space-x-2 mt-4">
                    <button type="button" onclick="closeModal('deleteModal')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Batal</button>
                    <form method="POST" style="display: inline;" id="deleteForm">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="idUser" id="deleteIdUser">
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

    // Fungsi untuk edit pelanggan
    function editPelanggan(data) {
        document.getElementById('editIdPelanggan').value = data.idPelanggan;
        document.getElementById('editNama').value = data.nama;
        document.getElementById('editUsername').value = data.username;
        document.getElementById('editAlamat').value = data.alamat;
        document.getElementById('editNoHp').value = data.noHp;
        
        openModal('editModal');
    }

    // Fungsi untuk delete pelanggan
    function deletePelanggan(idUser, nama) {
        const modalContent = document.querySelector('#deleteModal .mt-3.text-center');
        const namaPelanggan = modalContent.querySelector('p');
        namaPelanggan.innerHTML = `Apakah Anda yakin ingin menghapus pelanggan <strong>"${nama}"</strong>? Tindakan ini tidak dapat dibatalkan.`;
        
        document.getElementById('deleteIdUser').value = idUser;
        openModal('deleteModal');
    }

    // Fungsi pencarian real-time
    function searchTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const tbody = document.getElementById('tableBody');
        const rows = tbody.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let found = false;
            
            // Cari di kolom nama, email, alamat, dan no HP
            for (let j = 0; j < 4; j++) {
                if (cells[j]) {
                    const txtValue = cells[j].textContent || cells[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }
            
            rows[i].style.display = found ? '' : 'none';
        }

        // Tampilkan pesan jika tidak ada hasil
        showNoResultsMessage(filter, rows);
    }

    // Tampilkan pesan ketika tidak ada hasil pencarian
    function showNoResultsMessage(filter, rows) {
        const tbody = document.getElementById('tableBody');
        let visibleRows = 0;
        
        for (let i = 0; i < rows.length; i++) {
            if (rows[i].style.display !== 'none') {
                visibleRows++;
            }
        }

        // Hapus pesan sebelumnya jika ada
        const existingMessage = document.getElementById('noResultsMessage');
        if (existingMessage) {
            existingMessage.remove();
        }

        if (visibleRows === 0 && filter.length > 0) {
            const noResultsRow = document.createElement('tr');
            noResultsRow.id = 'noResultsMessage';
            noResultsRow.innerHTML = `
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <svg class="h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <p class="text-lg font-medium">Tidak ada pelanggan ditemukan</p>
                        <p class="text-sm">Coba ubah kata kunci pencarian Anda</p>
                    </div>
                </td>
            `;
            tbody.appendChild(noResultsRow);
        }
    }

    // Validasi form tambah pelanggan
    function validateAddForm() {
        const form = document.querySelector('#addModal form');
        const nama = form.querySelector('[name="nama"]').value.trim();
        const email = form.querySelector('[name="username"]').value.trim();
        const password = form.querySelector('[name="password"]').value;
        const alamat = form.querySelector('[name="alamat"]').value.trim();
        const noHp = form.querySelector('[name="noHp"]').value.trim();

        // Validasi nama
        if (nama.length < 2) {
            showToast('Nama harus minimal 2 karakter', 'error');
            return false;
        }

        // Validasi email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showToast('Format email tidak valid', 'error');
            return false;
        }

        // Validasi password
        if (password.length < 6) {
            showToast('Password harus minimal 6 karakter', 'error');
            return false;
        }

        // Validasi no HP
        const phoneRegex = /^[0-9+\-\s()]+$/;
        if (!phoneRegex.test(noHp) || noHp.length < 10) {
            showToast('No HP tidak valid (minimal 10 digit)', 'error');
            return false;
        }

        return true;
    }

    // Validasi form edit pelanggan
    function validateEditForm() {
        const form = document.querySelector('#editModal form');
        const nama = form.querySelector('[name="nama"]').value.trim();
        const email = form.querySelector('[name="username"]').value.trim();
        const alamat = form.querySelector('[name="alamat"]').value.trim();
        const noHp = form.querySelector('[name="noHp"]').value.trim();

        // Validasi nama
        if (nama.length < 2) {
            showToast('Nama harus minimal 2 karakter', 'error');
            return false;
        }

        // Validasi email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showToast('Format email tidak valid', 'error');
            return false;
        }

        // Validasi no HP
        const phoneRegex = /^[0-9+\-\s()]+$/;
        if (!phoneRegex.test(noHp) || noHp.length < 10) {
            showToast('No HP tidak valid (minimal 10 digit)', 'error');
            return false;
        }

        return true;
    }

    // Fungsi untuk menampilkan toast notification
    function showToast(message, type = 'info') {
        const toastContainer = document.getElementById('toastContainer') || createToastContainer();
        
        const toast = document.createElement('div');
        toast.className = `toast-message transform transition-all duration-300 mb-2 p-4 rounded-lg shadow-lg ${getToastColor(type)}`;
        toast.innerHTML = `
            <div class="flex items-center justify-between">
                <span class="font-medium">${message}</span>
                <button onclick="removeToast(this)" class="ml-3 text-lg font-bold opacity-70 hover:opacity-100">&times;</button>
            </div>
        `;
        
        toastContainer.appendChild(toast);
        
        // Auto remove setelah 5 detik
        setTimeout(() => {
            if (toast.parentNode) {
                removeToast(toast.querySelector('button'));
            }
        }, 5000);
    }

    function createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'fixed top-4 right-4 z-50 max-w-sm';
        document.body.appendChild(container);
        return container;
    }

    function getToastColor(type) {
        switch(type) {
            case 'success': return 'bg-green-500 text-white';
            case 'error': return 'bg-red-500 text-white';
            case 'warning': return 'bg-yellow-500 text-white';
            default: return 'bg-blue-500 text-white';
        }
    }

    function removeToast(button) {
        const toast = button.closest('.toast-message');
        toast.style.transform = 'translateX(100%)';
        toast.style.opacity = '0';
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }

    // Fungsi untuk export data ke CSV
    function exportToCSV() {
        const table = document.querySelector('table');
        const rows = table.querySelectorAll('tr');
        let csvContent = '';
        
        // Header
        const headers = ['Nama', 'Email', 'Alamat', 'No HP'];
        csvContent += headers.join(',') + '\n';
        
        // Data rows (skip header row dan yang hidden)
        for (let i = 1; i < rows.length; i++) {
            if (rows[i].style.display !== 'none' && !rows[i].id) {
                const cells = rows[i].querySelectorAll('td');
                const rowData = [];
                
                // Ambil data dari kolom yang diperlukan (skip kolom aksi)
                for (let j = 0; j < 4; j++) {
                    let cellData = cells[j].textContent.trim();
                    // Escape quotes dan commas
                    if (cellData.includes(',') || cellData.includes('"')) {
                        cellData = '"' + cellData.replace(/"/g, '""') + '"';
                    }
                    rowData.push(cellData);
                }
                
                csvContent += rowData.join(',') + '\n';
            }
        }
        
        // Download file
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        if (link.download !== undefined) {
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `pelanggan_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

    // Fungsi untuk refresh data
    function refreshData() {
        location.reload();
    }

    // Fungsi untuk konfirmasi sebelum meninggalkan halaman jika ada perubahan
    let hasUnsavedChanges = false;

    function markAsChanged() {
        hasUnsavedChanges = true;
    }

    window.addEventListener('beforeunload', function(e) {
        if (hasUnsavedChanges) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Search input event listener
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', searchTable);
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchTable();
                }
            });
        }

        // Form validation event listeners
        const addForm = document.querySelector('#addModal form');
        if (addForm) {
            addForm.addEventListener('submit', function(e) {
                if (!validateAddForm()) {
                    e.preventDefault();
                }
            });
        }

        const editForm = document.querySelector('#editModal form');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                if (!validateEditForm()) {
                    e.preventDefault();
                }
            });
        }

        // Auto-close alerts after 5 seconds
        const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 300);
            }, 5000);
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + K untuk fokus ke search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
            }
            
            // Escape untuk menutup modal
            if (e.key === 'Escape') {
                const modals = ['addModal', 'editModal', 'deleteModal'];
                modals.forEach(modalId => {
                    const modal = document.getElementById(modalId);
                    if (modal && !modal.classList.contains('hidden')) {
                        closeModal(modalId);
                    }
                });
            }
        });

        // Tooltip untuk aksi buttons
        const actionButtons = document.querySelectorAll('button[onclick*="edit"], button[onclick*="delete"]');
        actionButtons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                const action = this.textContent.trim();
                this.title = `${action} pelanggan`;
            });
        });
    });

    // Fungsi untuk menampilkan detail pelanggan dalam modal
    function viewPelanggan(data) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50';
        modal.innerHTML = `
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Detail Pelanggan</h3>
                        <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                            <p class="text-sm text-gray-900">${data.nama}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email</label>
                            <p class="text-sm text-gray-900">${data.username}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Alamat</label>
                            <p class="text-sm text-gray-900">${data.alamat}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">No HP</label>
                            <p class="text-sm text-gray-900">${data.noHp}</p>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2 mt-6">
                        <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Tutup</button>
                        <button onclick="editPelanggan(${JSON.stringify(data).replace(/"/g, '&quot;')}); this.closest('.fixed').remove();" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Edit</button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }
        
