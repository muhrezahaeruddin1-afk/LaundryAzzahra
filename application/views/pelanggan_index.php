<!doctype html><html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Data Pelanggan</title>
<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
<style>
.wrap{max-width:1000px;margin:20px auto;padding:0 16px}
.card{background:#fff;border-radius:12px;padding:16px;box-shadow:0 10px 30px rgba(0,0,0,.06)}
.table{width:100%;border-collapse:collapse;margin-top:12px}
.table th,.table td{padding:10px;border-bottom:1px solid #eef2f7;font-size:14px}
.actions a{margin-right:6px;text-decoration:none;font-size:13px;padding:6px 10px;border-radius:8px}
.btn{background:var(--brand-green,#059669);color:#fff}
.btn-outline{border:1px solid #e5e7eb;background:#fff}
.btn-danger{background:#ef4444;color:#fff}
.search{display:flex;gap:8px;align-items:center;margin-bottom:8px}
</style>
</head><body>

<button class="back-btn" onclick="history.back()">← Back</button>

<div class="wrap">
  <h2>Pelanggan</h2>

  <div class="card">
    <div class="search">
      <form method="get">
        <input type="text" name="q" placeholder="Cari nama / telp" value="<?= htmlentities($q) ?>">
        <button class="btn-outline" type="submit">Cari</button>
      </form>
      <a class="btn" href="<?= site_url('pelanggan/create'); ?>">+ Tambah Pelanggan</a>
    </div>

    <table class="table">
      <thead><tr>
        <th>#</th><th>Nama</th><th>Telp</th><th>Alamat</th><th>Aksi</th>
      </tr></thead>
      <tbody>
        <?php foreach($rows as $i=>$r): ?>
        <tr>
          <td><?= $i+1; ?></td>
          <td><?= htmlentities($r->nama); ?></td>
          <td><?= htmlentities($r->telp); ?></td>
          <td><?= htmlentities($r->alamat); ?></td>
          <td class="actions">
            <a class="btn-outline" href="<?= site_url('pelanggan/detail/'.$r->id); ?>">Detail</a>
            <a class="btn-outline" href="<?= site_url('pelanggan/edit/'.$r->id); ?>">Edit</a>
            <a class="btn-danger" href="<?= site_url('pelanggan/delete/'.$r->id); ?>"
               onclick="return confirm('Hapus pelanggan ini?')">Hapus</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</body></html>
