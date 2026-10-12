<div class="mb-3">
    <label class="form-label">Nama Kategori</label>
    <input type="text" name="name" class="form-control" required
           value="<?= e($category['name'] ?? '') ?>">
</div>
<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" class="form-control" rows="3"><?= e($category['description'] ?? '') ?></textarea>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="<?= base_url('categories') ?>" class="btn btn-secondary">Batal</a>