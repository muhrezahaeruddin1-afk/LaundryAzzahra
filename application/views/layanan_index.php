<!-- <?php
// Load header template
$this->load->view('layouts/header', ['title' => 'Layanan & Harga']);
$this->load->view('layouts/sidebar');
?> -->

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Layanan & Harga</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Layanan & Harga</li>
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
            <h3 class="card-title font-weight-semibold">Daftar Layanan</h3>
            <div class="card-tools">
              <a href="<?= site_url('layanan/create'); ?>" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Tambah Layanan
              </a>
            </div>
          </div>
          
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th style="width:56px">#</th>
                    <th>Nama Layanan</th>
                    <th>Satuan</th>
                    <th class="text-right">Harga</th>
                    <th style="width:100px">Status</th>
                    <th style="width:140px" class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($layanan)): foreach($layanan as $i=>$l): ?>
                    <tr>
                      <td><?= $i+1; ?></td>
                      <td><?= htmlentities($l->nama, ENT_QUOTES, 'UTF-8'); ?></td>
                      <td><?= htmlentities($l->tipe_satuan, ENT_QUOTES, 'UTF-8'); ?></td>
                      <td class="text-right">Rp <?= number_format((int)$l->harga_per_satuan,0,',','.'); ?></td>
                      <td>
                        <?php if($l->aktif): ?>
                          <span class="badge badge-success">
                            <i class="fas fa-check-circle"></i> AKTIF
                          </span>
                        <?php else: ?>
                          <span class="badge badge-danger">
                            <i class="fas fa-ban"></i> NONAKTIF
                          </span>
                        <?php endif; ?>
                      </td>
                      <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                          <a href="<?= site_url('layanan/edit/'.$l->id); ?>" 
                             class="btn btn-info" title="Edit">
                            <i class="fas fa-edit"></i>
                          </a>

                          <?php if($l->aktif): ?>
                            <a href="<?= site_url('layanan/toggle/'.$l->id); ?>" 
                               class="btn btn-warning" title="Nonaktifkan">
                              <i class="fas fa-toggle-off"></i>
                            </a>
                          <?php else: ?>
                            <a href="<?= site_url('layanan/toggle/'.$l->id); ?>" 
                               class="btn btn-success" title="Aktifkan">
                              <i class="fas fa-toggle-on"></i>
                            </a>
                          <?php endif; ?>

                          <a href="<?= site_url('layanan/delete/'.$l->id); ?>" 
                             class="btn btn-danger" title="Hapus"
                             onclick="return confirm('Hapus layanan ini?')">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; else: ?>
                    <tr>
                      <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        Belum ada data layanan.
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

