<?php

class AuthController extends Controller {

    public function login(): void {
        if (Middleware::isLoggedIn()) $this->redirect('');
        $this->view('auth/login', ['title' => 'Login']);
    }

    public function authenticate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('auth/login');

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->model('User')->login($username, $password);

        if ($user) {
            Security::loginUser($user);
            $this->model('User')->touchLogin((int) $user['id']);
            $this->logActivity('auth.login', 'user', (int) $user['id'], 'Login: ' . $user['username']);
            $this->flash('success', 'Selamat datang, ' . $user['full_name'] . '!');
            $this->redirect('');
        }

        $this->model('ActivityLog')->record(
            null,
            'auth.failed',
            'user',
            null,
            'Login gagal untuk username: ' . mb_substr($username, 0, 100)
        );
        $this->flash('danger', 'Username atau password salah.');
        $this->redirect('auth/login');
    }

    public function logout(): void
    {
        if (Middleware::isLoggedIn()) {
            $this->logActivity('auth.logout', 'user', (int) $_SESSION['user']['id'], 'Logout');
        }
        Security::logout();
        header('Location: ' . BASEURL . '/auth/login');
        exit;
    }
}