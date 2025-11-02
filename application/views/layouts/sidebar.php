<!-- Topbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav ml-auto"><li class="nav-item">Admin</li></ul>
</nav>

<!-- Sidebar kiri -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link"><span class="brand-text font-weight-light">Azzahra Laundry</span></a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column">
        <li class="nav-item"><a href="<?= site_url('dashboard');?>" class="nav-link"><i class="nav-icon fas fa-home"></i><p>Dashboard</p></a></li>
        <li class="nav-item"><a href="<?= site_url('layanan');?>" class="nav-link"><i class="nav-icon fas fa-tags"></i><p>Layanan</p></a></li>
        <li class="nav-item"><a href="<?= site_url('pelanggan');?>" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Pelanggan</p></a></li>
        <li class="nav-item"><a href="<?= site_url('pesanan');?>" class="nav-link"><i class="nav-icon fas fa-receipt"></i><p>Pesanan</p></a></li>
        <li class="nav-item"><a href="<?= site_url('transaksi');?>" class="nav-link"><i class="nav-icon fas fa-wallet"></i><p>Transaksi</p></a></li>
      </ul>
    </nav>
  </div>
</aside>

<!-- Konten -->
<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">
