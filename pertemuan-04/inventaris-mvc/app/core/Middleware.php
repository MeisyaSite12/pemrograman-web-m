<?php

class Middleware {
    public static function isLoggedIn(): bool {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return !empty($_SESSION['user']);
    }

    public static function requireLogin(): void {
        if (!self::isLoggedIn()) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Silakan login terlebih dahulu.'];
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    public static function user(): ?array {
        return $_SESSION['user'] ?? null;
    }

    private const MATRIX = [
    'admin' => ['*'],
    'manager' => [
        'dashboard.view',
        'items.view', 'items.create', 'items.update', 'items.delete', 'items.upload',
        'categories.view', 'categories.manage',
        'transactions.view', 'transactions.create',
        'reports.view', 'reports.export',
    ],
    'staff' => [
        'dashboard.view',
        'items.view',
        'categories.view',
        'transactions.view', 'transactions.create',
        'reports.view',
    ],
];

    public static function role(): string
    {
        return (string) (self::user()['role'] ?? '');
    }

    public static function can(string $permission): bool
    {
        return self::roleCan(self::role(), $permission);
    }

    public static function roleCan(?string $role, string $permission): bool
    {
        $role = strtolower((string) $role);
        if (!isset(self::MATRIX[$role])) {
            return false;
        }

        $granted = self::MATRIX[$role];
        return in_array('*', $granted, true) || in_array($permission, $granted, true);
    }

    public static function requirePermission(string $permission): void
    {
        if (!self::can($permission)) {
            Security::abort(
                403,
                'Akses ditolak',
                'Anda tidak memiliki izin untuk membuka halaman atau menjalankan aksi ini.'
            );
        }
    }

    public static function requireRole(string $role): void
    {
        if (self::role() !== strtolower($role)) {
            Security::abort(
                403,
                'Akses ditolak',
                'Halaman ini hanya tersedia untuk peran ' . e($role) . '.'
            );
        }
    }
}