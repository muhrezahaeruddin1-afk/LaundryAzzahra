<!doctype html><html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= $mode==='create'?'Tambah':'Edit'; ?> Layanan</title>
<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
<style>
.wrap{max-width:700px;margin:20px auto;padding:0 16px}
.card{background:#fff;border-radius:12px;padding:16px;box-shadow:0 10px 30px rgba(0,0,0,.06)}
label{font-weight:600;font-size:14px}
input,select{width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:10px}
.row{display:grid;gap:12px;grid-template-columns:1fr 1fr}
.btn{background:var(--brand-green,#059669);color:#fff;border:none;padding:10px 16px;border-radius:10px;cursor:pointer}
.btn-outline{border:1px solid #e5e7eb;background:#fff;margin-left:8px}
</style>
</head><body>

<button class="back-btn" onclick="history.back()">← Back</button>

<div class="wrap">
  <h2><?= $mode==='create'?'Tambah':'Edit'; ?> Layanan</h2>
  <div class="card">
    <form method="post"
      action="<?= $mode==='create'
              ? site_url('layanan/store')
              : site_url('layanan/update/'.$data->id); ?>">

      <label>Nama Layanan</label>
      <input type="text" name="nama" value="<?= htmlentities($data->nama); ?>" required>

      <div class="row" style="margin-top:10px">
        <div>
          <label>Satuan</label>
          <select name="tipe_satuan">
            <option value="KG"  <?= $data->tipe_satuan==='KG'?'selected':''; ?>>KG</option>
            <option value="PCS" <?= $data->tipe_satuan==='PCS'?'selected':''; ?>>PCS</option>
          </select>
        </div>
        <div>
          <label>Harga per Satuan</label>
          <input type="number" name="harga_per_satuan" min="0" step="100"
                 value="<?= (int)$data->harga_per_satuan; ?>" required>
        </div>
      </div>

      <label style="margin-top:10px">
        <input type="checkbox" name="aktif" value="1" <?= $data->aktif? 'checked':''; ?>> Aktif
      </label>

      <div style="margin-top:14px">
        <button class="btn" type="submit">Simpan</button>
        <a class="btn-outline" href="<?= site_url('layanan'); ?>">Batal</a>
      </div>
    </form>
  </div>
</div>
</body></html>
