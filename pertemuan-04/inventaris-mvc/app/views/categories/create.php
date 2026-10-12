<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<h1 class="h3 mb-3">Tambah Kategori</h1>
<form method="post" action="<?= base_url('categories/store') ?>">
    <?php require __DIR__ . '/_form.php'; ?>
</form>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>