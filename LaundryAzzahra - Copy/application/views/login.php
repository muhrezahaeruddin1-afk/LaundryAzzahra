<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login - Laundry Azzahra</title>
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
  <style>
    body{display:flex;align-items:center;justify-content:center;height:100vh;background:#f1f5f9;font-family:sans-serif}
    .card{background:#fff;padding:30px 40px;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,.08);width:340px}
    h2{text-align:center;margin-bottom:20px;color:#0d9488}
    label{display:block;margin-top:12px;font-size:14px;font-weight:600}
    input{width:100%;padding:8px 10px;margin-top:4px;border:1px solid #ddd;border-radius:10px}
    .btn{width:100%;margin-top:20px;background:#0d9488;color:white;padding:10px;border:none;border-radius:10px;cursor:pointer}
    .error{color:#ef4444;text-align:center;margin-top:10px}
  </style>
</head>
<body>
  <div class="card">
    <h2>Login Laundry Azzahra</h2>
    <form method="post">
      <label>Username</label>
      <input type="text" name="username" required>
      <label>Password</label>
      <input type="password" name="password" required>
      <button type="submit" class="btn">Masuk</button>
    </form>
    <?php if($this->session->flashdata('error')): ?>
      <div class="error"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
  </div>
</body>
</html>
