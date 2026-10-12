<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Data Barang</h1>
    <div>
        <a href="<?= base_url('items/export') ?>" class="btn btn-outline-success">Export CSV</a>
        <?php if (can_manage()): ?>
            <a href="<?= base_url('items/create') ?>" class="btn btn-primary">Tambah Barang</a>
        <?php endif; ?>
    </div>
</div>

<form method="get" action="<?= base_url('items') ?>" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Cari kode, nama, kategori"
               value="<?= e($search) ?>">
    </div>
    <div class="col-md-3">
        <select name="category" class="form-select">
            <option value="">Semua kategori</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= (int) $cat['id'] ?>" <?= $category == $cat['id'] ? 'selected' : '' ?>>
                    <?= e($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2">
        <select name="limit" class="form-select">
            <?php foreach ([5, 10, 20, 50, 100] as $opt): ?>
                <option value="<?= $opt ?>" <?= $limit == $opt ? 'selected' : '' ?>><?= $opt ?> / halaman</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <button type="submit" class="btn btn-primary">Cari</button>
        <a href="<?= base_url('items') ?>" class="btn btn-secondary">Reset</a>
    </div>
</form>

<div class="table-responsive">
<table class="table table-striped bg-white align-middle">
    <thead>
        <tr><th>Kode</th><th>Nama</th><th>Kategori</th><th>Stok</th><th>Harga</th><th>Aksi</th></tr>
    </thead>
    <tbody>
    <?php foreach ($items as $row): ?>
        <tr>
            <td><?= e($row['code']) ?></td>
            <td><?= e($row['name']) ?></td>
            <td><?= e($row['category_name'] ?? '-') ?></td>
            <td>
                <?= (int) $row['quantity'] ?> <?= e($row['unit']) ?>
                <?php if ((int) $row['quantity'] <= 5): ?>
                    <span class="badge bg-danger">Menipis</span>
                <?php endif; ?>
            </td>
            <td><?= rupiah($row['price']) ?></td>
            <td>
                <a href="<?= base_url('items/show/' . (int) $row['id']) ?>" class="btn btn-sm btn-info">Detail</a>
                <button type="button" class="btn btn-sm btn-success"
                        data-bs-toggle="modal" data-bs-target="#stockModal"
                        data-id="<?= (int) $row['id'] ?>" data-name="<?= e($row['name']) ?>"
                        data-action="<?= base_url('transactions/stockIn') ?>">Masuk</button>
                <button type="button" class="btn btn-sm btn-secondary"
                        data-bs-toggle="modal" data-bs-target="#stockModal"
                        data-id="<?= (int) $row['id'] ?>" data-name="<?= e($row['name']) ?>"
                        data-action="<?= base_url('transactions/stockOut') ?>">Keluar</button>
                <?php if (can_manage()): ?>
                    <a href="<?= base_url('items/edit/' . (int) $row['id']) ?>" class="btn btn-sm btn-warning">Ubah</a>
                    <form method="post" action="<?= base_url('items/delete/' . (int) $row['id']) ?>"
                          class="d-inline" onsubmit="return confirm('Hapus barang ini?');">
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (!$items): ?>
        <tr><td colspan="6" class="text-center">Belum ada barang.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</div>

<?php if ($result['total_pages'] > 1): ?>
<nav>
    <ul class="pagination">
        <?php
        $qs = fn($p) => base_url('items') . '?' . http_build_query([
            'search' => $search, 'category' => $category, 'limit' => $limit, 'page' => $p,
        ]);
        ?>
        <li class="page-item <?= $result['current_page'] <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $qs($result['current_page'] - 1) ?>">Previous</a>
        </li>
        <?php for ($p = 1; $p <= $result['total_pages']; $p++): ?>
            <li class="page-item <?= $p == $result['current_page'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $qs($p) ?>"><?= $p ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?= $result['current_page'] >= $result['total_pages'] ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $qs($result['current_page'] + 1) ?>">Next</a>
        </li>
    </ul>
</nav>
<?php endif; ?>

<div class="modal fade" id="stockModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" class="modal-content" id="stockForm">
            <div class="modal-header">
                <h5 class="modal-title">Transaksi Stok: <span id="stockItemName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="item_id" id="stockItemId">
                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="quantity" min="1" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <input type="text" name="notes" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('stockModal').addEventListener('show.bs.modal', function (ev) {
    var b = ev.relatedTarget;
    document.getElementById('stockItemId').value = b.dataset.id;
    document.getElementById('stockItemName').textContent = b.dataset.name;
    document.getElementById('stockForm').action = b.dataset.action;
});
</script>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>