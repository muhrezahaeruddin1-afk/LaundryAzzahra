<!doctype html><html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Layanan & Harga</title>
<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
<style>
.wrap{max-width:1000px;margin:20px auto;padding:0 16px}
.card{background:#fff;border-radius:12px;padding:16px;box-shadow:0 10px 30px rgba(0,0,0,.06)}
.table{width:100%;border-collapse:collapse;margin-top:12px}
.table th,.table td{padding:10px;border-bottom:1px solid #eef2f7;font-size:14px}
.badge{padding:4px 8px;border-radius:8px;font-size:12px;font-weight:700}
.on{background:#dcfce7;color:#166534}
.off{background:#fee2e2;color:#991b1b}
.actions a{margin-right:6px;text-decoration:none;font-size:13px;padding:6px 10px;border-radius:8px}
.btn{background:var(--brand-green,#059669);color:#fff}
.btn-outline{border:1px solid #e5e7eb;background:#fff}
.btn-danger{background:#ef4444;color:#fff}
</style>
</head><body>

<button class="back-btn" onclick="history.back()">← Back</button>

<div class="wrap">
  <h2>Layanan & Harga</h2>

  <div class="card">
    <a class="btn" href="<?= site_url('layanan/create'); ?>">+ Tambah Layanan</a>

    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama Layanan</th>
          <th>Satuan</th>
          <th>Harga</th>
          <th>Status</th>
          <th style="width:240px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($layanan as $i=>$l): ?>
        <tr>
          <td><?= $i+1; ?></td>
          <td><?= htmlentities($l->nama); ?></td>
          <td><?= $l->tipe_satuan; ?></td>
          <td>Rp <?= number_format((int)$l->harga_per_satuan,0,',','.'); ?></td>
          <td>
            <span class="badge <?= $l->aktif?'on':'off'; ?>">
              <?= $l->aktif ? 'AKTIF' : 'NONAKTIF'; ?>
            </span>
          </td>
          <td class="actions">
            <a class="btn-outline" href="<?= site_url('layanan/edit/'.$l->id); ?>">Edit</a>
            <a class="btn-outline" href="<?= site_url('layanan/toggle/'.$l->id); ?>">
              <?= $l->aktif ? 'Nonaktifkan' : 'Aktifkan'; ?>
            </a>
            <a class="btn-danger" href="<?= site_url('layanan/delete/'.$l->id); ?>"
               onclick="return confirm('Hapus layanan ini?')">Hapus</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</body></html>
