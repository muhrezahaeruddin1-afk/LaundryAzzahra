<!doctype html><html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Pemesanan Baru</title>
<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
<style>
.form{max-width:900px;margin:20px auto;background:#fff;padding:16px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.06)}
.form h2{margin:0 0 12px}
.row{display:grid;gap:10px;grid-template-columns:1fr 1fr}
label{font-size:14px;font-weight:600}
input,select,textarea{width:100%;padding:8px 10px;border:1px solid #e5e7eb;border-radius:10px}
.table{width:100%;border-collapse:separate;border-spacing:0 8px}
.table th,.table td{padding:8px 10px;background:#fff}
.btn{background:var(--brand-green,#059669);color:#fff;border:none;padding:10px 16px;border-radius:10px;cursor:pointer}
.badge{background:rgba(249,200,38,.18);padding:3px 8px;border-radius:999px}
.hint{font-size:12px;color:#667085}
.hidden{display:none}
</style>
</head><body>

<button class="back-btn" onclick="history.back()">← Back</button>

<div class="form">
  <h2>Pemesanan Baru <span class="badge">Demo</span></h2>

  <form method="post" action="<?php echo site_url('order/create'); ?>">

    <!-- PILIH PELANGGAN LAMA -->
    <label>Pilih Pelanggan Lama (opsional)</label>
    <select name="pelanggan_id" id="pelangganSelect">
      <option value="">-- Pilih (atau isi pelanggan baru di bawah) --</option>
      <?php foreach($pelanggan as $pl): ?>
        <option value="<?= $pl->id; ?>"><?= htmlentities($pl->nama); ?> - <?= htmlentities($pl->telp); ?></option>
      <?php endforeach; ?>
    </select>
    <div class="hint" style="margin-top:4px">Jika memilih di sini, bagian "Pelanggan Baru" di bawah tidak perlu diisi.</div>

    <!-- FORM PELANGGAN BARU -->
    <div id="formBaru" style="margin-top:12px">
      <div class="row">
        <div>
          <label>Nama Pelanggan (baru)</label>
          <input type="text" name="nama">
        </div>
        <div>
          <label>No. Telp</label>
          <input type="text" name="telp">
        </div>
      </div>
      <label>Alamat</label>
      <textarea name="alamat"></textarea>
    </div>

    <!-- OPSI BERAT & EXPRESS -->
    <div class="row" style="margin-top:10px">
      <div>
        <label>Berat (Kg, opsional)</label>
        <input type="number" name="berat_kg" step="0.1" min="0">
      </div>
      <div style="display:flex;align-items:end;gap:8px">
        <label><input type="checkbox" name="express" value="1"> Tambah Express (+Rp5.000)</label>
      </div>
    </div>

    <!-- ITEM LAYANAN -->
    <label style="margin-top:10px;display:block">Item Layanan</label>
    <table class="table">
      <thead><tr><th>Layanan</th><th>Qty (Kg/Pcs)</th></tr></thead>
      <tbody id="items">
        <tr>
          <td>
            <select name="layanan_id[]">
              <?php foreach($layanan as $l): ?>
                <option value="<?= $l->id; ?>">
                  <?= htmlentities($l->nama); ?> (<?= $l->tipe_satuan; ?>) - Rp <?= number_format($l->harga_per_satuan,0,',','.'); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </td>
          <td><input type="number" name="qty[]" step="0.1" value="1" min="0.1"></td>
        </tr>
      </tbody>
    </table>

    <button type="button" class="btn" onclick="addRow()">+ Tambah Item</button>

    <!-- PEMBAYARAN & CATATAN -->
    <div style="margin-top:14px" class="row">
      <div>
        <label>Metode Pembayaran</label>
        <select name="metode">
          <option value="CASH">CASH</option>
          <option value="QRIS">QRIS</option>
        </select>
      </div>
      <div>
        <label>Catatan</label>
        <input type="text" name="catatan">
      </div>
    </div>

    <div style="margin-top:16px">
      <button type="submit" class="btn">Simpan & Buat Transaksi</button>
    </div>
  </form>
</div>

<script>
// tambah baris item layanan
function addRow(){
  const row = document.querySelector('#items tr').cloneNode(true);
  row.querySelector('input[name="qty[]"]').value = 1;
  document.querySelector('#items').appendChild(row);
}

// sembunyikan form pelanggan baru kalau pilih pelanggan lama
const select = document.getElementById('pelangganSelect');
const formBaru = document.getElementById('formBaru');
select.addEventListener('change', () => {
  formBaru.classList.toggle('hidden', !!select.value);
});
</script>
</body></html>
