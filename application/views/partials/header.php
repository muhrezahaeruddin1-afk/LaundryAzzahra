<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= isset($title)?$title:'Laundry Azzahra'; ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
<style>
/* header mini */
.app-header{background:linear-gradient(90deg,#16a34a,#10b981); color:#fff; padding:16px 18px; border-bottom:4px solid #facc15;}
.app-header .brand{display:flex;align-items:center;gap:12px; font-weight:700; font-size:22px}
.app-header .addr{opacity:.9; font-size:13px}
.navbar{display:flex; gap:10px; margin-top:12px; flex-wrap:wrap}
.navbar a{background:rgba(255,255,255,.15); color:#fff; padding:6px 10px; border-radius:999px; text-decoration:none; font-size:13px}
.navbar a.active{background:#facc15; color:#1f2937}

/* ⬇️ container diganti agar tidak bentrok dengan dashboard */
.page-container{max-width:1100px; margin:16px auto; padding:0 10px}
</style>
</head>
<body>

<header class="app-header">
  <div class="brand">Laundry Azzahra</div>
  <div class="addr">Jln. Manuruki 2 No. 79, Makassar</div>
  <nav class="navbar">
    <a href="<?= site_url('pelanggan'); ?>" class="<?= ($active??'')==='pelanggan'?'active':''; ?>">Pelanggan</a>
    <a href="<?= site_url('order/baru'); ?>" class="<?= ($active??'')==='pesanan'?'active':''; ?>">Pesanan</a>
    <a href="<?= site_url('pesanan'); ?>" class="<?= ($active??'')==='daftar_pesanan'?'active':''; ?>">Daftar Pesanan</a>
    <a href="<?= site_url('layanan'); ?>" class="<?= ($active??'')==='layanan'?'active':''; ?>">Layanan & Harga</a>
    <a href="<?= site_url('laporan'); ?>" class="<?= ($active??'')==='laporan'?'active':''; ?>">Laporan</a>
  </nav>
</header>

<main class="page-container">
