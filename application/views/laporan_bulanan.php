<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Laporan Bulanan</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root{
  --brand:#059669; --brand2:#10b981; --ink:#111827; --muted:#6b7280; --line:#eef2f7;
  --card:#fff; --radius:12px; --shadow:0 8px 24px rgba(0,0,0,.06);
}
*{box-sizing:border-box}
body{font-family:'Poppins',sans-serif;background:#f9fafb;color:var(--ink);margin:0}
.wrap{max-width:1100px;margin:20px auto;padding:0 16px}
h2{margin:0 0 12px;font-weight:700;color:var(--brand)}
.card{background:var(--card);border-radius:var(--radius);padding:16px;box-shadow:var(--shadow);margin-bottom:12px}

/* toolbar */
.toolbar{display:flex;gap:10px;flex-wrap:wrap;align-items:center}
.input{border:1px solid #d1d5db;border-radius:10px;padding:8px 10px;background:#fff;font-size:14px}
.btn{display:inline-flex;align-items:center;gap:8px;border:none;border-radius:10px;padding:8px 12px;font-weight:600;cursor:pointer;text-decoration:none}
.btn-outline{background:#fff;border:1px solid #e5e7eb;color:#111827}
.btn-primary{background:var(--brand);color:#fff}
.btn:hover{opacity:.95;transform:translateY(-1px)}

/* KPI */
.kpi{display:flex;gap:12px;flex-wrap:wrap}
.kpi .box{flex:1;min-width:220px;background:var(--card);padding:14px;border-radius:12px;box-shadow:var(--shadow)}
.kpi .title{font-size:13px;color:var(--muted);display:flex;gap:8px;align-items:center}
.kpi .num{font-size:22px;font-weight:800;color:var(--brand);margin-top:4px}

/* table */
.table{width:100%;border-collapse:collapse}
.table th{background:#ecfdf5;color:#065f46;border-bottom:2px solid #d1fae5;padding:10px;font-size:14px;text-align:left}
.table td{padding:10px;border-bottom:1px solid var(--line);font-size:14px;vertical-align:middle}
.table tr:hover{background:#f8fffb}
.text-right{text-align:right}

canvas{max-height:340px}
.back-btn{margin:12px 0 0 12px;background:none;border:none;color:var(--brand);cursor:pointer;font-weight:500}
.back-btn:hover{text-decoration:underline}

@media print{
  .no-print{display:none}
  .card{box-shadow:none;border:0}
}
</style>
</head>
<body>

<button class="back-btn no-print" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i> Kembali</button>

<div class="wrap">
  <h2>Laporan Bulanan</h2>

  <div class="card">
    <form method="get" class="toolbar">
      <input class="input" type="month" name="bulan" value="<?= $bulan ?>">
      <button class="btn btn-outline" type="submit"><i class="fa-solid fa-filter"></i> Tampilkan</button>

      <div style="margin-left:auto" class="no-print">
        <a class="btn btn-outline" href="<?= site_url('laporan/harian?tanggal='.$bulan.'-'.date('d')); ?>">
          <i class="fa-solid fa-calendar-day"></i> Ke Laporan Harian
        </a>
        <button class="btn btn-outline" type="button" id="btnCSV"><i class="fa-solid fa-file-csv"></i> Export CSV</button>
        <button class="btn btn-outline" type="button" id="btnPNG"><i class="fa-solid fa-image"></i> Download PNG Chart</button>
        <button class="btn btn-primary" type="button" onclick="window.print()"><i class="fa-solid fa-print"></i> Print</button>
      </div>
    </form>
  </div>

  <!-- KPI -->
  <div class="kpi">
    <div class="box">
      <div class="title"><i class="fa-solid fa-receipt"></i> Total Pesanan</div>
      <div class="num"><?= (int)$sum->jml_pesanan; ?></div>
    </div>
    <div class="box">
      <div class="title"><i class="fa-solid fa-check-circle"></i> Pesanan Selesai</div>
      <div class="num"><?= (int)$sum->jml_selesai; ?></div>
    </div>
    <div class="box">
      <div class="title"><i class="fa-solid fa-wallet"></i> Pendapatan (PAID)</div>
      <div class="num">Rp <?= number_format($sum->pendapatan,0,',','.'); ?></div>
    </div>
  </div>

  <div class="card">
    <h3 style="margin:0 0 10px">Grafik Pendapatan Harian</h3>
    <canvas id="chart"></canvas>
  </div>

  <div class="card">
    <h3 style="margin:0 0 10px">Tabel Ringkas</h3>
    <table class="table" id="tbl">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Pesanan</th>
          <th>Selesai</th>
          <th class="text-right">Pendapatan</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($per_hari as $r): ?>
        <tr>
          <td><?= date('d/m/Y', strtotime($r->tgl)); ?></td>
          <td><?= (int)$r->jml_pesanan; ?></td>
          <td><?= (int)$r->jml_selesai; ?></td>
          <td class="text-right">Rp <?= number_format((int)$r->pendapatan,0,',','.'); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Data dari PHP
const dataPHP = <?php
  $labels = []; $values = [];
  foreach($per_hari as $r){ $labels[] = date('d', strtotime($r->tgl)); $values[] = (int)$r->pendapatan; }
  echo json_encode(['labels'=>$labels,'values'=>$values]);
?>;

// Chart dengan gradient
const ctx = document.getElementById('chart').getContext('2d');
const gradient = ctx.createLinearGradient(0,0,0,300);
gradient.addColorStop(0,'rgba(5,150,105,0.25)');
gradient.addColorStop(1,'rgba(5,150,105,0.0)');

const chart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: dataPHP.labels,
    datasets: [{
      label: 'Pendapatan (Rp)',
      data: dataPHP.values,
      tension: .25,
      fill: true,
      backgroundColor: gradient,
      borderColor: '#059669',
      pointRadius: 3,
      pointHoverRadius: 5
    }]
  },
  options: {
    plugins: {
      legend: { display: true },
      tooltip: {
        callbacks: {
          label: (ctx) => ' Rp ' + new Intl.NumberFormat('id-ID').format(ctx.parsed.y)
        }
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: { callback: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v) }
      }
    }
  }
});

// Export CSV dari tabel (yang tampil)
document.getElementById('btnCSV').addEventListener('click', ()=>{
  const head = [...document.querySelectorAll('#tbl thead th')].map(th=>`"${th.innerText.replace(/"/g,'""')}"`).join(',');
  const body = [...document.querySelectorAll('#tbl tbody tr')].map(tr=>[...tr.children].map(td=>`"${td.innerText.replace(/"/g,'""')}"`).join(',')).join('\n');
  const csv = head+'\n'+body;
  const blob = new Blob([csv],{type:'text/csv;charset=utf-8;'});
  const a = document.createElement('a'); a.href = URL.createObjectURL(blob);
  a.download = 'laporan-bulanan-<?= $bulan ?>.csv'; a.click();
});

// Download PNG chart
document.getElementById('btnPNG').addEventListener('click', ()=>{
  const url = document.getElementById('chart').toDataURL('image/png');
  const a = document.createElement('a'); a.href = url; a.download = 'chart-bulanan-<?= $bulan ?>.png'; a.click();
});
</script>
</body>
</html>
