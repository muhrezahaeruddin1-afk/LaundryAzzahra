<div class="row">
  <!-- Header judul + search -->
  <div class="col-12">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="m-0">Dashboard</h4>
      <input id="qsearch" type="text" class="form-control form-control-sm" style="max-width:260px" placeholder="Cari cepat...">
    </div>
  </div>

  <!-- 4 KPI sejajar -->
  <div class="col-md-3 col-6">
    <div class="small-box bg-white shadow-sm">
      <div class="inner">
        <p class="text-muted mb-1"><i class="fas fa-user-friends mr-1"></i> Pelanggan</p>
        <h3><?= $total_pelanggan; ?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-6">
    <div class="small-box bg-white shadow-sm">
      <div class="inner">
        <p class="text-muted mb-1"><i class="fas fa-calendar-day mr-1"></i> Pesanan Hari Ini</p>
        <h3><?= $pesanan_hari_ini; ?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-6">
    <div class="small-box bg-white shadow-sm">
      <div class="inner">
        <p class="text-muted mb-1"><i class="fas fa-sync-alt mr-1"></i> Sedang Proses</p>
        <h3><?= $sedang_proses; ?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-6">
    <div class="small-box bg-white shadow-sm">
      <div class="inner">
        <p class="text-muted mb-1"><i class="fas fa-check-circle mr-1"></i> Selesai Hari Ini</p>
        <h3><?= $selesai_hari_ini; ?></h3>
      </div>
    </div>
  </div>

  <!-- Kiri: Tabel pesanan terbaru -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Pesanan Terbaru</strong>
        <a href="<?= site_url('pesanan');?>" class="text-sm">Lihat semua</a>
      </div>
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
          <thead class="thead-light">
            <tr>
              <th style="width: 50px;" class="text-center">No.</th>
              <th>Kode</th>
              <th>Pelanggan</th>
              <th>Status</th>
              <th class="text-right">Total</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($pesanan_terbaru)): 
              $no = 1; // Inisialisasi nomor urut
              foreach($pesanan_terbaru as $p): 
            ?>
              <tr>
                <td class="text-center"><strong><?= $no++; ?></strong></td>
                <td><?= $p->kode ?? '-'; ?></td>
                <td><?= $p->nama_pelanggan ?? '-'; ?></td>
                <td><span class="badge badge-success"><?= $p->status; ?></span></td>
                <td class="text-right"><?= rupiah($p->total ?? 0); ?></td>
              </tr>
            <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-4">
                  <i class="fas fa-inbox mr-1"></i> Belum ada pesanan.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Kanan: Omzet + Layanan populer -->
  <div class="col-lg-4">
    <div class="card">
      <div class="card-body">
        <p class="text-muted mb-1">Omzet Hari Ini</p>
        <h2 class="font-weight-bold mb-1"><?= rupiah($omzet_hari_ini); ?></h2>
        <small class="text-muted d-block mb-3">Update: <?= date('d M Y H:i'); ?></small>

        <p class="text-muted mb-2">Layanan populer</p>
        <?php if(!empty($daftar_harga)): ?>
          <ul class="list-unstyled mb-0">
            <?php foreach($daftar_harga as $i=>$r): ?>
              <li class="d-flex justify-content-between py-1 border-bottom">
                <span><?= $r['nama']; ?> <small class="text-muted"><?= $r['satuan']; ?></small></span>
                <strong><?= $r['harga']; ?></strong>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>