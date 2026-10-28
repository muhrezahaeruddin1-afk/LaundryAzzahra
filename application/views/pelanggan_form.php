<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= $mode==='create'?'Tambah':'Edit'; ?> Pelanggan</title>

<!-- Font & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root{
  --brand:#06b6d4; --brand-2:#14b8a6; --ink:#1f2937; --muted:#6b7280;
  --line:#e5e7eb; --card:#fff; --shadow:0 8px 24px rgba(0,0,0,.06); --radius:12px;
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

/* buttons */
.btn{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg, #06b6d4 0%, #14b8a6 100%);color:#fff;border:none;
  padding:11px 18px;border-radius:10px;cursor:pointer;font-weight:600;text-decoration:none;font-size:14px}
.btn:hover{opacity:.9;transform:translateY(-1px);transition:all .2s}
.btn-secondary{background:linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%)}
.btn-ghost{background:#fff;border:1px solid var(--line);color:#111827}
.btn-ghost:hover{background:#f9fafb}
.btn-danger{background:#ef4444}

/* button group */
.button-group{display:flex;gap:10px;margin-top:24px;flex-wrap:wrap}

/* util */
.hidden{display:none}
.error{color:#ef4444;font-size:13px;margin-top:4px}
.flex{display:flex;align-items:center;gap:10px}
.mt-8{margin-top:8px} .mt-12{margin-top:12px} .mt-16{margin-top:16px}

/* Responsive */
@media (max-width:768px){
  .button-group{flex-direction:column}
  .button-group .btn{width:100%}
  .form{padding:16px}
}
</style>
</head>
<body>

<div class="form">
  <h2>
    <i class="fa-solid fa-user-<?= $mode==='create'?'plus':'edit'; ?>" style="color:#06b6d4"></i>
    <?= $mode==='create'?'Tambah':'Edit'; ?> Pelanggan
  </h2>

  <!-- error CI -->
  <?php if (validation_errors()): ?>
    <div class="alert"><?= validation_errors(); ?></div>
  <?php endif; ?>

  <form method="post" action="<?= $mode==='create' ? site_url('pelanggan/store') : site_url('pelanggan/update/'.$data->id); ?>">

    <!-- DATA PELANGGAN -->
    <div class="section-title"><i class="fa-solid fa-user"></i> Data Pelanggan</div>
    
    <div class="row">
      <div>
        <label for="nama">Nama*</label>
        <input type="text" id="nama" name="nama" value="<?= htmlentities($data->nama ?? ''); ?>" required placeholder="Masukkan nama pelanggan">
      </div>
      <div>
        <label for="telp">No. Telp*</label>
        <input type="text" id="telp" name="telp" value="<?= htmlentities($data->telp ?? ''); ?>" required placeholder="cth: 0812xxxxxxx">
      </div>
    </div>

    <div class="mt-12">
      <label for="alamat">Alamat</label>
      <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap (opsional)"><?= htmlentities($data->alamat ?? ''); ?></textarea>
      <div class="hint">Alamat pelanggan untuk keperluan pengiriman</div>
    </div>

    <div class="button-group">
      <button type="submit" class="btn btn-secondary">
        <i class="fa-solid fa-save"></i> Simpan
      </button>
      <a href="<?= site_url('pelanggan'); ?>" class="btn btn-ghost">
        <i class="fa-solid fa-times"></i> Batal
      </a>
    </div>
  </form>
</div>

</body>
</html>