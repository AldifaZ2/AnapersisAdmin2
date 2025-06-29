<?php
namespace NeyShiKu\CleanlyGo\Models;

class Auth {
    private $db;

    public function __construct() {
        require __DIR__ . '/../../config/connect.php';
        $this->db = $pdo;
    }

    public function login(string $email, string $password) {
        $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['passwordHash'])) {
            return $user;
        }

        return null;
    }

    public function signup(string $name, string $email, string $password, string $confirmPassword): array {
        $sql = "SELECT email FROM users WHERE email = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if (!$user) {
            if ($password === $confirmPassword) {
                $passHash = password_hash($password, PASSWORD_ARGON2ID);
 
                $sql = "INSERT INTO users (email, passwordHash) VALUES (?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$email, $passHash]);

                $idUser = $this->db->lastInsertId();

                $sql = "INSERT INTO pelanggan (idUser, nama) VALUES (?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$idUser, $name]);

                return ['success' => true];
            } else {
                return ['success' => false, 'message' => 'kata sandi tidak sama'];
            }
        } else {
            return ['success' => false, 'message' => 'email sudah terdaftar'];
        }
    }
}