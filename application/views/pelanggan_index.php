<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Data Pelanggan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS AdminLTE & FontAwesome -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">

  <!-- CSS Kustom -->
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css?v=').filemtime(FCPATH.'assets/css/custom.css'); ?>">
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
    <img src="<?= base_url('assets/img/logo.png');?>" alt="Logo" 
         class="brand-image img-circle elevation-3" 
         style="opacity:.95; width:32px; height:32px; object-fit:cover;">
    <span class="brand-text font-weight-semibold">Azzahra Laundry</span>
  </a>

  <div class="sidebar">
    <?php 
      $active = strtolower($this->uri->segment(1) ?? 'dashboard');
    ?>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?= site_url('dashboard');?>" 
             class="nav-link <?= ($active == 'dashboard') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= site_url('layanan');?>" 
             class="nav-link <?= ($active == 'layanan') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-tags"></i>
            <p>Layanan & Harga</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= site_url('pelanggan');?>" 
             class="nav-link <?= ($active == 'pelanggan') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Pelanggan</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= site_url('pesanan');?>" 
             class="nav-link <?= ($active == 'pesanan') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-receipt"></i>
            <p>Pesanan</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= site_url('laporan');?>" 
             class="nav-link <?= ($active == 'laporan') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Laporan</p>
          </a>
        </li>

         <li class="nav-item">
          <a href="<?= site_url('admin');?>" 
             class="nav-link <?= ($active == 'admin') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-user-cog"></i>
            <p>Manajemen Admin</p>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('auth/logout'); ?>" 
            onclick="return confirm('Yakin ingin logout?')" 
            style="color: #dc3545; border-top: 1px solid #444; padding-top: 15px;">
            <i class="fas fa-sign-out-alt"></i>
            <p>Logout</p>
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
        <h1 class="m-0">Pelanggan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Pelanggan</li>
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
            <h3 class="card-title font-weight-semibold">Data Pelanggan</h3>
            <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 200px; display: inline-flex; margin-right: 10px;">
                <form method="get" action="" style="display: flex; width: 100%;">
                  <input type="text" name="q" class="form-control" placeholder="Cari nama / telp" value="<?= htmlentities($q ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </form>
              </div>
              <a href="<?= site_url('pelanggan/create'); ?>" class="btn btn-success btn-sm">
                <i class="fas fa-user-plus"></i> Tambah Pelanggan
              </a>
            </div>
          </div>
          
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead style="background-color: #f8f9fa;">
                  <tr>
                    <th style="width:56px">#</th>
                    <th>Nama</th>
                    <th style="width:150px">Telp</th>
                    <th>Alamat</th>
                    <th style="width:140px" class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($rows)): $no=1; foreach($rows as $r): ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= htmlentities($r->nama, ENT_QUOTES, 'UTF-8'); ?></td>
                      <td>
                        <?php $tel = preg_replace('/\D+/','', $r->telp ?? ''); ?>
                        <?php if($tel): ?>
                          <a href="tel:<?= $tel; ?>" style="text-decoration:none;color:#007bff">
                            <i class="fas fa-phone mr-1"></i>
                            <?= htmlentities($r->telp, ENT_QUOTES, 'UTF-8'); ?>
                          </a>
                        <?php else: ?>
                          <span class="text-muted">-</span>
                        <?php endif; ?>
                      </td>
                      <td><?= htmlentities($r->alamat ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                      <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                          <a href="<?= site_url('pelanggan/detail/'.$r->id); ?>" 
                             class="btn btn-primary" title="Detail">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a href="<?= site_url('pelanggan/edit/'.$r->id); ?>" 
                             class="btn btn-info" title="Edit">
                            <i class="fas fa-edit"></i>
                          </a>
                          <a href="<?= site_url('pelanggan/delete/'.$r->id); ?>" 
                             class="btn btn-danger" title="Hapus"
                             onclick="return confirm('Hapus pelanggan ini?');">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; else: ?>
                    <tr>
                      <td colspan="5" class="text-center text-muted py-4">
                        <i class="fas fa-user-slash fa-2x mb-2 d-block"></i>
                        Belum ada data pelanggan.
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