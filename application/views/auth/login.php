<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Azzahra Laundry</title>
    <style>
     body {
            font-family: Arial, sans-serif;
            /* GANTI DENGAN WARNA DASHBOARD ANDA */
            background: linear-gradient(180deg, #00b4d8 0%, #00c896 100%) !important;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            /* GANTI DENGAN WARNA DASHBOARD ANDA */
            border-color: #1ac637ff;
            outline: none;
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            /* GANTI DENGAN WARNA DASHBOARD ANDA */
            background: linear-gradient(180deg, #00b4d8 0%, #00c896 100%) !important;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: transform 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
        }
        .register-link a {
            /* GANTI DENGAN WARNA DASHBOARD ANDA */
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            /* GANTI DENGAN WARNA DASHBOARD ANDA */
            color: #00b4d8;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">Azzahra Laundry</div>
        <h2>Login</h2>
        
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-error">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo site_url('auth/login'); ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
        
    
    </div>
</body>
</html>