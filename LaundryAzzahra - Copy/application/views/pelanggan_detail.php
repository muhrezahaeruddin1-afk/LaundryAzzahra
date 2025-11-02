<!doctype html><html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Detail Pelanggan</title>
<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
<style>
.wrap{max-width:1000px;margin:20px auto;padding:0 16px}
.card{background:#fff;border-radius:12px;padding:16px;box-shadow:0 10px 30px rgba(0,0,0,.06);margin-bottom:12px}
.table{width:100%;border-collapse:collapse;margin-top:12px}
.table th,.table td{padding:10px;border-bottom:1px solid #eef2f7;font-size:14px}
.kpi{display:flex;gap:14px}
.kpi div{background:#fff;border-radius:12px;padding:12px 14px;box-shadow:0 6px 18px rgba(0,0,0,.06)}
.kpi .num{font-size:22px;font-weight:800;color:var(--brand-green,#059669)}
</style>
</head><body>

<button class="back-btn" onclick="history.back()">← Back</button>

<div class="wrap">
  <h2>Detail Pelanggan</h2>

  <div class="card">
    <p><strong>Nama:</strong> <?= htmlentities($info->nama); ?></p>
    <p><strong>Telp:</strong> <?= htmlentities($info->telp); ?></p>
    <p><strong>Alamat:</strong> <?= htmlentities($info->alamat); ?></p>
    <div class="kpi">
      <div><div>Total Transaksi</div><div class="num"><?= (int)$sum->jml_transaksi; ?></div></div>
      <div><div>Total Belanja</div><div class="num">Rp <?= number_format($sum->total_belanja,0,',','.'); ?></div></div>
    </div>
  </div>

  <div class="card">
    <h3>Riwayat Transaksi</h3>
    <table class="table">
      <thead><tr>
        <th>Kode</th><th>Tanggal</th><th>Status Pesanan</th>
        <th>Metode</th><th>Status Bayar</th><th style="text-align:right">Total</th><th>Aksi</th>
      </tr></thead>
      <tbody>
        <?php foreach($list as $r): ?>
        <tr>
          <td><?= $r->kode; ?></td>
          <td><?= date('d/m/Y H:i', strtotime($r->tanggal_masuk)); ?></td>
          <td><?= $r->status; ?></td>
          <td><?= $r->metode; ?></td>
          <td><?= $r->status_bayar; ?></td>
          <td style="text-align:right">Rp <?= number_format((int)$r->grand_total,0,',','.'); ?></td>
          <td><a class="btn" href="<?= site_url('order/receipt/'.$r->pesanan_id); ?>">Struk</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</body></html>
