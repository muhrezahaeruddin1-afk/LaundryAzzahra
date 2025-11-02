<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Dashboard - <?php echo $nama_mitra; ?></title>
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>

  <!-- Tombol Back tetap di luar padding -->
  <button class="back-btn" title="Kembali" onclick="history.back()">&#8592; Back</button>

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
            <div class="num"><?php echo isset($kpi_masuk) ? (int)$kpi_masuk : 0; ?></div>
          </div>
          <div class="kpi">
            <div class="label">Proses</div>
            <div class="num"><?php echo isset($kpi_proses) ? (int)$kpi_proses : 0; ?></div>
          </div>
          <div class="kpi">
            <div class="label">Selesai</div>
            <div class="num"><?php echo isset($kpi_selesai) ? (int)$kpi_selesai : 0; ?></div>
          </div>
          <div class="kpi">
            <div class="label">Pendapatan (hari ini)</div>
            <div class="num">Rp <?php echo number_format(isset($kpi_pendapatan)?$kpi_pendapatan:0,0,',','.'); ?></div>
          </div>
        </div>
      </div>


      <!-- Kartu Daftar Harga ringkas -->
      <div class="card">
        <h3>Daftar Harga (ringkas)</h3>
        <div style="display:grid;gap:8px">
          <?php foreach ($daftar_harga as $item): ?>
            <div class="price-item">
              <div>
                <div class="name"><?php echo htmlentities($item['nama']); ?></div>
                <div class="unit"><?php echo htmlentities($item['satuan']); ?></div>
              </div>
              <div class="amt"><?php echo $item['harga']; ?></div>
            </div>
          <?php endforeach; ?>
        </div>
        <small style="color:#667085">*Harga lengkap dikelola di menu “Layanan &amp; Harga”.</small>
      </div>

      <!-- Kartu info cepat -->
      <div class="card">
        <h3>Informasi Toko</h3>
        <p>Buka setiap hari. Minimal cuci 3 Kg (sesuai banner). Tersedia layanan Express.</p>
      </div>

    </div>
  </main>

  <footer class="footer">
    &copy; <?php echo date('Y'); ?> <?php echo $nama_mitra; ?> • Sistem Informasi Laundry
  </footer>

  <script src="<?php echo base_url('assets/js/app.js'); ?>"></script>
</body>
</html>
