<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title><?= isset($title)? $title : 'Dashboard'; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS AdminLTE & FontAwesome -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">

  <!-- CSS Kustom (HARUS setelah AdminLTE) -->
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css?v=').filemtime(FCPATH.'assets/css/custom.css'); ?>"></head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
