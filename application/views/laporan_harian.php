<!doctype html><html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Laporan Harian</title>
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
</style>
</head><body>

<button class="back-btn" onclick="history.back()">← Back</button>

<div class="wrap">
  <h2>Laporan Harian</h2>

  <div class="card">
    <form method="get" style="display:flex;gap:8px;align-items:center">
      <input type="date" name="tanggal" value="<?= $tanggal ?>">
      <button class="btn-outline" type="submit">Tampilkan</button>
      <div class="actions" style="margin-left:auto">
        <a class="btn-outline" href="<?= site_url('laporan/bulanan?bulan='.substr($tanggal,0,7)); ?>">Ke Laporan Bulanan</a>
        <button class="btn-outline" type="button" onclick="exportCSV()">Export CSV</button>
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
    <table class="table" id="tbl">
      <thead><tr>
        <th>Kode</th><th>Tanggal</th><th>Pelanggan</th><th>Status</th>
        <th>Metode</th><th>Status Bayar</th><th style="text-align:right">Total</th><th>Aksi</th>
      </tr></thead>
      <tbody>
        <?php foreach($rows as $r): ?>
        <tr>
          <td><?= $r->kode; ?></td>
          <td><?= date('d/m/Y H:i', strtotime($r->tanggal_masuk)); ?></td>
          <td><?= htmlentities($r->pelanggan); ?></td>
          <td><?= $r->status; ?></td>
          <td><?= $r->metode; ?></td>
          <td><?= $r->status_bayar; ?></td>
          <td style="text-align:right">Rp <?= number_format((int)$r->total,0,',','.'); ?></td>
          <td><a class="btn" href="<?= site_url('order/receipt/'.$r->pesanan_id); ?>">Struk</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
function exportCSV(){
  const rows = [...document.querySelectorAll('#tbl tr')]
    .map(tr => [...tr.children].map(td => '"' + td.innerText.replace(/"/g,'""') + '"').join(','))
    .join('\n');
  const blob = new Blob([rows], {type:'text/csv;charset=utf-8;'});
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = 'laporan-harian-<?= $tanggal ?>.csv';
  a.click();
}
</script>
</body></html>
