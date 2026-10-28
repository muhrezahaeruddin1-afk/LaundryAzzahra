<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Struk Pembayaran</title>

<!-- Font & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
  --brand: #059669;
  --muted: #6b7280;
  --line: #e5e7eb;
  --shadow: 0 8px 24px rgba(0,0,0,.06);
  --radius: 12px;
}

*{box-sizing:border-box}
body {
  font-family: 'Poppins', sans-serif;
  background: #f9fafb;
  color: #111827;
  margin: 0;
  padding: 0px;
}

.wrap {
  max-width: 440px;
  margin: 20px auto;
  background: #fff;
  padding: 18px 20px;
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  border: 1px solid #e2e8f0;
}

h2 {
  margin: 0;
  color: var(--brand);
  font-weight: 700;
  font-size: 20px;
}

small {
  color: var(--muted);
  font-size: 13px;
}

hr {
  border: 0;
  border-top: 1px solid var(--line);
  margin: 10px 0;
}

.table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 12px;
}

.table td {
  padding: 6px 0;
  font-size: 14px;
  border-bottom: 1px dotted var(--line);
}

tfoot td {
  font-weight: 600;
  border: none;
}

tfoot td b {
  color: #111827;
}

.actions {
  display: flex;
  gap: 8px;
  justify-content: center;
  margin-top: 14px;
}

.btn {
  border: none;
  padding: 8px 14px;
  border-radius: 10px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}

.btn:hover {
  opacity: 0.9;
  transform: translateY(-1px);
}

.btn-primary {
  background: var(--brand);
  color: #fff;
}

.btn-secondary {
  background: #f3f4f6;
  color: #111827;
  border: 1px solid var(--line);
}

.status {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-weight: 600;
  font-size: 13px;
  padding: 4px 10px;
  border-radius: 999px;
}

.status.PAID {
  background: #dcfce7;
  color: #166534;
}

.status.UNPAID {
  background: #fee2e2;
  color: #991b1b;
}

footer {
  text-align: center;
  margin-top: 10px;
  font-size: 13px;
  color: var(--muted);
}

.error-message {
  background: #fee2e2;
  color: #991b1b;
  padding: 16px;
  border-radius: var(--radius);
  text-align: center;
  margin: 20px 0;
}

@media print {
  .actions { display: none; }
  .wrap { box-shadow: none; border: none; }
}
</style>
</head>
<body>

