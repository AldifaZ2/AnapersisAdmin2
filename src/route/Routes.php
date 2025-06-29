<?php
namespace NeyShiKu\CleanlyGo\Route;

class Routes {
    public static function getRoutes() {
        return [
            '' => ['HomeController', 'index'],
            'auth' => ['AuthController', 'auth'],
            'auth/login' => ['AuthController', 'login'],
            'auth/signup' => ['AuthController', 'signup'],
            'auth/logout' => ['AuthController', 'logout'],
            'admin/dashboard' => ['AdminController', 'dashboard'],
            'admin/kelola_pekerja' => ['AdminController', 'kelolaPekerja'],
            'admin/kelola_pelanggan' => ['AdminController', 'kelolapelanggan'],
            'pelanggan/settings' => ['PelangganController', 'settings'],
            'pelanggan/save' => ['PelangganController', 'saveUpdate'],
            'pelanggan/layanan' => ['PelangganController', 'layanan'],
            'pelanggan/pesanan' => ['PelangganController', 'pesanan'],
            'pelanggan/prosespesanan' => ['PelangganController', 'prosespesanan'],
            'pelanggan/pembayaran' => ['PelangganController', 'pembayaran'],
        ];
    }
}