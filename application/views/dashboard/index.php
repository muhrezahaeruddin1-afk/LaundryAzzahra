<div class="row">
  <div class="col-12">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="m-0">Dashboard</h4>
      <input type="text" class="form-control form-control-sm" style="max-width:260px" placeholder="Cari cepat...">
    </div>
  </div>

  <!-- Card angka -->
  <div class="col-md-3 col-6"><div class="small-box bg-white shadow-sm"><div class="inner">
    <p class="text-muted mb-1">Pelanggan</p><h3><?= $total_pelanggan; ?></h3>
  </div></div></div>

  <div class="col-md-3 col-6"><div class="small-box bg-white shadow-sm"><div class="inner">
    <p class="text-muted mb-1">Pesanan Hari Ini</p><h3><?= $pesanan_hari_ini; ?></h3>
  </div></div></div>

  <div class="col-md-3 col-6"><div class="small-box bg-white shadow-sm"><div class="inner">
    <p class="text-muted mb-1">Sedang Proses</p><h3><?= $sedang_proses; ?></h3>
  </div></div></div>

  <div class="col-md-3 col-6"><div class="small-box bg-white shadow-sm"><div class="inner">
    <p class="text-muted mb-1">Selesai Hari Ini</p><h3><?= $selesai_hari_ini; ?></h3>
  </div></div></div>

  <!-- Tabel + Omzet -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Pesanan Terbaru</strong>
        <a href="<?= site_url('pesanan');?>" class="text-sm">Lihat semua</a>
      </div>
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
          <thead class="thead-light">
            <tr><th>Kode</th><th>Pelanggan</th><th>Status</th><th class="text-right">Total</th></tr>
          </thead>
          <tbody>
          <?php if(!empty($pesanan_terbaru)) foreach($pesanan_terbaru as $p): ?>
            <tr>
              <td><?= $p->kode ?? '-'; ?></td>
              <td><?= $p->nama_pelanggan ?? '-'; ?></td>
              <td><span class="badge badge-secondary"><?= $p->status; ?></span></td>
              <td class="text-right"><?= rupiah($p->total ?? 0); ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card">
      <div class="card-body">
        <p class="text-muted mb-1">Omzet Hari Ini</p>
        <h2 class="font-weight-bold mb-0"><?= rupiah($omzet_hari_ini); ?></h2>
        <small class="text-muted">Update: <?= date('d M Y H:i'); ?></small>
      </div>
    </div>
  </div>
</div>
