<!doctype html><html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= $mode==='create'?'Tambah':'Edit'; ?> Pelanggan</title>
<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
<style>
.wrap{max-width:700px;margin:20px auto;padding:0 16px}
.card{background:#fff;border-radius:12px;padding:16px;box-shadow:0 10px 30px rgba(0,0,0,.06)}
label{font-weight:600;font-size:14px}
input,textarea{width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:10px}
.btn{background:var(--brand-green,#059669);color:#fff;border:none;padding:10px 16px;border-radius:10px;cursor:pointer}
.btn-outline{border:1px solid #e5e7eb;background:#fff;margin-left:8px}
</style>
</head><body>

<button class="back-btn" onclick="history.back()">← Back</button>

<div class="wrap">
  <h2><?= $mode==='create'?'Tambah':'Edit'; ?> Pelanggan</h2>
  <div class="card">
    <form method="post"
      action="<?= $mode==='create' ? site_url('pelanggan/store')
                                    : site_url('pelanggan/update/'.$data->id); ?>">
      <label>Nama</label>
      <input type="text" name="nama" value="<?= htmlentities($data->nama); ?>" required>

      <label style="margin-top:10px">No. Telp</label>
      <input type="text" name="telp" value="<?= htmlentities($data->telp); ?>">

      <label style="margin-top:10px">Alamat</label>
      <textarea name="alamat"><?= htmlentities($data->alamat); ?></textarea>

      <div style="margin-top:14px">
        <button class="btn" type="submit">Simpan</button>
        <a class="btn-outline" href="<?= site_url('pelanggan'); ?>">Batal</a>
      </div>
    </form>
  </div>
</div>
</body></html>
