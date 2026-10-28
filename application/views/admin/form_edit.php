<div class="container mt-4">
    <h3>Edit Admin</h3>

    <form action="<?= site_url('admin/edit/' . $admin->id); ?>" method="POST">

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="<?= $admin->nama; ?>" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $admin->email; ?>" required>
        </div>

        <div class="form-group">
            <label>Password Baru (isi jika ingin ganti)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="<?= site_url('admin'); ?>" class="btn btn-secondary">Kembali</a>

    </form>
</div>
