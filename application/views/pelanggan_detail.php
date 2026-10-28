<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Detail Pelanggan</title>

<!-- Font & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root{
  --brand:#06b6d4; --brand-2:#14b8a6; --ink:#1f2937; --muted:#6b7280;
  --line:#e5e7eb; --card:#fff; --shadow:0 8px 24px rgba(0,0,0,.06); --radius:12px;
}

*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Poppins',sans-serif;background:#f9fafb;color:var(--ink);min-height:100vh;}

.container{
  width:100%;
  max-width:100%;
  margin:0;
}

.form{
  background:var(--card);
  padding:24px;
  border-radius:0;
  box-shadow:none;
  border:none;
  min-height:100vh;
}

.form h2{
  margin:0 0 24px;
  font-weight:700;
  display:flex;
  align-items:center;
  gap:12px;
  color: var(--ink);
  font-size:24px;
}

.section-title{
  margin:24px 0 16px;
  font-weight:600;
  color:#0891b2;
  display:flex;
  align-items:center;
  gap:10px;
  font-size:16px;
}

.section-title i{color:#06b6d4}

/* Card Styles */
.card{
  background:var(--card);
  border-radius:var(--radius);
  padding:24px;
  box-shadow:var(--shadow);
  margin-bottom:24px;
  border:1px solid var(--line);
}

.card h3{
  margin:0 0 20px;
  font-weight:600;
  color:var(--ink);
  display:flex;
  align-items:center;
  gap:12px;
  font-size:18px;
}

.card p{
  margin-bottom:16px;
  font-size:15px;
  line-height:1.6;
  color:var(--ink);
}

.card strong{
  color:var(--ink);
  font-weight:600;
  min-width:120px;
  display:inline-block;
}

/* KPI Styles */
.kpi{
  display:grid;
  grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));
  gap:20px;
  margin-top:24px;
}

.kpi > div{
  background:linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
  border-radius:var(--radius);
  padding:24px;
  border:1px solid var(--line);
  text-align:center;
  transition:transform 0.2s;
}

.kpi > div:hover{
  transform:translateY(-2px);
}

.kpi div:first-child{
  background:linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
  border:1px solid #a7f3d0;
}

.kpi div:last-child{
  background:linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
  border:1px solid #bae6fd;
}

.kpi > div > div:first-child{
  font-size:14px;
  font-weight:600;
  color:var(--muted);
  margin-bottom:8px;
}

.kpi .num{
  font-size:32px;
  font-weight:800;
  color:var(--brand);
}

/* Table Styles */
.table{
  width:100%;
  border-collapse:collapse;
  margin-top:20px;
  font-size:14px;
}

.table th{
  background:#f8fafc;
  padding:14px 16px;
  text-align:left;
  font-weight:600;
  color:var(--ink);
  border-bottom:2px solid var(--line);
}

.table td{
  padding:14px 16px;
  border-bottom:1px solid var(--line);
  vertical-align:middle;
}

.table tbody tr:hover{
  background:#f8fafc;
}

