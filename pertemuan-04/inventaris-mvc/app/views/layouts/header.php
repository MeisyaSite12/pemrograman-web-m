<?php $flash = take_flash(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? e($title) . ' - ' : '' ?><?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="navbar-nav me-auto">
        <a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a>
        <?php if (can_manage()): ?>
            <a class="nav-link" href="<?= base_url('categories') ?>">Kategori</a>
        <?php endif; ?>
        <a class="nav-link" href="<?= base_url('items') ?>">Barang</a>
        <a class="nav-link" href="<?= base_url('transactions') ?>">Transaksi</a>
        <a class="nav-link" href="<?= base_url('reports/lowStock') ?>">Laporan</a>
    </div>
    <?php if (!empty($_SESSION['user'])): ?>
    <div class="navbar-nav">
        <span class="navbar-text me-3"><?= e($_SESSION['user']['full_name']) ?></span>
        <a class="btn btn-sm btn-outline-light" href="<?= base_url('auth/logout') ?>">Logout</a>
    </div>
<?php endif; ?></nav>
<main class="container py-4">
<?php if ($flash): ?>
    <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
<?php endif; ?>