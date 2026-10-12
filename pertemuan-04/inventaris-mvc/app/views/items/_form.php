<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Kode</label>
        <input type="text" name="code" class="form-control" required
               value="<?= e($code) ?>">
    </div>
    <div class="col-md-8 mb-3">
        <label class="form-label">Nama Barang</label>
        <input type="text" name="name" class="form-control" required
               value="<?= e($item['name'] ?? '') ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select">
            <option value="">-- Tanpa kategori --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= (int) $cat['id'] ?>"
                    <?= (($item['category_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                    <?= e($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Stok</label>
        <input type="number" name="quantity" min="0" class="form-control"
               value="<?= e($item['quantity'] ?? 0) ?>">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Satuan</label>
        <input type="text" name="unit" class="form-control"
               value="<?= e($item['unit'] ?? 'unit') ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Harga (Rp)</label>
        <input type="number" name="price" min="0" step="0.01" class="form-control"
               value="<?= e($item['price'] ?? 0) ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Tanggal Masuk</label>
        <input type="date" name="entry_date" class="form-control"
               value="<?= e($item['entry_date'] ?? '') ?>">
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="3"><?= e($item['description'] ?? '') ?></textarea>
    </div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="<?= base_url('items') ?>" class="btn btn-secondary">Batal</a>