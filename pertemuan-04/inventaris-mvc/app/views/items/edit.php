<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<h1 class="h3 mb-3">Ubah Barang</h1>
<form method="post" action="<?= base_url('items/update/' . (int) $item['id']) ?>">
    <?php require __DIR__ . '/_form.php'; ?>
</form>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>