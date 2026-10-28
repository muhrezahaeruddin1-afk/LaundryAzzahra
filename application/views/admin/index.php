<div class="container mt-4">
    <h3>Manajemen Admin</h3>

    <a href="<?= site_url('admin/add'); ?>" class="btn btn-primary mb-3">Tambah Admin</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php $no = 1; foreach ($admins as $a): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $a->nama; ?></td>
                    <td><?= $a->username; ?></td>
                    <td><?= $a->email; ?></td>
                    <td>
                        <a href="<?= site_url('admin/edit/' . $a->id); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= site_url('admin/delete/' . $a->id); ?>" onclick="return confirm('Hapus admin ini?');" class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
