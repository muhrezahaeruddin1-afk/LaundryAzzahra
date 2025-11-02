<div class="row">
  <div class="col-12">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="m-0">Dashboard</h4>
      <input type="text" class="form-control form-control-sm" style="max-width:260px" placeholder="Cari cepat...">
    </div>
  </div>

  <!-- ===== Cards angka (bisa dibuat link: hilangkan komentar <a ...>) ===== -->
  <div class="col-md-3 col-6">
    <!-- <a href="<?= site_url('pelanggan');?>" class="text-reset"> -->
    <div class="small-box bg-white shadow-sm">
      <div class="inner">
        <p class="text-muted mb-1">Pelanggan</p>
        <h3><?= (int)($total_pelanggan ?? 0); ?></h3>
      </div>
    </div>
    <!-- </a> -->
  </div>

  <div class="col-md-3 col-6">
    <!-- <a href="<?= site_url('pesanan?filter=today');?>" class="text-reset"> -->
    <div class="small-box bg-white shadow-sm">
      <div class="inner">
        <p class="text-muted mb-1">Pesanan Hari Ini</p>
        <h3><?= (int)($pesanan_hari_ini ?? 0); ?></h3>
      </div>
    </div>
    <!-- </a> -->
  </div>

  <div class="col-md-3 col-6">
    <!-- <a href="<?= site_url('pesanan?status=PROSES');?>" class="text-reset"> -->
    <div class="small-box bg-white shadow-sm">
      <div class="inner">
        <p class="text-muted mb-1">Sedang Proses</p>
        <h3><?= (int)($sedang_proses ?? 0); ?></h3>
      </div>
    </div>
    <!-- </a> -->
  </div>

  <div class="col-md-3 col-6">
    <!-- <a href="<?= site_url('pesanan?status=SELESAI&filter=today');?>" class="text-reset"> -->
    <div class="small-box bg-white shadow-sm">
      <div class="inner">
        <p class="text-muted mb-1">Selesai Hari Ini</p>
        <h3><?= (int)($selesai_hari_ini ?? 0); ?></h3>
      </div>
    </div>
    <!-- </a> -->
  </div>

  <!-- ===== Tabel + Omzet ===== -->
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
              <th>Kode</th>
              <th>Pelanggan</th>
              <th>Status</th>
              <th class="text-right">Total</th>
            </tr>
          </thead>
          <tbody>
          <?php if (!empty($pesanan_terbaru)): ?>
            <?php foreach ($pesanan_terbaru as $p): ?>
              <?php
                $status = $p->status ?? '-';
                $cls = 'badge-secondary';
                if ($status === 'MASUK')   $cls = 'badge-primary';
                if ($status === 'PROSES')  $cls = 'badge-warning';
                if ($status === 'SELESAI') $cls = 'badge-success';
              ?>
              <tr>
                <td><?= $p->kode ?? '-'; ?></td>
                <td><?= $p->nama_pelanggan ?? '-'; ?></td>
                <td><span class="badge <?= $cls; ?>"><?= $status; ?></span></td>
                <td class="text-right"><?= rupiah($p->total ?? 0); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="text-center text-muted p-4">
                Belum ada pesanan terbaru.
              </td>
            </tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card h-100">
      <div class="card-body">
        <p class="text-muted mb-1">Omzet Hari Ini</p>
        <h2 class="font-weight-bold mb-0"><?= rupiah($omzet_hari_ini ?? 0); ?></h2>
        <small class="text-muted">Update: <?= date('d M Y H:i'); ?></small>

        <!-- Optional: daftar harga ringkas -->
        <?php if (!empty($daftar_harga)): ?>
          <hr>
          <p class="text-muted mb-2">Layanan populer</p>
          <ul class="list-unstyled mb-0">
            <?php foreach ($daftar_harga as $h): ?>
              <li class="d-flex justify-content-between py-1">
                <span><?= $h['nama']; ?> <small class="text-muted"><?= $h['satuan']; ?></small></span>
                <strong><?= $h['harga']; ?></strong>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
