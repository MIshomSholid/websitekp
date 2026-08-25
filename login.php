<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: manajemen_admin.php');
        exit;
    } else {
        $error = 'Username atau password yang Anda masukkan salah.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Portal Admin - UD. Toko Hongkong</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --hk-navy-900: #0b192c;
            --hk-navy-800: #122b48;
            --hk-gold-500: #c99726;
            --hk-gold-600: #b5851d;
            --hk-bg-main: #fcfbf9;
            --hk-border: #eae5dc;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0b192c 0%, #122b48 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .login-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            padding: 2.5rem;
            max-width: 420px;
            width: 100%;
            border: 1px solid rgba(201, 151, 38, 0.25);
            position: relative;
        }

        .login-brand-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-brand-logo {
            height: 55px;
            margin-bottom: 0.75rem;
        }

        .login-title {
            font-family: 'Playfair Display', serif;
            color: var(--hk-navy-900);
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .login-subtitle {
            font-size: 0.85rem;
            color: #6b7280;
        }

        .form-label {
            font-weight: 600;
            color: var(--hk-navy-900);
            font-size: 0.88rem;
            margin-bottom: 0.4rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--hk-gold-500);
            box-shadow: 0 0 0 3px rgba(201, 151, 38, 0.15);
            outline: none;
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af;
        }
        .password-toggle:hover {
            color: var(--hk-navy-900);
        }

        .btn-login {
            background-color: var(--hk-navy-900);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.85rem;
            border-radius: 8px;
            border: none;
            width: 100%;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(11, 25, 44, 0.2);
        }

        .btn-login:hover {
            background-color: var(--hk-gold-600);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: #6b7280;
            font-size: 0.88rem;
            text-decoration: none;
            margin-top: 1.5rem;
            font-weight: 500;
        }
        .back-link:hover {
            color: var(--hk-gold-600);
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            font-size: 0.88rem;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-brand-header">
            <img src="logohonkong2d.png" alt="UD. Toko Hongkong" class="login-brand-logo" onerror="this.src='logohongkong.png'">
            <h1 class="login-title">Portal Admin</h1>
            <p class="login-subtitle">UD. Toko Hongkong Kapasan Surabaya</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" id="loginForm">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-user text-muted"></i></span>
                    <input type="text" class="form-control border-start-0 ps-0" id="username" name="username" placeholder="Masukkan username" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                    <i class="fas fa-eye password-toggle" id="passwordToggle"></i>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Dashboard
            </button>
        </form>

        <div class="text-center">
            <a href="index.php" class="back-link">
                <i class="fas fa-arrow-left"></i>Kembali ke Website Utama
            </a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#passwordToggle').click(function () {
                const passwordInput = $('#password');
                const icon = $(this);
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>
</body>
</html>
