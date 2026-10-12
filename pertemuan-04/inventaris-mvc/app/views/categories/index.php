<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Data Kategori</h1>
    <a href="<?= base_url('categories/create') ?>" class="btn btn-primary">Tambah Kategori</a>
</div>
<table class="table table-striped bg-white">
    <thead>
        <tr><th>#</th><th>Nama</th><th>Deskripsi</th><th>Jumlah Barang</th><th>Aksi</th></tr>
    </thead>
    <tbody>
    <?php foreach ($categories as $i => $row): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= e($row['name']) ?></td>
            <td><?= e($row['description']) ?></td>
            <td><?= (int) $row['item_count'] ?></td>
            <td>
                <a href="<?= base_url('categories/edit/' . (int) $row['id']) ?>" class="btn btn-sm btn-warning">Ubah</a>
                <form method="post" action="<?= base_url('categories/delete/' . (int) $row['id']) ?>"
                      class="d-inline" onsubmit="return confirm('Hapus kategori ini?');">
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (!$categories): ?>
        <tr><td colspan="5" class="text-center">Belum ada kategori.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>