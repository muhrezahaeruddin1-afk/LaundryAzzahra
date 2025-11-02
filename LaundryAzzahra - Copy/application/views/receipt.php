<!doctype html><html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Struk Pembayaran</title>
<style>
body{font-family:system-ui,Segoe UI,Roboto,Arial,sans-serif}
.wrap{max-width:420px;margin:10px auto;border:1px dashed #cbd5e1;padding:12px;border-radius:8px}
h2{margin:0 0 6px}
small{color:#64748b}
table{width:100%;border-collapse:collapse;margin-top:8px}
td{padding:4px 0;border-bottom:1px dotted #e5e7eb;font-size:14px}
tfoot td{border:0;font-weight:700}
.actions{display:flex;gap:8px;margin-top:10px}
.btn{padding:8px 12px;border-radius:8px;border:1px solid #e5e7eb;background:#fff;cursor:pointer}
@media print {.actions{display:none}.wrap{border:0}}
</style>
</head><body>
<div class="wrap">
  <h2>Laundry Azzahra</h2>
  <small>Jln. Manuruki 2 No. 79, Makassar</small>
  <hr>

  <div style="font-size:14px">
    <div><b>Kode</b>: <?= $trx->kode; ?></div>
    <div><b>Tanggal</b>: <?= date('d/m/Y H:i', strtotime($trx->created_at)); ?></div>
    <div><b>Pelanggan</b>: <?= $trx->nama_pelanggan ?: '-'; ?> <?= $trx->telp ? '(' . $trx->telp . ')' : '' ?></div>
  </div>

  <table>
    <tbody>
    <?php foreach($items as $it): ?>
      <tr>
        <td><?= $it->nama; ?> (<?= $it->tipe_satuan; ?>) × <?= rtrim(rtrim(number_format($it->qty,2,'.',''), '0'),'.'); ?></td>
        <td style="text-align:right">Rp <?= number_format($it->subtotal,0,',','.'); ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr><td>Total</td><td style="text-align:right">Rp <?= number_format($trx->total,0,',','.'); ?></td></tr>
      <?php if($trx->diskon>0): ?>
      <tr><td>Diskon</td><td style="text-align:right">- Rp <?= number_format($trx->diskon,0,',','.'); ?></td></tr>
      <?php endif; ?>
      <?php if($trx->biaya_tambahan>0): ?>
      <tr><td>Biaya Tambahan</td><td style="text-align:right">Rp <?= number_format($trx->biaya_tambahan,0,',','.'); ?></td></tr>
      <?php endif; ?>
      <tr><td>Grand Total</td><td style="text-align:right">Rp <?= number_format($trx->grand_total,0,',','.'); ?></td></tr>
      <tr><td>Metode</td><td style="text-align:right"><?= $trx->metode; ?></td></tr>
      <tr><td>Status</td><td style="text-align:right"><?= $trx->status_bayar; ?></td></tr>
    </tfoot>
  </table>

  <?php if($trx->metode==='QRIS' && $trx->status_bayar==='UNPAID'): ?>
  <div style="margin-top:8px">
    <small>Silakan scan QRIS di bawah ini lalu tekan “Tandai Lunas”.</small><br>
    <img src="<?= base_url('assets/img/qris.png'); ?>" alt="QRIS"
         style="width:200px;height:auto;border:1px solid #e5e7eb;border-radius:8px;margin-top:6px">
  </div>
  <form method="post" action="<?= site_url('order/mark_paid/'.$trx->id); ?>" class="actions">
    <input type="text" name="qris_ref" placeholder="Ref/Trace ID (opsional)">
    <button class="btn" type="submit">Tandai Lunas</button>
    <button class="btn" type="button" onclick="window.print()">Print</button>
  </form>
<?php else: ?>
  <div class="actions">
    <form method="post" action="<?= site_url('order/done/'.$trx->id); ?>">
      <button class="btn" type="submit">Tandai Selesai</button>
    </form>
    <button class="btn" type="button" onclick="window.print()">Print</button>
  </div>
<?php endif; ?>


  <div style="text-align:center;margin-top:8px"><small>Terima kasih 🙏</small></div>
</div>
</body></html>
