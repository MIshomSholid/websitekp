<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - UD. Toko Hongkong</title>
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
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f1ea;
            color: #1e293b;
            min-height: 100vh;
        }

        .admin-nav {
            background-color: var(--hk-navy-900);
            color: white;
            padding: 1rem 0;
            border-bottom: 2px solid var(--hk-gold-500);
        }

        .admin-nav .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .admin-nav img {
            height: 38px;
        }

        .header-banner {
            background: linear-gradient(135deg, var(--hk-navy-900) 0%, var(--hk-navy-800) 100%);
            color: white;
            border-radius: 16px;
            padding: 2.5rem;
            margin: 2rem 0;
            border: 1px solid rgba(201, 151, 38, 0.25);
            box-shadow: 0 10px 30px rgba(11, 25, 44, 0.08);
        }

        .header-banner h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-card {
            background: #ffffff;
            padding: 1.75rem;
            border-radius: 14px;
            border: 1px solid var(--hk-border);
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
            display: flex;
            align-items: center;
            gap: 1.25rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            border-color: var(--hk-gold-500);
        }

        .stat-icon-wrapper {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            background: #fdfaf3;
            border: 1px solid rgba(201, 151, 38, 0.25);
            color: var(--hk-gold-600);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--hk-navy-900);
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .action-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid var(--hk-border);
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .action-card:hover {
            transform: translateY(-6px);
            border-color: var(--hk-gold-500);
            box-shadow: 0 16px 32px rgba(11, 25, 44, 0.08);
        }

        .action-icon-box {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: var(--hk-navy-900);
            color: var(--hk-gold-500);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin: 0 auto 1.25rem auto;
        }

        .action-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--hk-navy-900);
            margin-bottom: 0.5rem;
        }

        .action-desc {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 1.5rem;
            flex-grow: 1;
            line-height: 1.6;
        }

        .btn-hk-navy {
            background: var(--hk-navy-900);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.92rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-hk-navy:hover {
            background: var(--hk-gold-600);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .admin-list-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid var(--hk-border);
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
            margin-top: 2rem;
        }

        .admin-list-header {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--hk-navy-900);
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--hk-border);
        }

        .admin-user-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.85rem 1rem;
            background: #fdfdfc;
            border: 1px solid var(--hk-border);
            border-radius: 10px;
            margin-bottom: 0.6rem;
            transition: transform 0.2s ease;
        }

        .admin-user-row:hover {
            transform: translateX(4px);
            background: #ffffff;
            border-color: var(--hk-gold-500);
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--hk-navy-900);
            color: var(--hk-gold-500);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
            margin-right: 0.75rem;
        }

        .badge-admin {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <!-- Top Nav -->
    <nav class="admin-nav">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="manajemen_admin.php" class="brand-title">
                <img src="logohonkong2d.png" alt="Logo" onerror="this.src='assets/images/logohongkong.png'">
                <span>UD. TOKO HONGKONG <small class="text-warning fs-7 d-none d-md-inline">• Admin Panel</small></span>
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="index.php" target="_blank" class="btn btn-sm btn-outline-light">
                    <i class="fas fa-external-link-alt me-1"></i>Lihat Website
                </a>
                <a href="logout.php" class="btn btn-sm btn-danger">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Banner Header -->
        <div class="header-banner">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>Dashboard Manajemen Toko</h1>
                    <p class="mb-0 text-light opacity-75">Kelola data inventori produk, akun admin, dan monitoring toko fisik UD. Toko Hongkong Kapasan Surabaya.</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <span class="badge bg-white text-navy px-3 py-2 fs-6 shadow-sm">
                        <i class="fas fa-shield-alt text-warning me-1"></i>Administrator Terotentikasi
                    </span>
                </div>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div>
                        <div class="stat-number"><?= $adminCount ?></div>
                        <div class="stat-label">Total Admin</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div>
                        <div class="stat-number"><?= $productCount ?></div>
                        <div class="stat-label">Total Produk Katalog</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <div class="stat-number"><?= $activeProducts ?></div>
                        <div class="stat-label">Produk Status Aktif</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Grid -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="action-card">
                    <div class="action-icon-box">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <h3 class="action-title">Kelola Inventori Produk</h3>
                    <p class="action-desc">Tambah produk baru, edit nama, harga, kategori, ukuran, foto produk, serta ubah status ketersediaan stok.</p>
                    <a href="admin.php" class="btn-hk-navy mt-auto">
                        <i class="fas fa-box-open me-1"></i>Buka Manajemen Produk
                    </a>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="action-card">
                    <div class="action-icon-box">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3 class="action-title">Kelola Akun Administrator</h3>
                    <p class="action-desc">Tambah akun administrator baru, kelola username, dan ubah kata sandi sistem manajemen.</p>
                    <a href="kelola_admin.php" class="btn-hk-navy mt-auto">
                        <i class="fas fa-user-plus me-1"></i>Buka Manajemen Admin
                    </a>
                </div>
            </div>
        </div>

        <!-- Admin List Section -->
        <div class="admin-list-card">
            <h4 class="admin-list-header">
                <i class="fas fa-users text-gold me-2"></i>Daftar Administrator Terdaftar
            </h4>
            <div class="admin-items-list">
                <?php
                if (!empty($admins)) {
                    foreach ($admins as $admin) {
                        echo '<div class="admin-user-row">';
                        echo '<div class="d-flex align-items-center">';
                        echo '<div class="admin-avatar">' . strtoupper(substr($admin['username'], 0, 1)) . '</div>';
                        echo '<div>';
                        echo '<div class="fw-bold text-navy">' . htmlspecialchars($admin['username']) . '</div>';
                        echo '<small class="text-muted">ID Admin: #' . $admin['id'] . '</small>';
                        echo '</div>';
                        echo '</div>';
                        echo '<span class="badge-admin"><i class="fas fa-check-circle me-1"></i>ADMIN AKTIF</span>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-muted">Belum ada admin terdaftar.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
