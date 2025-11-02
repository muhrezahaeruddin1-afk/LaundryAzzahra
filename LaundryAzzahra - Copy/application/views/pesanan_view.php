<!doctype html><html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Daftar Pesanan</title>
<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
<style>
.wrap{max-width:1000px;margin:20px auto;padding:0 16px}
.card{background:#fff;border-radius:12px;padding:16px;box-shadow:0 10px 30px rgba(0,0,0,.06)}
.table{width:100%;border-collapse:collapse;margin-top:12px}
.table th,.table td{padding:10px;border-bottom:1px solid #eef2f7;font-size:14px;text-align:left}
.status{padding:4px 8px;border-radius:6px;font-size:12px;font-weight:600}
.MASUK{background:#fef9c3;color:#92400e}
.PROSES{background:#dbeafe;color:#1e3a8a}
.SELESAI{background:#dcfce7;color:#166534}
.actions a{margin-right:6px;text-decoration:none;font-size:13px;padding:6px 10px;border-radius:8px}
.btn{background:var(--brand-green,#059669);color:#fff}
.btn-danger{background:#ef4444;color:#fff}
.filter{margin:8px 0}
</style>
</head><body>

<button class="back-btn" onclick="history.back()">← Back</button>

<div class="wrap">
  <h2>Daftar Pesanan Laundry</h2>

  <!-- Filter status -->
  <form method="get" class="filter">
    <?php $now = isset($status_now)?$status_now:'ALL'; ?>
    <select name="status" onchange="this.form.submit()">
      <option value="ALL"     <?= $now==='ALL'?'selected':''; ?>>Semua</option>
      <option value="MASUK"   <?= $now==='MASUK'?'selected':''; ?>>MASUK</option>
      <option value="PROSES"  <?= $now==='PROSES'?'selected':''; ?>>PROSES</option>
      <option value="SELESAI" <?= $now==='SELESAI'?'selected':''; ?>>SELESAI</option>
    </select>
  </form>

  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Pelanggan</th>
          <th>Tanggal Masuk</th>
          <th>Status</th>
          <th>Metode</th>
          <th>Total</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($pesanan as $p): ?>
          <tr>
            <td><?= $p->kode; ?></td>
            <td><?= $p->nama_pelanggan ?: '-'; ?></td>
            <td><?= date('d/m/Y H:i', strtotime($p->tanggal_masuk)); ?></td>
            <td><span class="status <?= $p->status; ?>"><?= $p->status; ?></span></td>
            <td><?= $p->metode ?: '-'; ?></td>
            <td>Rp <?= number_format((int)$p->grand_total,0,',','.'); ?></td>
            <td class="actions">
              <a class="btn" href="<?= site_url('order/receipt/'.$p->id); ?>">Struk</a>
              <?php if($p->status !== 'SELESAI'): ?>
                <a class="btn" href="<?= site_url('pesanan/ubah_status/'.$p->id.'?status=PROSES'); ?>">Proses</a>
                <a class="btn" href="<?= site_url('pesanan/ubah_status/'.$p->id.'?status=SELESAI'); ?>">Selesai</a>
              <?php endif; ?>
              <a class="btn-danger" href="<?= site_url('pesanan/hapus/'.$p->id); ?>"
                 onclick="return confirm('Yakin hapus pesanan ini?')">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

</body></html>
