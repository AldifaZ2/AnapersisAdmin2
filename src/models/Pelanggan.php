<?php
namespace NeyShiKu\CleanlyGo\Models;

use NeyShiKu\CleanlyGo\Core\Logger;

class Pelanggan extends Users {
    private int $idPelanggan;
    private string $username;
    private string $nama;
    private string $alamat;
    private string $nomorTelepon;
    private $db;

    public function __construct($idUser) {
        parent::__construct($idUser);
        require __DIR__ . '/../../config/connect.php';
        $this->db = $pdo;
    }

    public function data(): void {
        $sql = "SELECT p.* FROM users u, pelanggan p WHERE u.idUser = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$this->idUser]);

        $user = $stmt->fetch();

        if ($user) {
            $this->idPelanggan = $user['idPelanggan'];
            $this->nama = $user['nama'];
            $this->username = $user['username'] ?? '';
            $this->alamat = $user['alamat'] ?? '';
            $this->nomorTelepon = $user['noHp'] ?? '';
        } else {
            echo "ID User not found";
            $log = Logger::getLogger();
            $log->info('PelangganModel: No ID User');
        }
    }

    public function settings(): array {
        return [
            'username' => $this->username,
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'nomorTelepon' => $this->nomorTelepon,
        ];
    }

    public function updateProfile(int $idUser, string $username, string $alamat, string $noHp): bool {
        $sql = "UPDATE pelanggan SET username = ?, alamat = ?, noHp = ? WHERE idPelanggan = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username, $alamat, $noHp, $idUser]);

        if ($stmt->rowCount() > 0) {
            $log = Logger::getLogger();
            $log->info('PelangganModel: Update Success');
            return true; // Update berhasil
        } else {
            $log = Logger::getLogger();
            $log->info('PelangganModel: Update Failed');
            return false; // Tidak ada baris yang diubah
        }
    }

    public function pesanLayanan() {
        // Implementasi pesan layanan pelanggan
    }

    public function lakukanPembayaran() {
        // Implementasi pembayaran pelanggan
    }

    public function lihatJadwal() {
        // Implementasi lihat jadwal pelanggan
    }

    public function lihatRiwayatPesanan() {
        // Implementasi lihat riwayat pesanan pelanggan
    }

    public function beriUlasan() {
        // Implementasi beri ulasan pelanggan
    }
}

