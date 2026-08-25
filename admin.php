<?php
// admin.php
date_default_timezone_set('Asia/Jakarta');

require_once 'config.php';
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Helper functions
function uploadImage($file)
{
    $uploadDir = 'Uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $fileName = uniqid() . '.' . $fileExtension;
    $targetPath = $uploadDir . $fileName;

    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($fileExtension, $allowedTypes)) {
        throw new Exception('Format file tidak didukung! Hanya JPG, PNG, GIF yang diperbolehkan.');
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        throw new Exception('Ukuran file terlalu besar! Maksimal 2MB.');
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($mime, $allowedMimes)) {
        throw new Exception('Tipe file tidak valid!');
    }

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $fileName;
    }
    throw new Exception('Gagal mengupload file!');
}

function deleteImage($fileName)
{
    $filePath = 'Uploads/' . $fileName;
    if ($fileName && file_exists($filePath)) {
        unlink($filePath);
    }
}

function formatDate($date)
{
    return $date ? date('d/m/Y H:i', strtotime($date)) : '-';
}

// Handle AJAX requests
if (isset($_POST['action'])) {
    header('Content-Type: application/json');

    try {
        switch ($_POST['action']) {
            case 'add_product':
                $name = trim($_POST['name'] ?? '');
                if (empty($name)) {
                    throw new Exception('Nama produk harus diisi!');
                }

                $category = $_POST['category'] ?? '';
                if (!in_array($category, ['atasan', 'bawahan', 'dalaman'])) {
                    throw new Exception('Kategori tidak valid!');
                }

                $price = filter_var($_POST['price'] ?? 0, FILTER_VALIDATE_FLOAT);
                if ($price === false || $price < 0) {
                    throw new Exception('Harga produk tidak valid!');
                }

                $stock = filter_var($_POST['stock'] ?? 0, FILTER_VALIDATE_INT);
                if ($stock === false || $stock < 0) {
                    throw new Exception('Stok produk tidak valid!');
                }

                $gender = $_POST['gender'] ?? '';
                if (!in_array($gender, ['Pria', 'Wanita', 'Unisex'])) {
                    throw new Exception('Jenis kelamin tidak valid!');
                }

                $size_range = trim($_POST['size_range'] ?? '');
                if (empty($size_range)) {
                    throw new Exception('Rentang ukuran harus diisi!');
                }

                $image = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $image = uploadImage($_FILES['image']);
                }

                $status = $_POST['status'] ?? 'aktif';
                if (!in_array($status, ['aktif', 'nonaktif'])) {
                    throw new Exception('Status tidak valid!');
                }

                $stmt = $pdo->prepare("INSERT INTO products (name, category, price, stock, gender, size_range, image, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                $stmt->execute([$name, $category, $price, $stock, $gender, $size_range, $image, $status]);

                $lastId = $pdo->lastInsertId();
                $createdAt = date('d/m/Y H:i');

                echo json_encode(['success' => true, 'message' => "Produk $category telah berhasil ditambahkan!", 'data' => ['id' => $lastId, 'name' => $name, 'category' => $category, 'price' => $price, 'stock' => $stock, 'gender' => $gender, 'size_range' => $size_range, 'image' => $image, 'status' => $status, 'created_at' => $createdAt]]);
                break;

            case 'edit_product':
                $id = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
                if (!$id) {
                    throw new Exception('ID produk tidak valid!');
                }
                $name = trim($_POST['name'] ?? '');
                if (empty($name)) {
                    throw new Exception('Nama produk harus diisi!');
                }

                $category = $_POST['category'] ?? '';
                if (!in_array($category, ['atasan', 'bawahan', 'dalaman'])) {
                    throw new Exception('Kategori tidak valid!');
                }

                $price = filter_var($_POST['price'] ?? 0, FILTER_VALIDATE_FLOAT);
                if ($price === false || $price < 0) {
                    throw new Exception('Harga produk tidak valid!');
                }

                $stock = filter_var($_POST['stock'] ?? 0, FILTER_VALIDATE_INT);
                if ($stock === false || $stock < 0) {
                    throw new Exception('Stok produk tidak valid!');
                }

                $gender = $_POST['gender'] ?? '';
                if (!in_array($gender, ['Pria', 'Wanita', 'Unisex'])) {
                    throw new Exception('Jenis kelamin tidak valid!');
                }

                $size_range = trim($_POST['size_range'] ?? '');
                if (empty($size_range)) {
                    throw new Exception('Rentang ukuran harus diisi!');
                }

                $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
                $stmt->execute([$id]);
                $currentProduct = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$currentProduct) {
                    throw new Exception('Produk tidak ditemukan!');
                }

                $image = $currentProduct['image'];
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    if ($image) {
                        deleteImage($image);
                    }
                    $image = uploadImage($_FILES['image']);
                }

                $status = $_POST['status'] ?? 'aktif';
                if (!in_array($status, ['aktif', 'nonaktif'])) {
                    throw new Exception('Status tidak valid!');
                }

                $stmt = $pdo->prepare("UPDATE products SET name = ?, category = ?, price = ?, stock = ?, gender = ?, size_range = ?, image = ?, status = ? WHERE id = ?");
                $stmt->execute([$name, $category, $price, $stock, $gender, $size_range, $image, $status, $id]);

                $stmt = $pdo->prepare("SELECT id, name, category, price, stock, gender, size_range, image, status, created_at FROM products WHERE id = ?");
                $stmt->execute([$id]);
                $updatedProduct = $stmt->fetch(PDO::FETCH_ASSOC);
                $updatedProduct['created_at'] = formatDate($updatedProduct['created_at']);

                echo json_encode(['success' => true, 'message' => 'Produk berhasil diperbarui!', 'data' => $updatedProduct]);
                break;

            case 'delete_product':
                $id = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
                if (!$id) {
                    throw new Exception('ID produk tidak valid!');
                }

                $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
                $stmt->execute([$id]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {
                    if ($product['image']) {
                        deleteImage($product['image']);
                    }

                    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
                    $stmt->execute([$id]);

                    echo json_encode(['success' => true, 'message' => 'Produk berhasil dihapus!']);
                } else {
                    throw new Exception('Produk tidak ditemukan!');
                }
                break;

            case 'get_product':
                $id = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
                if (!$id) {
                    throw new Exception('ID produk tidak valid!');
                }
                $stmt = $pdo->prepare("SELECT id, name, category, price, stock, gender, size_range, image, status, created_at FROM products WHERE id = ?");
                $stmt->execute([$id]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {
                    $product['created_at'] = formatDate($product['created_at']);
                    echo json_encode(['success' => true, 'data' => $product]);
                } else {
                    throw new Exception('Produk tidak ditemukan!');
                }
                break;

            case 'toggle_status':
                $id = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
                if (!$id) {
                    throw new Exception('ID produk tidak valid!');
                }
                $stmt = $pdo->prepare("UPDATE products SET status = CASE WHEN status = 'aktif' THEN 'nonaktif' ELSE 'aktif' END WHERE id = ?");
                $stmt->execute([$id]);

                $stmt = $pdo->prepare("SELECT status FROM products WHERE id = ?");
                $stmt->execute([$id]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                echo json_encode(['success' => true, 'message' => 'Status berhasil diubah!', 'status' => $product['status']]);
                break;

            default:
                throw new Exception('Aksi tidak valid!');
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// Get products by category
$categories = ['atasan', 'bawahan', 'dalaman'];
$productsByCategory = [];
foreach ($categories as $category) {
    $stmt = $pdo->prepare("SELECT id, name, category, price, stock, gender, size_range, image, status, created_at FROM products WHERE category = ? ORDER BY created_at DESC");
    $stmt->execute([$category]);
    $productsByCategory[$category] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get statistics
$totalProducts = array_sum(array_map('count', $productsByCategory));
$activeProducts = array_sum(array_map(function ($products) {
    return count(array_filter($products, fn($p) => $p['status'] === 'aktif'));
}, $productsByCategory));
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - UD. Toko Hongkong</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0b192c;
            --secondary-color: #122b48;
            --accent-color: #c99726;
            --dark-color: #0b192c;
            --light-color: #f4f1ea;
            --success-color: #15803d;
            --danger-color: #b91c1c;
            --warning-color: #c99726;
            --gradient-primary: linear-gradient(135deg, #0b192c 0%, #122b48 100%);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light-color);
            margin: 0;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: var(--gradient-primary);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-header h4 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
            display: inline-block;
        }

        .sidebar.collapsed .sidebar-header h4 {
            display: none;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.5rem 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0 25px 25px 0;
            margin-right: 1rem;
            white-space: nowrap;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateX(5px);
        }

        .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            text-align: center;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            transition: all 0.3s ease;
            display: block;
        }

        .main-content.collapsed {
            margin-left: 70px;
        }

        .header {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .toggle-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 1rem;
        }

        .header-title {
            margin: 0;
            color: var(--dark-color);
            font-size: 1.5rem;
            font-weight: 600;
        }

        .content {
            padding: 2rem;
        }

        .dashboard-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--light-color);
        }

        .card-title {
            margin: 0;
            color: var(--dark-color);
            font-size: 1.3rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .card-title i {
            margin-right: 0.5rem;
            color: var(--primary-color);
        }

        .btn-primary-custom {
            background: var(--gradient-primary);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-primary-custom i {
            margin-right: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control-custom {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.75rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control-custom:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .table-custom {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .table-custom thead {
            background: var(--gradient-primary);
            color: white;
        }

        .table-custom th {
            font-weight: 600;
            border: none;
            padding: 1rem;
        }

        .table-custom td {
            padding: 1rem;
            border-top: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        .table-custom tbody tr:hover {
            background: #f8fafc;
        }

        .btn-action {
            padding: 0.4rem 0.8rem;
            border: none;
            border-radius: 5px;
            font-size: 0.875rem;
            margin: 0 0.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: var(--warning-color);
            color: white;
        }

        .btn-delete {
            background: var(--danger-color);
            color: white;
        }

        .btn-toggle {
            background: var(--success-color);
            color: white;
        }

        .btn-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: var(--gradient-primary);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 1.5rem;
        }

        .modal-title {
            font-weight: 600;
        }

        .btn-close {
            filter: invert(1);
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid #e5e7eb;
        }

        .image-preview {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            border: 2px solid #e5e7eb;
        }

        .image-placeholder {
            width: 50px;
            height: 50px;
            background: #e5e7eb;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6b7280;
            font-weight: 500;
        }

        .alert-custom {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid var(--danger-color);
        }

        .alert-custom i {
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }

        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #e5e7eb;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        .nav-tabs-custom {
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 1.5rem;
        }

        .nav-tabs-custom .nav-link {
            color: var(--dark-color);
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border: none;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .nav-tabs-custom .nav-link:hover {
            color: var(--primary-color);
            border-bottom: 3px solid var(--primary-color);
        }

        .nav-tabs-custom .nav-link.active {
            color: var(--primary-color);
            border-bottom: 3px solid var(--primary-color);
            background: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 250px;
            }

            .sidebar.collapsed {
                transform: translateX(-100%);
                width: 250px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.collapsed {
                margin-left: 0;
            }

            .header {
                padding: 1rem;
            }

            .content {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .nav-tabs-custom .nav-link {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="loading" id="loading">
        <div class="spinner"></div>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4>Admin Panel</h4>
        </div>
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-section="dashboard">
                        <i class="fas fa-chart-bar"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-section="gallery">
                        <i class="fas fa-tshirt"></i>
                        <span>Kelola Produk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="kelola_admin.php">
                        <i class="fas fa-users-cog"></i>
                        <span>Kelola Admin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="main-content" id="mainContent">
        <div class="header">
            <div class="header-left">
                <button class="toggle-btn" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="header-title" id="pageTitle">Dashboard</h1>
            </div>
        </div>

        <div class="content">
            <div class="content-section active" id="dashboard">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        <div class="stat-number"><?php echo htmlspecialchars($totalProducts); ?></div>
                        <div class="stat-label">Total Produk</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-number"><?php echo htmlspecialchars($activeProducts); ?></div>
                        <div class="stat-label">Produk Aktif</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-number"><?php echo date('d/m/Y'); ?></div>
                        <div class="stat-label">Update Terakhir</div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line"></i>
                            Ringkasan Aktivitas
                        </h3>
                    </div>
                    <p>Selamat datang di Admin Dashboard UD. Toko Hongkong Kapasan. Kelola produk untuk Atasan, Bawahan,
                        dan Dalaman dengan mudah.</p>
                </div>
            </div>

            <div class="content-section" id="gallery">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-tshirt"></i>
                            Kelola Produk
                        </h3>
                        <button class="btn-primary-custom" onclick="openProductModal()">
                            <i class="fas fa-plus"></i>
                            Tambah Produk
                        </button>
                    </div>

                    <ul class="nav nav-tabs nav-tabs-custom" id="productTabs">
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#atasan">Atasan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#bawahan">Bawahan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#dalaman">Dalaman</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <?php foreach ($categories as $category): ?>
                            <div class="tab-pane fade" id="<?php echo $category; ?>">
                                <div class="table-responsive">
                                    <table class="table table-custom">
                                        <thead>
                                            <tr>
                                                <th>Preview</th>
                                                <th>Nama Produk</th>
                                                <th>Harga</th>
                                                <th>Stok</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Rentang Ukuran</th>
                                                <th>Status</th>
                                                <th>Tanggal Dibuat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($productsByCategory[$category])): ?>
                                                <tr>
                                                    <td colspan="8" class="text-center">Belum ada produk di kategori ini.</td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($productsByCategory[$category] as $product): ?>
                                                    <tr data-id="<?php echo (int) $product['id']; ?>">
                                                        <td>
                                                            <?php if ($product['image']): ?>
                                                                <img src="Uploads/<?php echo htmlspecialchars($product['image']); ?>"
                                                                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                                                                    class="image-preview">
                                                            <?php else: ?>
                                                                <div class="image-placeholder">
                                                                    <i class="fas fa-image"></i>
                                                                </div>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><strong><?php echo htmlspecialchars($product['name']); ?></strong></td>
                                                        <td>Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></td>
                                                        <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                                        <td><?php echo htmlspecialchars($product['gender']); ?></td>
                                                        <td><?php echo htmlspecialchars($product['size_range']); ?></td>
                                                        <td>
                                                            <span
                                                                class="badge bg-<?php echo $product['status'] === 'aktif' ? 'success' : 'secondary'; ?>">
                                                                <?php echo ucfirst($product['status']); ?>
                                                            </span>
                                                        </td>
                                                        <td><?php echo formatDate($product['created_at']); ?></td>
                                                        <td>
                                                            <button class="btn-action btn-edit"
                                                                onclick="editProduct(<?php echo (int) $product['id']; ?>)"
                                                                title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn-action btn-toggle"
                                                                onclick="toggleStatus(<?php echo (int) $product['id']; ?>)"
                                                                title="Toggle Status">
                                                                <i class="fas fa-toggle-on"></i>
                                                            </button>
                                                            <button class="btn-action btn-delete"
                                                                onclick="deleteProduct(<?php echo (int) $product['id']; ?>)"
                                                                title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalTitle">Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm" enctype="multipart/form-data">
                        <input type="hidden" id="productId" name="id">
                        <input type="hidden" id="formAction" name="action" value="add_product">

                        <div class="form-group">
                            <label class="form-label" for="productCategory">Kategori</label>
                            <select class="form-control-custom" id="productCategory" name="category" required>
                                <option value="atasan">Atasan</option>
                                <option value="bawahan">Bawahan</option>
                                <option value="dalaman">Dalaman</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="productName">Nama Produk</label>
                            <input type="text" class="form-control-custom" id="productName" name="name" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="productPrice">Harga</label>
                            <input type="number" class="form-control-custom" id="productPrice" name="price" min="0"
                                step="0.01" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="productStock">Stok</label>
                            <input type="number" class="form-control-custom" id="productStock" name="stock" min="0"
                                required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="productGender">Jenis Kelamin</label>
                            <select class="form-control-custom" id="productGender" name="gender" required>
                                <option value="Pria">Pria</option>
                                <option value="Wanita">Wanita</option>
                                <option value="Unisex">Unisex</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="productSizeRange">Rentang Ukuran</label>
                            <input type="text" class="form-control-custom" id="productSizeRange" name="size_range"
                                required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="productImage">Upload Gambar</label>
                            <input type="file" class="form-control-custom" id="productImage" name="image"
                                accept="image/jpeg,image/png,image/gif">
                            <small class="text-muted">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="productStatus">Status</label>
                            <select class="form-control-custom" id="productStatus" name="status">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Non-aktif</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="productForm" class="btn btn-primary-custom">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showLoading() {
            $('#loading').show();
        }

        function hideLoading() {
            $('#loading').hide();
        }

        function showAlert(message, type = 'success') {
            const alert = $(`<div class="alert-custom alert-${type}">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                ${message}
            </div>`);
            $('body').append(alert);
            setTimeout(() => alert.fadeOut(300, () => alert.remove()), 3000);
        }

        function addProductToTable(product) {
            const row = `
                <tr data-id="${product.id}">
                    <td>
                        ${product.image ? `<img src="Uploads/${product.image}" alt="${product.name}" class="image-preview">` : '<div class="image-placeholder"><i class="fas fa-image"></i></div>'}
                    </td>
                    <td><strong>${product.name}</strong></td>
                    <td>Rp ${Number(product.price).toLocaleString('id-ID')}</td>
                    <td>${product.stock}</td>
                    <td>${product.gender}</td>
                    <td>${product.size_range}</td>
                    <td><span class="badge bg-${product.status === 'aktif' ? 'success' : 'secondary'}">${product.status}</span></td>
                    <td>${product.created_at || '-'}</td>
                    <td>
                        <button class="btn-action btn-edit" onclick="editProduct(${product.id})" title="Edit"><i class="fas fa-edit"></i></button>
                        <button class="btn-action btn-toggle" onclick="toggleStatus(${product.id})" title="Toggle Status"><i class="fas fa-toggle-on"></i></button>
                        <button class="btn-action btn-delete" onclick="deleteProduct(${product.id})" title="Hapus"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
            const tbody = $(`#${product.category} tbody`);
            if (tbody.find('tr td').text().includes('Belum ada produk')) {
                tbody.empty();
            }
            tbody.prepend(row);
        }

        function updateProductInTable(product) {
            const row = $(`tr[data-id="${product.id}"]`);
            if (row.length) {
                row.html(`
                    <td>
                        ${product.image ? `<img src="Uploads/${product.image}" alt="${product.name}" class="image-preview">` : '<div class="image-placeholder"><i class="fas fa-image"></i></div>'}
                    </td>
                    <td><strong>${product.name}</strong></td>
                    <td>Rp ${Number(product.price).toLocaleString('id-ID')}</td>
                    <td>${product.stock}</td>
                    <td>${product.gender}</td>
                    <td>${product.size_range}</td>
                    <td><span class="badge bg-${product.status === 'aktif' ? 'success' : 'secondary'}">${product.status}</span></td>
                    <td>${product.created_at || '-'}</td>
                    <td>
                        <button class="btn-action btn-edit" onclick="editProduct(${product.id})" title="Edit"><i class="fas fa-edit"></i></button>
                        <button class="btn-action btn-toggle" onclick="toggleStatus(${product.id})" title="Toggle Status"><i class="fas fa-toggle-on"></i></button>
                        <button class="btn-action btn-delete" onclick="deleteProduct(${product.id})" title="Hapus"><i class="fas fa-trash"></i></button>
                    </td>
                `);
                if (row.closest('.tab-pane').attr('id') !== product.category) {
                    const newTbody = $(`#${product.category} tbody`);
                    if (newTbody.find('tr td').text().includes('Belum ada produk')) {
                        newTbody.empty();
                    }
                    newTbody.prepend(row);
                }
            } else {
                addProductToTable(product);
            }
        }

        function openProductModal() {
            $('#productModalTitle').text('Tambah Produk Baru');
            $('#formAction').val('add_product');
            $('#productId').val('');
            $('#productCategory').val('atasan');
            $('#productName').val('');
            $('#productPrice').val('');
            $('#productStock').val('');
            $('#productGender').val('Unisex');
            $('#productSizeRange').val('');
            $('#productImage').val('');
            $('#productStatus').val('aktif');
            $('#productModal').modal('show');
        }

        function editProduct(id) {
            showLoading();
            $.post('', { action: 'get_product', id: id }, (response) => {
                hideLoading();
                if (response.success) {
                    $('#productModalTitle').text('Edit Produk');
                    $('#formAction').val('edit_product');
                    $('#productId').val(response.data.id);
                    $('#productCategory').val(response.data.category);
                    $('#productName').val(response.data.name);
                    $('#productPrice').val(response.data.price);
                    $('#productStock').val(response.data.stock);
                    $('#productGender').val(response.data.gender);
                    $('#productSizeRange').val(response.data.size_range);
                    $('#productStatus').val(response.data.status);
                    $('#productImage').val('');
                    $('#productModal').modal('show');
                } else {
                    showAlert(response.message, 'danger');
                }
            }, 'json').fail(() => {
                hideLoading();
                showAlert('Terjadi kesalahan saat mengambil data!', 'danger');
            });
        }

        function toggleStatus(id) {
            if (!confirm('Apakah Anda yakin ingin mengubah status produk ini?')) return;
            showLoading();
            $.post('', { action: 'toggle_status', id: id }, (response) => {
                hideLoading();
                if (response.success) {
                    showAlert(response.message);
                    const row = $(`tr[data-id="${id}"]`);
                    if (row.length) {
                        row.find('td:eq(6)').html(`<span class="badge bg-${response.status === 'aktif' ? 'success' : 'secondary'}">${response.status}</span>`);
                        row.find('td:eq(7)').text(response.updated_at); // Update Tanggal Diperbarui
                    }
                } else {
                    showAlert(response.message, 'danger');
                }
            }, 'json').fail(() => {
                hideLoading();
                showAlert('Terjadi kesalahan!', 'danger');
            });
        }

        function deleteProduct(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus produk ini?')) return;
            showLoading();
            $.post('', { action: 'delete_product', id: id }, (response) => {
                hideLoading();
                if (response.success) {
                    showAlert(response.message);
                    const row = $(`tr[data-id="${id}"]`);
                    const tbody = row.closest('tbody');
                    row.remove();
                    if (tbody.find('tr').length === 0) {
                        tbody.append('<tr><td colspan="8" class="text-center">Belum ada produk di kategori ini.</td></tr>');
                    }
                } else {
                    showAlert(response.message, 'danger');
                }
            }, 'json').fail(() => {
                hideLoading();
                showAlert('Terjadi kesalahan!', 'danger');
            });
        }

        $('#productForm').on('submit', function (e) {
            e.preventDefault();
            showLoading();
            const formData = new FormData(this);
            const action = $('#formAction').val();
            const category = $('#productCategory').val();

            $.ajax({
                url: '',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: (response) => {
                    hideLoading();
                    if (response.success) {
                        showAlert(response.message);
                        $('#productModal').modal('hide');
                        if (action === 'add_product') {
                            addProductToTable(response.data);
                        } else if (action === 'edit_product') {
                            updateProductInTable(response.data);
                        }
                        $(`#${category}`).addClass('show active');
                        $('.tab-pane').not(`#${category}`).removeClass('show active');
                        $(`#productTabs a[href="#${category}"]`).addClass('active').parent().siblings().find('a').removeClass('active');
                        $('#pageTitle').text('Kelola Produk');
                    } else {
                        showAlert(response.message, 'danger');
                    }
                },
                error: () => {
                    hideLoading();
                    showAlert('Terjadi kesalahan saat menyimpan data!', 'danger');
                }
            });
        });

        $('#toggleSidebar').click(function () {
            const $sidebar = $('#sidebar');
            const $mainContent = $('#mainContent');
            const isMobile = window.innerWidth <= 768;

            if (isMobile) {
                $sidebar.toggleClass('show');
                if ($sidebar.hasClass('show')) {
                    $sidebar.removeClass('collapsed');
                }
            } else {
                $sidebar.toggleClass('collapsed');
                $mainContent.toggleClass('collapsed');
            }
        });

        $(document).ready(function () {
            $('.nav-link').click(function (e) {
                if ($(this).attr('href') === '#') {
                    e.preventDefault();
                    $('.nav-link').removeClass('active');
                    $(this).addClass('active');
                    const section = $(this).data('section');
                    $('.content-section').removeClass('active');
                    $(`#${section}`).addClass('active');
                    $('#pageTitle').text($(this).find('span').text());

                    if (section === 'gallery') {
                        $('#productTabs a[href="#atasan"]').tab('show');
                    }
                }
            });

            // Handle clicks outside sidebar on mobile
            $(document).on('click', function (e) {
                if (window.innerWidth <= 768) {
                    const $sidebar = $('#sidebar');
                    const $toggleBtn = $('#toggleSidebar');
                    if ($sidebar.hasClass('show') && !$sidebar.is(e.target) && $sidebar.has(e.target).length === 0 && !$toggleBtn.is(e.target)) {
                        $sidebar.removeClass('show');
                    }
                }
            });
        });
    </script>
</body>

</html>