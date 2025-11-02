<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Dashboard - <?php echo $nama_mitra; ?></title>
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
  <style>
    /* Foto toko */
    .store-photo{margin-top:10px}
    .store-photo img{
      width:100%; max-height:220px; object-fit:cover;
      border-radius:12px; border:1px solid #e5e7eb; box-shadow:0 6px 20px rgba(0,0,0,.06);
      display:block;
    }
    .store-photo small{display:block;color:#64748b;margin-top:6px}
    /* Galeri dokumentasi status (4 kotak) */
    .status-gallery{margin-top:12px; display:grid; grid-template-columns:repeat(4,1fr); gap:8px}
    .status-gallery img{
      width:100%; aspect-ratio:1/1; object-fit:cover;
      border-radius:10px; border:1px solid #e5e7eb; box-shadow:0 4px 14px rgba(0,0,0,.05);
    }
    @media (max-width: 720px){ .status-gallery{ grid-template-columns:repeat(2,1fr) } }
    /* kecil: tombol util */
    .btn-ghost{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:8px 10px;font-weight:700;cursor:pointer;box-shadow:0 6px 16px rgba(0,0,0,.06)}
    .btn-ghost:hover{filter:brightness(1.03);transform:translateY(-1px);transition:.15s}
  </style>
</head>
<body>

<?php
  // cari foto toko
  $foto_rel = null;
  foreach (['assets/img/toko.jpg','img/toko.jpg'] as $p) {
    if (is_file(FCPATH.$p)) { $foto_rel = $p; break; }
  }
  // cari 4 foto dokumentasi
  $status_photos = [];
  for ($i=1; $i<=4; $i++) {
    $rel = "assets/img/status-$i.jpg";
    if (is_file(FCPATH.$rel)) $status_photos[] = $rel;
  }
?>

  <!-- Tombol Back -->
  <button class="back-btn" title="Kembali">&#8592; Back</button>

  <!-- Header/Brand -->
  <header class="hero">
    <div class="wrap" style="display:flex;align-items:center;gap:16px">
      <div class="brand-circle" aria-label="Logo Laundry Azzahra">
        <?php if (file_exists(FCPATH.'assets/img/azzahra-logo.png')): ?>
          <img src="<?php echo base_url('assets/img/azzahra-logo.png'); ?>" alt="Logo Laundry Azzahra">
        <?php else: ?>
          <div style="display:grid;place-items:center;width:100%;height:100%;font-weight:800;color:#134e1f;">AZ</div>
        <?php endif; ?>
      </div>

      <div>
        <h1 style="margin:0;font-size:28px;line-height:1.2"><?php echo $nama_mitra; ?></h1>
        <p style="margin:4px 0 0;opacity:.95"><?php echo $alamat; ?></p>

        <!-- Navigasi cepat -->
        <div class="quicknav">
          <a href="<?php echo site_url('pelanggan'); ?>">Pelanggan</a>
          <a href="<?php echo site_url('order/baru'); ?>">Pesanan</a>
          <a href="<?php echo site_url('pesanan'); ?>">Daftar Pesanan</a>
          <a href="<?php echo site_url('layanan'); ?>">Layanan &amp; Harga</a>
          <a href="<?php echo site_url('laporan/harian'); ?>">Laporan</a>
        </div>
      </div>
    </div>
  </header>

  <!-- Konten -->
  <main class="container">
    <div class="grid">

      <!-- Kartu KPI status -->
      <div class="card">
        <h3>Status Pesanan <span class="badge">Realtime</span></h3>
        <div class="kpis">
          <div class="kpi">
            <div class="label">Masuk</div>
            <!-- ✅ beri ID -->
            <div class="num" id="kpi-masuk"><?php echo isset($kpi_masuk) ? (int)$kpi_masuk : 0; ?></div>
          </div>
          <div class="kpi">
            <div class="label">Proses</div>
            <div class="num" id="kpi-proses"><?php echo isset($kpi_proses) ? (int)$kpi_proses : 0; ?></div>
          </div>
          <div class="kpi">
            <div class="label">Selesai</div>
            <div class="num" id="kpi-selesai"><?php echo isset($kpi_selesai) ? (int)$kpi_selesai : 0; ?></div>
          </div>
          <div class="kpi">
            <div class="label">Pendapatan (hari ini)</div>
            <div class="num" id="kpi-pendapatan">Rp <?php echo number_format(isset($kpi_pendapatan)?$kpi_pendapatan:0,0,',','.'); ?></div>
          </div>
        </div>

        <?php if (count($status_photos) > 0): ?>
          <div style="font-weight:600;margin-top:10px">Dokumentasi</div>
          <div class="status-gallery">
            <?php foreach ($status_photos as $p): ?>
              <img src="<?= base_url($p); ?>" alt="Dokumentasi Laundry" loading="lazy">
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Kartu Daftar Harga ringkas -->
      <div class="card">
        <h3>Daftar Harga</h3>

        <!-- 🔎 Search -->
        <input type="search" id="search-layanan" placeholder="Cari layanan…" style="width:100%;margin:6px 0 10px;padding:8px 10px;border:1px solid #e5e7eb;border-radius:10px">

        <div id="list-harga" style="display:grid;gap:8px">
          <?php foreach ($daftar_harga as $item): ?>
            <div class="price-item"
                 data-name="<?= htmlentities($item['nama']); ?>"
                 data-price="<?= preg_replace('/[^0-9]/','',$item['harga']); ?>">
              <div>
                <div class="name"><?php echo htmlentities($item['nama']); ?></div>
                <div class="unit"><?php echo htmlentities($item['satuan']); ?></div>
              </div>
              <div class="amt"><?php echo $item['harga']; ?></div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- sort & export -->
        <div style="display:flex;gap:8px;margin-top:10px;flex-wrap:wrap">
          <button id="sort-asc"  class="btn-ghost">Harga Termurah</button>
          <button id="sort-desc" class="btn-ghost">Harga Termahal</button>
          <button id="export-csv" class="btn-ghost">Export CSV</button>
        </div>

        <small style="color:#667085">*Harga lengkap dikelola di menu.</small>
      </div>

      <!-- Kartu info cepat -->
      <div class="card">
        <h3>Informasi Toko</h3>
        <p>
          Laundry Azzahra buka setiap hari pukul <strong>08.00 - 21.00</strong><br>
          📍 Alamat: Jl. Manuruki 2 No. 79, Makassar<br>
          ☎️ Telp/WA: 0822-9678-5430<br>
          📌 Antar-Jemput: Rp 5.000/km<br>
          💳 Pembayaran: Cash / QRIS<br>
          ✨ “Bersih, Wangi, dan Tepat Waktu!”
        </p>

        <a id="btn-maps" href="https://maps.app.goo.gl/PrNjMd2uxgYLGHzc7" target="_blank"
           style="display:inline-block;margin-top:6px;background:#16a34a;color:#fff;padding:6px 10px;border-radius:8px;text-decoration:none">
          📍 Lihat Lokasi di Google Maps
        </a>

        <!-- FOTO TOKO -->
        <?php if ($foto_rel): ?>
          <div class="store-photo">
            <img src="<?php echo base_url($foto_rel); ?>" alt="Foto Toko Laundry Azzahra" loading="lazy">
            <small>Tampilan depan Laundry Azzahra</small>
          </div>
        <?php else: ?>
          <div class="store-photo" style="color:#ef4444">
            <small>Foto toko belum ditemukan. Simpan di <code>assets/img/toko.jpg</code>.</small>
          </div>
        <?php endif; ?>
      </div> <!-- /card Informasi Toko -->

    </div> <!-- /grid -->
  </main>

  <footer class="footer">
    &copy; <?php echo date('Y'); ?> <?php echo $nama_mitra; ?> • Sistem Informasi Laundry
  </footer>

  <!-- ⬇️ taruh script di bawah sekali, cukup SEKALI -->
  <script>
    window.APP_BASE  = "<?= rtrim(base_url(), '/'); ?>";
    window.API_STATS = "<?= site_url('api/dashboard/stats'); ?>";
  </script>
  <script src="<?= base_url('assets/js/app.js'); ?>?v=<?= time(); ?>"></script>
</body>
</html>
