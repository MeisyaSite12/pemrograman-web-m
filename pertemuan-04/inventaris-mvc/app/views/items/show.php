<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Detail Barang</h1>
    <a href="<?= base_url('items') ?>" class="btn btn-secondary">Kembali</a>
</div>

<div class="card mb-4"><div class="card-body">
    <dl class="row mb-0">
        <dt class="col-sm-3">Kode</dt><dd class="col-sm-9"><?= e($item['code']) ?></dd>
        <dt class="col-sm-3">Nama</dt><dd class="col-sm-9"><?= e($item['name']) ?></dd>
        <dt class="col-sm-3">Kategori</dt><dd class="col-sm-9"><?= e($item['category_name'] ?? '-') ?></dd>
        <dt class="col-sm-3">Stok</dt><dd class="col-sm-9"><?= (int) $item['quantity'] ?> <?= e($item['unit']) ?></dd>
        <dt class="col-sm-3">Harga</dt><dd class="col-sm-9"><?= rupiah($item['price']) ?></dd>
        <dt class="col-sm-3">Tanggal Masuk</dt><dd class="col-sm-9"><?= e($item['entry_date'] ?? '-') ?></dd>
        <dt class="col-sm-3">Deskripsi</dt><dd class="col-sm-9"><?= e($item['description'] ?? '-') ?></dd>
    </dl>
</div></div>

<h2 class="h5">Riwayat Transaksi</h2>
<table class="table table-striped bg-white">
    <thead><tr><th>Waktu</th><th>Tipe</th><th>Jumlah</th><th>Petugas</th><th>Catatan</th></tr></thead>
    <tbody>
    <?php foreach ($transactions as $row): ?>
        <tr>
            <td><?= e($row['created_at']) ?></td>
            <td><?= $row['type'] === 'IN' ? 'Masuk' : 'Keluar' ?></td>
            <td><?= (int) $row['quantity'] ?></td>
            <td><?= e($row['user_name']) ?></td>
            <td><?= e($row['notes'] ?? '-') ?></td>
        </tr>
    <?php endforeach; ?>
    <?php if (!$transactions): ?>
        <tr><td colspan="5" class="text-center">Belum ada transaksi untuk barang ini.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>