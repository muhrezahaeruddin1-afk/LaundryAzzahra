<!-- Topbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Tombol toggle sidebar -->
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
  <!-- Brand Logo - akan tersembunyi ketika sidebar collapsed -->
  <a href="<?= site_url('dashboard');?>" class="brand-link">
    <img src="<?= base_url('assets/img/logo.png');?>" alt="Logo" 
         class="brand-image img-circle elevation-3" 
         style="opacity:.95; width:32px; height:32px; object-fit:cover;">
    <span class="brand-text font-weight-semibold">Azzahra Laundry</span>
  </a>

  <div class="sidebar">
    <?php 
      // deteksi controller aktif
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


        <!-- Tombol Logout -->
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('auth/logout'); ?>" 
            onclick="return confirm('Yakin ingin logout?')" 
            style="color: #dc3545; border-top: 1px solid #444; padding-top: 15px;">
            <i class="fas fa-sign-out-alt"></i>
            <p>Logout <?php echo $this->session->userdata('nama_lengkap'); ?></p>
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

    

    