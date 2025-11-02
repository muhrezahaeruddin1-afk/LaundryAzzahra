<!doctype html><html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Laporan Bulanan</title>
<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
<style>
.wrap{max-width:1100px;margin:20px auto;padding:0 16px}
.card{background:#fff;border-radius:12px;padding:16px;box-shadow:0 10px 30px rgba(0,0,0,.06);margin-bottom:12px}
.kpi{display:flex;gap:12px;flex-wrap:wrap}
.kpi .box{flex:1;min-width:160px;background:#fff;padding:12px;border-radius:12px;box-shadow:0 6px 18px rgba(0,0,0,.06)}
.kpi .num{font-size:22px;font-weight:800;color:var(--brand-green,#059669)}
.table{width:100%;border-collapse:collapse}
.table th,.table td{padding:10px;border-bottom:1px solid #eef2f7;font-size:14px}
.btn{background:var(--brand-green,#059669);color:#fff;border:none;border-radius:10px;padding:8px 12px;text-decoration:none;display:inline-block}
.btn-outline{border:1px solid #e5e7eb;border-radius:10px;padding:8px 12px;background:#fff;text-decoration:none}
.actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap;margin:8px 0}
canvas{max-height:320px}
</style>
</head><body>

<button class="back-btn" onclick="history.back()">← Back</button>

<div class="wrap">
  <h2>Laporan Bulanan</h2>

  <div class="card">
    <form method="get" style="display:flex;gap:8px;align-items:center">
      <input type="month" name="bulan" value="<?= $bulan ?>">
      <button class="btn-outline" type="submit">Tampilkan</button>
      <div class="actions" style="margin-left:auto">
        <a class="btn-outline" href="<?= site_url('laporan/harian?tanggal='.$bulan.'-'.date('d')); ?>">Ke Laporan Harian</a>
        <button class="btn" type="button" onclick="window.print()">Print</button>
      </div>
    </form>
  </div>

  <div class="kpi">
    <div class="box"><div>Total Pesanan</div><div class="num"><?= (int)$sum->jml_pesanan; ?></div></div>
    <div class="box"><div>Pesanan Selesai</div><div class="num"><?= (int)$sum->jml_selesai; ?></div></div>
    <div class="box"><div>Pendapatan (PAID)</div><div class="num">Rp <?= number_format($sum->pendapatan,0,',','.'); ?></div></div>
  </div>

  <div class="card">
    <h3>Grafik Pendapatan Harian</h3>
    <canvas id="chart"></canvas>
  </div>

  <div class="card">
    <h3>Tabel Ringkas</h3>
    <table class="table">
      <thead><tr>
        <th>Tanggal</th><th>Pesanan</th><th>Selesai</th><th style="text-align:right">Pendapatan</th>
      </tr></thead>
      <tbody>
        <?php foreach($per_hari as $r): ?>
        <tr>
          <td><?= date('d/m/Y', strtotime($r->tgl)); ?></td>
          <td><?= (int)$r->jml_pesanan; ?></td>
          <td><?= (int)$r->jml_selesai; ?></td>
          <td style="text-align:right">Rp <?= number_format((int)$r->pendapatan,0,',','.'); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Chart.js CDN (sederhana) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const data = <?php
  $labels = []; $values = [];
  foreach($per_hari as $r){ $labels[] = date('d', strtotime($r->tgl)); $values[] = (int)$r->pendapatan; }
  echo json_encode(['labels'=>$labels,'values'=>$values]);
?>;

const ctx = document.getElementById('chart').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: data.labels,
    datasets: [{ label: 'Pendapatan (Rp)', data: data.values, tension: .25 }]
  },
  options: {
    plugins: { legend: { display: true } },
    scales: { y: { beginAtZero: true } }
  }
});
</script>
</body></html>
