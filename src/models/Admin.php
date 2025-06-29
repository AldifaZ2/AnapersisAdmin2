<?php
namespace NeyShiKu\CleanlyGo\Models;

class Admin extends Users {
    private int $idAdmin;
    private string $nama;
    private $db; 

    public function __construct($idUser) {
        parent::__construct($idUser);
        $this->idAdmin = $idUser;

        require __DIR__ . '/../../config/connect.php';
        $this->db = $pdo;
    }

    public function dashboard() {
        $sql = "SELECT u.email, p.nama AS nama_pelanggan, NULL AS nama_pekerja, NULL AS rolePekerja, NULL AS statusPekerja, 
                (SELECT COUNT(*) FROM pelanggan) AS total_pelanggan, 
                (SELECT COUNT(*) FROM pekerja) AS total_pekerja, 
                (SELECT COUNT(*) FROM pekerja WHERE statusPekerja = 'Tersedia') AS total_pekerja_aktif,
                (SELECT COUNT(*) FROM pekerja WHERE statusPekerja = 'TidakTersedia') AS total_pekerja_tidak_aktif,
                (SELECT COUNT(*) FROM pekerja WHERE statusPekerja = 'Terjadwalkan') AS total_pekerja_terjadwalkan
                FROM users u
                INNER JOIN pelanggan p ON u.idUser = p.idUser
                WHERE u.role = 'pelanggan'  
                UNION ALL
                SELECT u.email, NULL AS nama_pelanggan, j.nama AS nama_pekerja, j.rolePekerja, j.statusPekerja, 
                (SELECT COUNT(*) FROM pelanggan) AS total_pelanggan, 
                (SELECT COUNT(*) FROM pekerja) AS total_pekerja, 
                (SELECT COUNT(*) FROM pekerja WHERE statusPekerja = 'Tersedia') AS total_pekerja_aktif,
                (SELECT COUNT(*) FROM pekerja WHERE statusPekerja = 'TidakTersedia') AS total_pekerja_tidak_aktif,
                (SELECT COUNT(*) FROM pekerja WHERE statusPekerja = 'Terjadwalkan') AS total_pekerja_terjadwalkan
                FROM users u
                INNER JOIN pekerja j ON u.idUser = j.idUser
                WHERE u.role = 'pekerja';";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll();

        $data = [
            'daftar' => $result,
            'total_pelanggan' => $result[0]['total_pelanggan'] ?? 0,
            'total_pekerja' => $result[0]['total_pekerja'] ?? 0,
            'total_pekerja_aktif' => $result[0]['total_pekerja_aktif'] ?? 0,
            'total_pekerja_tidak_aktif' => $result[0]['total_pekerja_tidak_aktif'] ?? 0,
            'total_pekerja_terjadwalkan' => $result[0]['total_pekerja_terjadwalkan'] ?? 0,
        ];

        return $data;
    }

    public function kelolaPekerja() {
        // Implementasi kelola pekerja
    }

    public function updateStatusPekerja() {
        // Implementasi update status pekerja
    }

    public function kelolaPelanggan() {
        // Implementasi kelola pelanggan
    }

    public function prosesPengaduan() {
        // Implementasi proses pengaduan
    }

    public function beriGaransi() {
        // Implementasi beri garansi
    }

    public function getNama(): string {
        $sql = "SELECT nama FROM admin WHERE idUser = ?;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$this->idAdmin]);

        $result = $stmt->fetch();
        return $result ? $result['nama'] : 'Admin';
    }
}