/* Buttons */
.btn{
  display:inline-flex;
  align-items:center;
  gap:8px;
  background:linear-gradient(135deg, #06b6d4 0%, #14b8a6 100%);
  color:#fff;
  border:none;
  padding:10px 18px;
  border-radius:10px;
  cursor:pointer;
  font-weight:500;
  text-decoration:none;
  font-size:14px;
  transition:all 0.2s;
}

.btn:hover{
  opacity:.9;
  transform:translateY(-1px);
  box-shadow:0 4px 12px rgba(6,182,212,0.3);
}

.back-btn{
  display:inline-flex;
  align-items:center;
  gap:10px;
  background:#fff;
  border:1px solid var(--line);
  color:var(--ink);
  padding:12px 20px;
  border-radius:10px;
  cursor:pointer;
  font-weight:500;
  text-decoration:none;
  font-size:14px;
  margin-bottom:24px;
  transition:all 0.2s;
}

.back-btn:hover{
  background:#f8fafc;
  border-color:var(--brand);
  transform:translateY(-1px);
}

/* Status Badges */
.status-badge{
  padding:6px 14px;
  border-radius:20px;
  font-size:12px;
  font-weight:500;
  display:inline-block;
}

.status-badge.selesai{
  background:#dcfce7;
  color:#166534;
  border:1px solid #bbf7d0;
}

.status-badge.proses{
  background:#fef3c7;
  color:#92400e;
  border:1px solid #fde68a;
}

.status-badge.pending{
  background:#f3f4f6;
  color:#374151;
  border:1px solid #e5e7eb;
}

.status-badge.lunas{
  background:#dbeafe;
  color:#1e40af;
  border:1px solid #bfdbfe;
}

/* Text Alignment */
.text-right{text-align:right}
.text-center{text-align:center}

/* Responsive */
@media (max-width:768px){
  .form{
    padding:16px;
  }
  
  .kpi{
    grid-template-columns:1fr;
    gap:16px;
  }
  
  .table{
    font-size:12px;
    display:block;
    overflow-x:auto;
  }
  
  .table th,
  .table td{
    padding:10px 12px;
    white-space:nowrap;
  }
  
  .card{
    padding:20px;
  }
  
  .card strong{
    min-width:80px;
  }
}

@media (max-width:480px){
  .form{
    padding:12px;
  }
  
  .form h2{
    font-size:20px;
  }
  
  .kpi .num{
    font-size:24px;
  }
}
</style>
</head>
<body>

  <div class="form">
    <h2>
      <i class="fa-solid fa-user" style="color:#06b6d4"></i>
      Detail Pelanggan
    </h2>

    <div class="card">
      <div class="section-title">
        <i class="fa-solid fa-info-circle"></i>
        Informasi Pelanggan
      </div>
      
      <p><strong>Nama:</strong> <?= htmlentities($info->nama); ?></p>
      <p><strong>Telepon:</strong> <?= htmlentities($info->telp); ?></p>
      <p><strong>Alamat:</strong> <?= htmlentities($info->alamat); ?></p>

      <div class="kpi">
        <div>
          <div>Total Transaksi</div>
          <div class="num"><?= (int)$sum->jml_transaksi; ?></div>
        </div>
        <div>
          <div>Total Belanja</div>
          <div class="num">Rp <?= number_format($sum->total_belanja,0,',','.'); ?></div>
        </div>
      </div>
    </div>

    <div class="card">
      <h3>
        <i class="fa-solid fa-clock-rotate-left"></i>
        Riwayat Transaksi
      </h3>
      
      <?php if(!empty($list)): ?>
        <table class="table">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Tanggal</th>
              <th>Status Pesanan</th>
              <th>Metode</th>
              <th>Status Bayar</th>
              <th class="text-right">Total</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($list as $r): ?>
            <tr>
              <td><strong><?= $r->kode; ?></strong></td>
              <td><?= date('d/m/Y H:i', strtotime($r->tanggal_masuk)); ?></td>
              <td>
                <span class="status-badge <?= 
                  $r->status == 'Selesai' ? 'selesai' : 
                  ($r->status == 'Proses' ? 'proses' : 'pending')
                ?>">
                  <?= $r->status; ?>
                </span>
              </td>
              <td><?= $r->metode; ?></td>
              <td>
                <span class="status-badge <?= 
                  $r->status_bayar == 'Lunas' ? 'lunas' : 
                  ($r->status_bayar == 'DP' ? 'proses' : 'pending')
                ?>">
                  <?= $r->status_bayar; ?>
                </span>
              </td>
              <td class="text-right"><strong>Rp <?= number_format((int)$r->grand_total,0,',','.'); ?></strong></td>
              <td class="text-center">
                <a class="btn" href="<?= site_url('order/receipt/'.$r->pesanan_id); ?>">
                  <i class="fa-solid fa-receipt"></i> Struk
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <div style="text-align:center; padding:40px 20px; color:var(--muted);">
          <i class="fa-solid fa-inbox" style="font-size:48px; margin-bottom:16px; opacity:0.5;"></i>
          <p>Tidak ada riwayat transaksi</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>