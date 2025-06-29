<?php

class Layanan {
    private int $idLayanan;
    private string $namaLayanan;
    private string $deskripsiLayanan;
    private int $hargaLayanan;
    private $db;
    
    public function __construct() {
        require __DIR__ . '/../../config/connect.php';
        $this->db = $pdo;
    }

    public function getDetails() {
        $sql = "SELECT * FROM layanan";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }
}