<?php
$this->load->view('layouts/header', ['title' => 'Layanan & Harga']);
?> 
<div class="wrap">
  <h2>Laundry Azzahra</h2>
  <small>Jln. Manuruki 2 No. 79, Makassar</small>
  <hr>

  <?php if(!$trx): ?>
    <!-- Tampilkan pesan error jika data tidak ditemukan -->
    <div class="error-message">
      <i class="fa-solid fa-triangle-exclamation"></i><br>
      <strong>Data pesanan tidak ditemukan</strong><br>
      <small>Silakan periksa kembali ID pesanan</small>
    </div>
  <?php else: ?>
    <?php
      // Data tersedia, lakukan perhitungan - PERBAIKAN: ganti now() dengan date()
      $current_time = date('Y-m-d H:i:s');
      $waktu_setor = date('d/m/Y H:i', strtotime($trx->tanggal_masuk ?? $current_time));
      $estim_jam   = isset($trx->estimasi_selesai_jam) ? (int)$trx->estimasi_selesai_jam : 24;
      $waktu_ambil = date('d/m/Y H:i', strtotime(($trx->tanggal_masuk ?? $current_time) . ' + ' . $estim_jam . ' hours'));
      $isAntar    = (isset($trx->metode_terima) && $trx->metode_terima === 'antar');
      $labelETA   = $isAntar ? 'Estimasi Jam Antar' : 'Estimasi Jam Bisa Diambil';
      $biayaAntar = isset($trx->biaya_antar) ? (int)$trx->biaya_antar : 0;
      $grandView  = (int)($trx->grand_total ?? 0);
    ?>

    <table class="table-info" style="width:100%;font-size:14px;margin-bottom:10px">
      <tr><td><b>Kode</b></td><td><?= $trx->kode ?? '-'; ?></td></tr>
      <tr><td><b>Tanggal</b></td><td><?= date('d/m/Y H:i', strtotime($trx->tanggal_masuk ?? $current_time)); ?></td></tr>
      <tr><td><b>Pelanggan</b></td>
          <td><?= $trx->nama_pelanggan ?: '-'; ?> <?= $trx->telp ? '(' . $trx->telp . ')' : '' ?></td></tr>
      <tr><td><b>Jam/Tgl Setor</b></td><td><?= $waktu_setor; ?></td></tr>
      <tr><td><b><?= $labelETA; ?></b></td><td><?= $waktu_ambil; ?></td></tr>
      <tr><td><b>Cara Terima</b></td>
        <td>
          <?php if($isAntar): ?>
            Antar ke alamat
            <?php if(isset($trx->jarak_km)): ?>
              (<?= rtrim(rtrim(number_format($trx->jarak_km,2,'.',''), '0'),'.'); ?> km)
            <?php endif; ?>
          <?php else: ?>
            Ambil sendiri (GRATIS)
          <?php endif; ?>
        </td>
      </tr>
    </table>

    <table class="table">
      <tbody>
      <?php if(!empty($items)): ?>
        <?php foreach($items as $it): ?>
          <tr>
            <td><?= $it->nama ?? '-'; ?> (<?= $it->tipe_satuan ?? '-'; ?>) × <?= rtrim(rtrim(number_format($it->qty ?? 0,2,'.',''), '0'),'.'); ?></td>
            <td style="text-align:right">Rp <?= number_format($it->subtotal ?? 0,0,',','.'); ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="2" style="text-align:center;color:var(--muted);">Tidak ada item</td></tr>
      <?php endif; ?>
      </tbody>
      <tfoot>
        <tr><td>Subtotal</td><td style="text-align:right">Rp <?= number_format($trx->total ?? 0,0,',','.'); ?></td></tr>

        <?php if((int)($trx->diskon ?? 0) > 0): ?>
        <tr><td>Diskon</td><td style="text-align:right">- Rp <?= number_format($trx->diskon ?? 0,0,',','.'); ?></td></tr>
        <?php endif; ?>

        <?php if((int)($trx->biaya_tambahan ?? 0) > 0): ?>
        <tr><td>Biaya Express</td><td style="text-align:right">Rp <?= number_format($trx->biaya_tambahan ?? 0,0,',','.'); ?></td></tr>
        <?php endif; ?>

        <?php if($biayaAntar > 0): ?>
        <tr>
          <td>Biaya Antar <?php if(isset($trx->jarak_km)): ?><small>(<?= ceil($trx->jarak_km); ?> km × Rp 5.000)</small><?php endif; ?></td>
          <td style="text-align:right">Rp <?= number_format($biayaAntar,0,',','.'); ?></td>
        </tr>
        <?php endif; ?>

        <tr><td><b>Grand Total</b></td><td style="text-align:right"><b>Rp <?= number_format($grandView,0,',','.'); ?></b></td></tr>
        <tr><td>Metode</td><td style="text-align:right"><?= $trx->metode ?? '-'; ?></td></tr>
        <tr>
          <td>Status</td>
          <td style="text-align:right">
            <span class="status <?= $trx->status_bayar ?? 'UNPAID'; ?>">
              <i class="fa-solid <?= ($trx->status_bayar ?? 'UNPAID')==='PAID'?'fa-check-circle':'fa-clock'; ?>"></i>
              <?= $trx->status_bayar ?? 'UNPAID'; ?>
            </span>
          </td>
        </tr>
      </tfoot>
    </table>

    <?php if(($trx->metode ?? '')==='QRIS' && ($trx->status_bayar ?? '')==='UNPAID'): ?>
      <div style="margin-top:12px;text-align:center">
        <small>Silakan scan QRIS di bawah ini lalu tekan <b>"Tandai Lunas"</b>.</small><br>
        <img src="<?= base_url('assets/img/qr.png'); ?>" alt="QRIS"
             style="width:200px;height:auto;border:1px solid #e5e7eb;border-radius:8px;margin-top:8px">
      </div>

      <div class="actions">
        <form method="post" action="<?= site_url('order/mark_paid/'.($trx->pesanan_id ?? $trx->id ?? 0)); ?>">
          <button class="btn btn-primary" type="submit"><i class="fa-solid fa-check"></i> Tandai Lunas</button>
        </form>
        <button class="btn btn-secondary" type="button" onclick="window.print()">
          <i class="fa-solid fa-print"></i> Print
        </button>
      </div>

    <?php else: ?>
      <div class="actions">
        <form method="post" action="<?= site_url('order/done/'.($trx->pesanan_id ?? $trx->id ?? 0)); ?>">
          <button class="btn btn-primary" type="submit"><i class="fa-solid fa-check"></i> Tandai Selesai</button>
        </form>
        <button class="btn btn-secondary" type="button" onclick="window.print()">
          <i class="fa-solid fa-print"></i> Print
        </button>
      </div>
    <?php endif; ?>

  <?php endif; ?>

  <footer>Terima kasih telah menggunakan layanan Laundry Azzahra 🙏</footer>
</div>

</body>
</html>