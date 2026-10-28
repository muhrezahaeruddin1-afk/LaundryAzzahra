<div class="container mt-4">
    <h3>Tambah Admin</h3>

    <form action="<?= site_url('admin/add'); ?>" method="POST">

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="<?= site_url('admin'); ?>" class="btn btn-secondary">Kembali</a>

    </form>
</div>
