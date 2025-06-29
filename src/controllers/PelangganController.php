<?php
namespace NeyShiKu\CleanlyGo\Controllers;

use NeyShiKu\CleanlyGo\Core\Controller;
use NeyShiKu\CleanlyGo\Models\Pelanggan;

class PelangganController extends Controller {
    public function settings() {
        if (session_status() === PHP_SESSION_NONE) {
            require __DIR__ . '/../../config/session.php';
        }

        try {
            $pelanggan = new Pelanggan($_SESSION['id_user']);
            $pelanggan->data();
            $dataPelanggan = $pelanggan->settings();
        } catch (\Throwable $th) {
            $this->view('user/settings');
        }

        $this->view('user/settings', $dataPelanggan);
    }

    public function saveUpdate() {
        if (session_status() === PHP_SESSION_NONE) {
            require __DIR__ . '/../../config/session.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idPelanggan = $_SESSION['id_user'];

            $username = $_POST['username'];
            $alamat = $_POST['alamat'];
            $noHp = $_POST['noHp'];

            $pelanggan = new Pelanggan($idPelanggan);
            $pelanggan->updateProfile($idPelanggan, $username, $alamat, $noHp);
        } else {
            $ErrorController = new ErrorController();
            $ErrorController->notFound();
            exit;
        }
    }

    public function layanan() {
        $layanan = $_GET['pesan'];

        switch ($layanan) {
            case 'kebersihan':
                $this->view('user/layanan/kebersihan');
                exit;
                break;
            
            default:
                break;
        }

        $this->view('user/layanan');
    }

    public function prosespesanan() {
        if (session_status() === PHP_SESSION_NONE) {
            require __DIR__ . '/../../config/session.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $harga = $_POST['totalbiaya'];

            $_SESSION['bayar'] = $harga;
            header('Location: /pelanggan/pembayaran');
            exit;
        } else {
            $this->view('user/layanan');
        }
    }

    public function pembayaran() {
        if (session_status() === PHP_SESSION_NONE) {
            require __DIR__ . '/../../config/session.php';
        }

        $harga = $_SESSION['bayar'] ?? 0;
        $this->view('user/pembayaran', ["harga" => $harga]);
    }
    
    public function pesanan() {
        $this->view('user/pesanan');
    }
}