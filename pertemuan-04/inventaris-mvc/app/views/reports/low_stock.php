<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<h1 class="h3 mb-3">Laporan Stok Menipis</h1>

<form method="get" action="<?= base_url('reports/lowStock') ?>" class="row g-2 mb-3">
    <div class="col-md-3">
        <label class="form-label">Tanggal masuk dari</label>
        <input type="date" name="from" class="form-control" value="<?= e($from) ?>">
    </div>
    <div class="col-md-3">
        <label class="form-label">Sampai</label>
        <input type="date" name="to" class="form-control" value="<?= e($to) ?>">
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary me-2">Tampilkan</button>
        <a href="<?= base_url('reports/lowStock') ?>" class="btn btn-secondary">Reset</a>
    </div>
</form>

<p class="text-muted">Barang dengan stok &le; 5. Ditemukan: <?= count($rows) ?> barang.</p>
<table class="table table-striped bg-white">
    <thead><tr><th>Kode</th><th>Nama</th><th>Kategori</th><th>Stok</th><th>Tanggal Masuk</th></tr></thead>
    <tbody>
    <?php foreach ($rows as $row): ?>
        <tr>
            <td><?= e($row['code']) ?></td>
            <td><?= e($row['name']) ?></td>
            <td><?= e($row['category_name'] ?? '-') ?></td>
            <td><?= (int) $row['quantity'] ?> <?= e($row['unit']) ?></td>
            <td><?= e($row['entry_date'] ?? '-') ?></td>
        </tr>
    <?php endforeach; ?>
    <?php if (!$rows): ?>
        <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>