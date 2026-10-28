<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Pemesanan Baru</title>

<!-- Font & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root{
  --brand:#06b6d4; --brand-2:#14b8a6; --ink:#1f2937; --muted:#6b7280;
  --line:#e5e7eb; --card:#fff; --shadow:0 8px 24px rgba(0,0,0,.06); --radius:12px;
  --sidebar-bg:#06b6d4;
}

*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Poppins',sans-serif;background:#f9fafb;color:var(--ink)}

.form{
  max-width:100%;margin:0;background:var(--card);padding:24px;border-radius:0;
  box-shadow:none;min-height:100vh
}
.form h2{margin:0 0 12px;font-weight:700;display:flex;align-items:center;gap:10px}
.form h2 .badge{
  background:rgba(249,200,38,.18);padding:4px 8px;border-radius:999px;font-size:12px;font-weight:500
}
.section-title{margin:20px 0 12px;font-weight:600;color:#0891b2;display:flex;align-items:center;gap:8px;font-size:15px}
.section-title i{color:#06b6d4}

/* grid */
.row{display:grid;gap:12px;grid-template-columns:1fr 1fr}
@media (max-width:720px){ .row{grid-template-columns:1fr} }

/* fields */
label{font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px}
input,select,textarea{
  width:100%;padding:10px 12px;border:1px solid var(--line);border-radius:10px;background:#fff;font-size:14px
}
input:focus,select:focus,textarea:focus{outline:2px solid rgba(6,182,212,.35);outline-offset:2px}

/* hint & error */
.hint{font-size:12px;color:#667085;margin-top:4px}
.alert{
  border:1px solid #fecaca;background:#fee2e2;color:#b91c1c;padding:10px;border-radius:10px;margin-bottom:12px
}

/* service table */
.table{width:100%;border-collapse:separate;border-spacing:0 8px;margin-top:8px}
.table th{
  text-align:left;font-size:13px;color:#0e7490;background:linear-gradient(135deg, #cffafe 0%, #ccfbf1 100%);border-bottom:2px solid #a5f3fc;
  padding:10px;font-weight:600
}
.table th:first-child{border-radius:10px 0 0 10px}
.table th:last-child{border-radius:0 10px 10px 0}
.table td{padding:10px;background:#fff;border:1px solid var(--line)}
.table tr td:first-child{border-radius:10px 0 0 10px}
.table tr td:last-child{border-radius:0 10px 10px 0}

/* buttons */
.btn{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg, #06b6d4 0%, #14b8a6 100%);color:#fff;border:none;
  padding:11px 18px;border-radius:10px;cursor:pointer;font-weight:600;text-decoration:none;font-size:14px}
.btn:hover{opacity:.9;transform:translateY(-1px);transition:all .2s}
.btn-secondary{background:linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%)}
.btn-ghost{background:#fff;border:1px solid var(--line);color:#111827}
.btn-ghost:hover{background:#f9fafb}
.btn-danger{background:#ef4444}
.btn-icon{width:36px;height:36px;padding:0;display:inline-flex;align-items:center;justify-content:center;border-radius:10px}

/* button group */
.button-group{display:flex;gap:10px;margin-top:24px;flex-wrap:wrap}

/* util */
.hidden{display:none}
.error{color:#ef4444;font-size:13px;margin-top:4px}
.flex{display:flex;align-items:center;gap:10px}
.text-right{text-align:right}
.mt-8{margin-top:8px} .mt-12{margin-top:12px} .mt-16{margin-top:16px}

/* Responsive */
@media (max-width:768px){
  body{padding:10px}
  .button-group{flex-direction:column}
  .button-group .btn{width:100%}
}
</style>
</head>
<body>

<div class="form">
      <h2>
        <i class="fa-solid fa-file-circle-plus" style="color:#06b6d4"></i>
        Pemesanan Baru 
      </h2>

      <!-- error CI -->
      <?php if (validation_errors()): ?>
        <div class="alert"><?= validation_errors(); ?></div>
      <?php endif; ?>
      <?php if (!empty($error_manual)): ?>
        <div class="alert"><?= $error_manual; ?></div>
      <?php endif; ?>

      <form method="post" action="<?= site_url('order/create'); ?>">

        <!-- PELANGGAN -->
        <div class="section-title"><i class="fa-solid fa-user"></i> Data Pelanggan</div>
        <label for="pelangganSelect">Pilih Pelanggan Lama (opsional)</label>
        <select name="pelanggan_id" id="pelangganSelect">
          <option value="">— Pilih (atau isi pelanggan baru di bawah) —</option>
          <?php foreach($pelanggan as $pl): ?>
            <option value="<?= $pl->id; ?>"><?= htmlentities($pl->nama); ?> - <?= htmlentities($pl->telp); ?></option>
          <?php endforeach; ?>
        </select>
        <div class="hint">Jika memilih di sini, bagian "Pelanggan Baru" di bawah tidak perlu diisi.</div>

        <div id="formBaru" class="mt-12">
          <div class="row">
            <div>
              <label>Nama Pelanggan (baru)</label>
              <input type="text" name="nama" id="namaBaru" placeholder="cth: Budi Hartono">
            </div>
            <div>
              <label>No. Telp</label>
              <input type="text" name="telp" id="telpBaru" placeholder="cth: 0812xxxxxxx">
            </div>
          </div>
          <label class="mt-8">Alamat</label>
          <textarea name="alamat" id="alamatBaru" rows="2" placeholder="Alamat lengkap (opsional)"></textarea>
        </div>

        <!-- OPSI -->
        <div class="section-title mt-16"><i class="fa-solid fa-sliders"></i> Opsi</div>
        <div class="row">
          <div>
            <label>&nbsp;</label>
            <label class="flex" style="padding:10px 12px;border:1px solid var(--line);border-radius:10px;cursor:pointer">
              <input type="checkbox" name="express" value="1"> Tambah Express (+Rp5.000)
            </label>
          </div>
        </div>

        <!-- ITEM LAYANAN -->
        <div class="section-title mt-16"><i class="fa-solid fa-basket-shopping"></i> Item Layanan</div>
        <table class="table">
          <thead>
            <tr>
              <th style="width:68%">Layanan</th>
              <th style="width:20%">Qty (Kg/Pcs)</th>
              <th style="width:12%">Aksi</th>
            </tr>
          </thead>
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
              <td class="text-right">
                <button type="button" class="btn btn-ghost btn-icon" disabled title="Baris pertama">
                  <i class="fa-solid fa-minus"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <button type="button" class="btn mt-8" id="btnAddRow"><i class="fa-solid fa-plus"></i> Tambah Item</button>

        <!-- ESTIMASI & PENERIMAAN -->
        <div class="section-title mt-16"><i class="fa-solid fa-calendar-check"></i> Estimasi & Penerimaan</div>
        <div class="row">
          <div>
            <label>Estimasi Selesai (jam)*</label>
            <input type="number" name="estimasi_selesai_jam" id="estimasi" min="1" required placeholder="cth: 24">
          </div>
          <div>
            <label>Cara Terima Hasil*</label>
            <select name="metode_terima" id="metode_terima" required>
              <option value="ambil_sendiri">Ambil sendiri (GRATIS)</option>
              <option value="antar">Antar ke alamat</option>
            </select>
          </div>
        </div>

        <div id="blok_jarak" class="mt-8 hidden">
          <label>Jarak (KM)*</label>
          <input type="number" step="0.1" name="jarak_km" id="jarak_km" min="0.1" placeholder="cth: 2.5">
          <div class="hint">Biaya antar Rp 5.000 / km (dibulatkan ke atas)</div>
        </div>

        <!-- PEMBAYARAN & CATATAN -->
        <div class="section-title mt-16"><i class="fa-solid fa-wallet"></i> Pembayaran</div>
        <div class="row">
          <div>
            <label>Metode Pembayaran</label>
            <select name="metode">
              <option value="CASH">CASH</option>
              <option value="QRIS">QRIS</option>
            </select>
          </div>
          <div>
            <label>Catatan</label>
            <input type="text" name="catatan" placeholder="Opsional">
          </div>
        </div>

        <div class="button-group">
          <button type="submit" class="btn btn-secondary">
            <i class="fa-solid fa-save"></i> Simpan & Buat Transaksi
          </button>
          <button type="button" class="btn btn-ghost" onclick="history.back()">
            <i class="fa-solid fa-times"></i> Batal
          </button>
        </div>
      </form>
    </div>
  </div>
</main>

<script>
// ===== Tambah/Hapus baris item layanan =====
const tbody = document.getElementById('items');
document.getElementById('btnAddRow').addEventListener('click', () => {
  const tr = document.createElement('tr');
  tr.innerHTML = `
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
    <td class="text-right">
      <button type="button" class="btn btn-danger btn-icon btn-remove" title="Hapus baris">
        <i class="fa-solid fa-trash"></i>
      </button>
    </td>`;
  tbody.appendChild(tr);
});

tbody.addEventListener('click', (e) => {
  if(e.target.closest('.btn-remove')){
    const tr = e.target.closest('tr');
    tr.parentNode.removeChild(tr);
  }
});

// ===== Sembunyikan form pelanggan baru ketika pilih pelanggan lama =====
const selectPelanggan = document.getElementById('pelangganSelect');
const formBaru = document.getElementById('formBaru');
const namaBaru = document.getElementById('namaBaru');
const telpBaru = document.getElementById('telpBaru');

function togglePelangganBaru(){
  const pakaiLama = !!selectPelanggan.value;
  formBaru.classList.toggle('hidden', pakaiLama);
  // toggle required agar validasi HTML5 nyaman:
  [namaBaru, telpBaru].forEach(el => pakaiLama ? el.removeAttribute('required') : el.setAttribute('required','required'));
}
selectPelanggan.addEventListener('change', togglePelangganBaru);
togglePelangganBaru(); // initial

// ===== Tampilkan kolom jarak ketika pilih "antar" =====
const metodeTerima = document.getElementById('metode_terima');
const blokJarak = document.getElementById('blok_jarak');
const jarakInput = document.getElementById('jarak_km');

function toggleJarak(){
  const antar = (metodeTerima.value === 'antar');
  blokJarak.classList.toggle('hidden', !antar);
  if(antar){ jarakInput.setAttribute('required','required'); }
  else{ jarakInput.removeAttribute('required'); jarakInput.value = ''; }
}
metodeTerima.addEventListener('change', toggleJarak);
toggleJarak(); // initial
</script>

</body>
</html>