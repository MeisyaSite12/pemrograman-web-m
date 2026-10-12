<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<h1 class="h3 mb-3">Riwayat Transaksi</h1>
<div class="table-responsive">
<table class="table table-striped bg-white align-middle">
    <thead>
        <tr><th>Waktu</th><th>Barang</th><th>Tipe</th><th>Jumlah</th><th>Petugas</th><th>Catatan</th></tr>
    </thead>
    <tbody>
    <?php foreach ($transactions as $row): ?>
        <tr>
            <td><?= e($row['created_at']) ?></td>
            <td><?= e($row['item_code']) ?> - <?= e($row['item_name']) ?></td>
            <td>
                <span class="badge bg-<?= $row['type'] === 'IN' ? 'success' : 'warning' ?>">
                    <?= $row['type'] === 'IN' ? 'Masuk' : 'Keluar' ?>
                </span>
            </td>
            <td><?= (int) $row['quantity'] ?></td>
            <td><?= e($row['user_name']) ?></td>
            <td><?= e($row['notes'] ?? '-') ?></td>
        </tr>
    <?php endforeach; ?>
    <?php if (!$transactions): ?>
        <tr><td colspan="6" class="text-center">Belum ada transaksi.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</div>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>   