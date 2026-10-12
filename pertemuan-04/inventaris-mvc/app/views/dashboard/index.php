<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<h1 class="h3 mb-3">Dashboard</h1>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card"><div class="card-body">
        <div class="text-muted">Total Barang</div>
        <div class="fs-4"><?= (int) $totalItems ?></div>
    </div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body">
        <div class="text-muted">Total Stok</div>
        <div class="fs-4"><?= (int) $totalStock ?></div>
    </div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body">
        <div class="text-muted">Nilai Aset</div>
        <div class="fs-4"><?= rupiah($assetValue) ?></div>
    </div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body">
        <div class="text-muted">Stok Menipis</div>
        <div class="fs-4"><?= (int) $lowStockCount ?></div>
        <div class="small text-muted">Transaksi hari ini: <?= (int) $todayCount ?></div>
    </div></div></div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <h2 class="h5">Stok Menipis</h2>
        <table class="table table-sm table-striped bg-white">
            <thead><tr><th>Kode</th><th>Nama</th><th>Stok</th></tr></thead>
            <tbody>
            <?php foreach ($lowStockItems as $row): ?>
                <tr>
                    <td><?= e($row['code']) ?></td>
                    <td><?= e($row['name']) ?></td>
                    <td><?= (int) $row['quantity'] ?> <?= e($row['unit']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$lowStockItems): ?>
                <tr><td colspan="3" class="text-center">Tidak ada stok menipis.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="col-lg-6">
        <h2 class="h5">Transaksi Terbaru</h2>
        <table class="table table-sm table-striped bg-white">
            <thead><tr><th>Waktu</th><th>Barang</th><th>Tipe</th><th>Jumlah</th></tr></thead>
            <tbody>
            <?php foreach ($recentTransactions as $row): ?>
                <tr>
                    <td><?= e($row['created_at']) ?></td>
                    <td><?= e($row['item_name']) ?></td>
                    <td><?= $row['type'] === 'IN' ? 'Masuk' : 'Keluar' ?></td>
                    <td><?= (int) $row['quantity'] ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$recentTransactions): ?>
                <tr><td colspan="4" class="text-center">Belum ada transaksi.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>