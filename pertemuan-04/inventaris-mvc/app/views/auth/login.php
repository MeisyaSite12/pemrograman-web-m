<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-4">
        <h1 class="h3 mb-3">Login</h1>
        <form method="post" action="<?= base_url('auth/authenticate') ?>">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Masuk</button>
        </form>
    </div>
</div>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>