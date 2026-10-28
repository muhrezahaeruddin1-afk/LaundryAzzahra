<?php
$active = strtolower($this->uri->segment(1) ?? 'dashboard');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Daftar Pesanan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS AdminLTE & FontAwesome -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">

  <!-- CSS Kustom -->
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css?v=').filemtime(FCPATH.'assets/css/custom.css'); ?>">
  
  <style>
    .status-badge {
      padding: 5px 12px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      text-transform: uppercase;
    }
    .status-MASUK { background: #fef9c3; color: #92400e; }
    .status-PROSES { background: #dbeafe; color: #1e3a8a; }
    .status-SELESAI { background: #dcfce7; color: #166534; }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<!-- Topbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">Admin</li>
  </ul>
</nav>

<!-- Sidebar kiri -->
<aside class="main-sidebar elevation-4 sidebar-dark-primary">
  <a href="<?= site_url('dashboard');?>" class="brand-link">
    <img src="<?= base_url('assets/img/logo.png');?>" 
         class="brand-image img-circle elevation-3" 
         style="opacity:.95; width:32px; height:32px; object-fit:cover;">
    <span class="brand-text font-weight-semibold">Azzahra Laundry</span>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">

        <li class="nav-item">
          <a href="<?= site_url('dashboard');?>" class="nav-link <?= ($active == 'dashboard') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-home"></i><p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= site_url('layanan');?>" class="nav-link <?= ($active == 'layanan') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-tags"></i><p>Layanan & Harga</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= site_url('pelanggan');?>" class="nav-link <?= ($active == 'pelanggan') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-users"></i><p>Pelanggan</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= site_url('pesanan');?>" class="nav-link <?= ($active == 'pesanan') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-receipt"></i><p>Pesanan</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= site_url('laporan');?>" class="nav-link <?= ($active == 'laporan') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-chart-line"></i><p>Laporan</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= site_url('admin');?>" class="nav-link <?= ($active == 'admin') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-user-cog"></i><p>Manajemen Admin</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= site_url('auth/logout'); ?>" class="nav-link" onclick="return confirm('Yakin ingin logout?')" 
            style="color:#dc3545; border-top:1px solid #444; padding-top:15px;">
            <i class="fas fa-sign-out-alt"></i><p>Logout</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>

<!-- Konten -->
<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">

<!-- Content Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Daftar Pesanan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Pesanan</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title font-weight-semibold">Data Pesanan Laundry</h3>
            <div class="card-tools">
              <!-- Filter Status -->
              <form method="get" style="display: inline-block; margin-right: 10px;">
                <?php $now = isset($status_now) ? $status_now : 'ALL'; ?>
                <select name="status" class="form-control form-control-sm" onchange="this.form.submit()" style="width: 150px; display: inline-block;">
                  <option value="ALL" <?= $now==='ALL'?'selected':''; ?>>Semua Status</option>
                  <option value="MASUK" <?= $now==='MASUK'?'selected':''; ?>>MASUK</option>
                  <option value="PROSES" <?= $now==='PROSES'?'selected':''; ?>>PROSES</option>
                  <option value="SELESAI" <?= $now==='SELESAI'?'selected':''; ?>>SELESAI</option>
                </select>
              </form>
              
              <a href="<?= site_url('order/baru'); ?>" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Pesanan Baru
              </a>
            </div>
          </div>
          
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead style="background-color: #f8f9fa;">
                  <tr>
                    <th style="width: 50px" class="text-center">No.</th>
                    <th style="width: 120px">Kode</th>
                    <th>Pelanggan</th>
                    <th style="width: 140px">Tanggal Masuk</th>
                    <th style="width: 120px">Status</th>
                    <th style="width: 100px">Metode</th>
                    <th class="text-right" style="width: 120px">Total</th>
                    <th class="text-center" style="width: 160px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($pesanan)): 
                    $no = 1; // Inisialisasi nomor urut
                    foreach ($pesanan as $p): ?>
                    <tr>
                      <td class="text-center"><strong><?= $no++; ?></strong></td>
                      <td><strong><?= $p->kode; ?></strong></td>
                      <td><?= $p->nama_pelanggan ?: '-'; ?></td>
                      <td><?= date('d/m/Y H:i', strtotime($p->tanggal_masuk)); ?></td>
                      
                      <td>
                        <span class="status-badge status-<?= $p->status; ?>">
                          <?php if ($p->status === 'MASUK'): ?>
                            <i class="fas fa-inbox"></i>
                          <?php elseif ($p->status === 'PROSES'): ?>
                            <i class="fas fa-spinner"></i>
                          <?php elseif ($p->status === 'SELESAI'): ?>
                            <i class="fas fa-check-circle"></i>
                          <?php endif; ?>
                          <?= strtoupper($p->status); ?>
                        </span>
                      </td>

                      <td>
                        <?php if ($p->metode === 'CASH'): ?>
                          <i class="fas fa-money-bill-wave text-success"></i> CASH
                        <?php elseif ($p->metode === 'QRIS'): ?>
                          <i class="fas fa-qrcode text-info"></i> QRIS
                        <?php elseif ($p->metode === 'TRANSFER'): ?>
                          <i class="fas fa-university text-primary"></i> TRANSFER
                        <?php else: ?>
                          -
                        <?php endif; ?>
                      </td>

                      <td class="text-right"><strong>Rp <?= number_format((int)$p->grand_total, 0, ',', '.'); ?></strong></td>

                      <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                          <a href="<?= site_url('order/receipt/'.$p->id); ?>" 
                             class="btn btn-success" title="Cetak Struk">
                            <i class="fas fa-print"></i>
                          </a>

                          <?php if ($p->status !== 'SELESAI'): ?>
                            <a href="<?= site_url('pesanan/ubah_status/'.$p->id.'?status=PROSES'); ?>" 
                               class="btn btn-primary" title="Ubah ke Proses">
                              <i class="fas fa-sync"></i>
                            </a>
                            <a href="<?= site_url('pesanan/ubah_status/'.$p->id.'?status=SELESAI'); ?>" 
                               class="btn btn-info" title="Tandai Selesai">
                              <i class="fas fa-check"></i>
                            </a>
                          <?php endif; ?>

                          <a href="<?= site_url('pesanan/hapus/'.$p->id); ?>" 
                             class="btn btn-danger" title="Hapus Pesanan"
                             onclick="return confirm('Yakin hapus pesanan ini?')">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; else: ?>
                    <tr>
                      <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-receipt fa-2x mb-2 d-block"></i>
                        Belum ada data pesanan.
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    </div>
  </section>
</div>

</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>