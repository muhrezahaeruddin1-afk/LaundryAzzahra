<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Laporan Harian</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS AdminLTE & FontAwesome -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">

  <!-- CSS Kustom -->
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css?v=').filemtime(FCPATH.'assets/css/custom.css'); ?>">
  
  <style>
    /* Custom status badges */
    .badge-PAID { background: #dcfce7; color: #166534; }
    .badge-UNPAID { background: #fee2e2; color: #991b1b; }
    
    /* KPI Cards */
    .info-box {
      box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
      border-radius: 0.25rem;
      background: #fff;
      display: flex;
      margin-bottom: 1rem;
      min-height: 80px;
      padding: .5rem;
      position: relative;
    }
    .info-box-icon {
      border-radius: 0.25rem;
      align-items: center;
      display: flex;
      font-size: 1.875rem;
      justify-content: center;
      text-align: center;
      width: 70px;
    }
    .info-box-content {
      display: flex;
      flex-direction: column;
      justify-content: center;
      line-height: 1.8;
      flex: 1;
      padding: 0 10px;
    }
    .info-box-text {
      display: block;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      font-size: 0.875rem;
    }
    .info-box-number {
      display: block;
      font-weight: 700;
      font-size: 1.5rem;
    }
    
    @media print {
      .no-print { display: none !important; }
      .content-wrapper, .main-sidebar, .main-header { display: none !important; }
      body { margin: 0; }
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<!-- Topbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light no-print">
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
<aside class="main-sidebar elevation-4 sidebar-dark-primary no-print">
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
        <h1 class="m-0">Laporan Harian</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Laporan Harian</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    
    <!-- Filter Card -->
    <div class="card no-print">
      <div class="card-body">
        <form method="get" class="row align-items-end">
          <div class="col-md-2">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $tanggal ?>">
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-filter"></i> Tampilkan
            </button>
          </div>
          <div class="col-md-3 ml-auto">
            <label for="q">Cari</label>
            <input type="search" id="q" class="form-control" placeholder="Cari kode/pelanggan...">
          </div>
          <div class="col-md-2">
            <label for="fStatusBayar">Status Bayar</label>
            <select id="fStatusBayar" class="form-control">
              <option value="">Semua</option>
              <option value="PAID">PAID</option>
              <option value="UNPAID">UNPAID</option>
            </select>
          </div>
          <div class="col-md-3">
            <a href="<?= site_url('laporan/bulanan?bulan='.substr($tanggal,0,7)); ?>" class="btn btn-info btn-sm">
              <i class="fas fa-calendar-alt"></i> Laporan Bulanan
            </a>
            <button type="button" id="btnCSV" class="btn btn-success btn-sm">
              <i class="fas fa-file-csv"></i> CSV
            </button>
            <button type="button" onclick="window.print()" class="btn btn-secondary btn-sm">
              <i class="fas fa-print"></i> Print
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- KPI Row -->
    <div class="row">
      <div class="col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-receipt"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Pesanan</span>
            <span class="info-box-number"><?= (int)$sum->jml_pesanan; ?></span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Pesanan Selesai</span>
            <span class="info-box-number"><?= (int)$sum->jml_selesai; ?></span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-wallet"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Pendapatan (PAID)</span>
            <span class="info-box-number">Rp <?= number_format($sum->pendapatan,0,',','.'); ?></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Data Table -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title font-weight-semibold">Detail Pesanan - <?= date('d F Y', strtotime($tanggal)); ?></h3>
          </div>
          
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0" id="tbl">
                <thead style="background-color: #f8f9fa;">
                  <tr>
                    <th style="width: 100px">Kode</th>
                    <th style="width: 130px">Tanggal</th>
                    <th>Pelanggan</th>
                    <th style="width: 100px">Status</th>
                    <th style="width: 100px">Metode</th>
                    <th style="width: 100px">Status Bayar</th>
                    <th class="text-right" style="width: 130px">Total</th>
                    <th class="text-center no-print" style="width: 80px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($rows)): foreach($rows as $r): ?>
                    <tr>
                      <td data-kode="<?= htmlspecialchars($r->kode,ENT_QUOTES,'UTF-8'); ?>">
                        <strong><?= $r->kode; ?></strong>
                      </td>
                      <td><?= date('d/m/Y H:i', strtotime($r->tanggal_masuk)); ?></td>
                      <td data-pelanggan="<?= htmlspecialchars($r->pelanggan,ENT_QUOTES,'UTF-8'); ?>">
                        <?= htmlentities($r->pelanggan ?? ''); ?>
                      </td>
                      <td><?= htmlentities($r->status ?? ''); ?></td>
                      <td><?= htmlentities($r->metode ?? ''); ?></td>
                      <td>
                        <span class="badge badge-<?= $r->status_bayar; ?>">
                          <?= $r->status_bayar; ?>
                        </span>
                      </td>
                      <td class="text-right"><strong>Rp <?= number_format((int)$r->total,0,',','.'); ?></strong></td>
                      <td class="text-center no-print">
                        <a href="<?= site_url('order/receipt/'.$r->pesanan_id); ?>" 
                           class="btn btn-success btn-sm" title="Cetak Struk">
                          <i class="fas fa-print"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; else: ?>
                    <tr>
                      <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-chart-line fa-2x mb-2 d-block"></i>
                        Belum ada data untuk tanggal ini.
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

<script>
// ===== client filter: search + status bayar =====
const q = document.getElementById('q');
const fStatus = document.getElementById('fStatusBayar');
const rows = [...document.querySelectorAll('#tbl tbody tr')];

function applyFilter(){
  const term = q.value.trim().toLowerCase();
  const stat = fStatus.value;
  rows.forEach(tr=>{
    const kode = tr.querySelector('[data-kode]')?.dataset.kode?.toLowerCase() || '';
    const pelanggan = tr.querySelector('[data-pelanggan]')?.dataset.pelanggan?.toLowerCase() || '';
    const statusBayar = tr.children[5].innerText.trim();
    const matchTerm = !term || kode.includes(term) || pelanggan.includes(term);
    const matchStat = !stat || statusBayar === stat;
    tr.style.display = (matchTerm && matchStat) ? '' : 'none';
  });
}
q.addEventListener('input', applyFilter);
fStatus.addEventListener('change', applyFilter);

// ===== export CSV (hanya baris yang terlihat) =====
document.getElementById('btnCSV').addEventListener('click', ()=>{
  const visible = [...document.querySelectorAll('#tbl tbody tr')].filter(tr=>tr.style.display!=='none');
  const head = [...document.querySelectorAll('#tbl thead th')].slice(0, -1).map(th=>`"${th.innerText.replace(/"/g,'""')}"`).join(',');
  const body = visible.map(tr=>[...tr.children].slice(0, -1).map(td=>`"${td.innerText.replace(/"/g,'""')}"`).join(',')).join('\n');
  const csv = head+'\n'+body;
  const blob = new Blob([csv],{type:'text/csv;charset=utf-8;'});
  const a = document.createElement('a'); a.href = URL.createObjectURL(blob);
  a.download = 'laporan-harian-<?= $tanggal ?>.csv'; a.click();
});
</script>

</body>
</html>