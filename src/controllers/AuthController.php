<?php
namespace NeyShiKu\CleanlyGo\Controllers;

use NeyShiKu\CleanlyGo\Core\Logger;
use NeyShiKu\CleanlyGo\Core\Controller;
use NeyShiKu\CleanlyGo\Models\Auth;

class AuthController extends Controller {
    public function auth() {
        $this->view('auth');

        $log = Logger::getLogger();
        $log->info('AuthController auth view');
    }

    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            require __DIR__ . '/../../config/session.php';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $auth = new Auth();
            $result = $auth->login($email, $password);

            if ($result) {
                session_regenerate_id(true);
                $_SESSION['id_user'] = $result['idUser'];
                $_SESSION['role'] = $result['role'];

                if ($_SESSION['role'] === 'admin') {
                    header('Location: /admin/dashboard');
                    exit;
                } else {
                    header('Location: /');
                    exit;
                }

                $log = Logger::getLogger();
                $log->info('AuthController login ' . $_SESSION['id_user'] . " " . $_SESSION['role']);

                exit;
            } else {
                $this->view('auth', ['error' => 'Username atau Password salah', 'form' => 'login']);
            }
        } else {
            $this->view('auth', ['form' => 'login']);
        }
    }

    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = strtolower($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';

            $auth = new Auth();
            $result = $auth->signup($name, $email, $password, $confirmPassword);

            if ($result['success']) {
                header('Location: /auth');
                exit;
            } else {
                $this->view('auth', ['error' => $result['message'], 'form' => 'signup']);
            }
        } else {
            $this->view('auth', ['form' => 'signup']);
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            require __DIR__ . '/../../config/session.php';
        }
        session_unset();
        session_destroy();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        $log = Logger::getLogger();
        $log->info('AuthController logout');
        
        header('Location: /');
        exit;
    }
}