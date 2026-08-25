<?php
// dalaman.php - UD. Toko Hongkong Kapasan
require_once 'config.php';

$currentCategory = 'dalaman';
$categoryTitle = 'Pakaian Dalam';
$categorySubtitle = 'Koleksi pakaian dalam pria & wanita, underpants katun halus, kaos dalam bernapas, serta lingerie elegan dengan kenyamanan maksimal untuk aktivitas harian Anda.';
$defaultFallbackImage = 'dress.png';

// Filter inputs
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$maxPriceInput = isset($_GET['maxPrice']) ? trim($_GET['maxPrice']) : '';
$minPriceInput = isset($_GET['minPrice']) ? trim($_GET['minPrice']) : '';
$minPrice = ($minPriceInput !== '' && is_numeric($minPriceInput)) ? (float) $minPriceInput : null;
$maxPrice = ($maxPriceInput !== '' && is_numeric($maxPriceInput)) ? (float) $maxPriceInput : null;
$size_input = isset($_GET['size_range']) ? strtoupper(trim($_GET['size_range'])) : '';
$gender = isset($_GET['gender']) ? trim($_GET['gender']) : '';

$size_order = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'];
$error_message = '';

try {
    $sql = "SELECT id, name, image, category, status, price, stock, gender, size_range, created_at 
            FROM products 
            WHERE category = 'dalaman' 
            AND status = 'aktif'";
    
    $params = [];

    // Price Filter
    if ($minPrice !== null && $maxPrice !== null) {
        $sql .= " AND price BETWEEN :minPrice AND :maxPrice";
        $params[':minPrice'] = $minPrice;
        $params[':maxPrice'] = $maxPrice;
    } elseif ($minPrice !== null) {
        $sql .= " AND price >= :minPrice";
        $params[':minPrice'] = $minPrice;
    } elseif ($maxPrice !== null) {
        $sql .= " AND price <= :maxPrice";
        $params[':maxPrice'] = $maxPrice;
    }

    // Search Filter
    if (!empty($search)) {
        $sql .= " AND name LIKE :search";
        $params[':search'] = "%$search%";
    }

    // Gender Filter
    if (!empty($gender) && $gender !== 'all' && $gender !== 'Semua') {
        $sql .= " AND (gender = :gender OR gender = 'Unisex')";
        $params[':gender'] = $gender;
    }

    // Size Filter
    if (!empty($size_input) && $size_input !== 'ALL' && $size_input !== 'SEMUA') {
        if (in_array($size_input, $size_order)) {
            $sql .= " AND (size_range LIKE :size_like OR size_range = 'S-XL' OR size_range = 'All Size')";
            $params[':size_like'] = "%$size_input%";
        }
    }

    $sql .= " ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Database error in dalaman: " . $e->getMessage());
    $products = [];
    $error_message = "Terjadi kendala saat memuat produk katalog.";
}

if (!function_exists('getThumbPath')) {
    function getThumbPath($imgName, $fallback = 'dress.png') {
        if (!empty($imgName) && file_exists(__DIR__ . '/Uploads/' . $imgName)) {
            return 'Uploads/' . htmlspecialchars($imgName);
        }
        return $fallback;
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($categoryTitle) ?> - UD. Toko Hongkong Kapasan Surabaya</title>
    <meta name="description" content="Katalog Pakaian Dalam UD. Toko Hongkong Kapasan Surabaya. Underpants pria, underwear wanita, kaos dalam, lingerie kualitas grosir & eceran.">

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    
    <!-- Custom Design System Stylesheet -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg hk-navbar" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand-hk" href="index.php#beranda">
                <img src="logohonkong2d.png" alt="Logo UD. Toko Hongkong" onerror="this.src='logohongkong.png'">
                <div class="brand-text-group">
                    <span class="brand-title">UD. TOKO HONGKONG</span>
                    <span class="brand-tagline">PASAR KAPASAN SURABAYA • EST. 1987</span>
                </div>
            </a>
            
            <button class="navbar-toggler hk-navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link hk-nav-link" href="index.php#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hk-nav-link" href="index.php#tentang">Tentang Kami</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link hk-nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kategori Produk
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm">
                            <li><a class="dropdown-item" href="atasan.php"><i class="fas fa-tshirt me-2"></i>Koleksi Atasan</a></li>
                            <li><a class="dropdown-item" href="bawahan.php"><i class="fas fa-male me-2"></i>Koleksi Bawahan</a></li>
                            <li><a class="dropdown-item fw-bold text-gold" href="dalaman.php"><i class="fas fa-heart me-2"></i>Pakaian Dalam</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hk-nav-link" href="index.php#gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hk-nav-link" href="index.php#reviews">Review Pelanggan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hk-nav-link" href="index.php#kontak">Kontak</a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a href="https://wa.me/6281357044752?text=Halo%20UD.%20Toko%20Hongkong,%20saya%20ingin%20tanya%20produk%20kategori%20pakaian%20dalam." target="_blank" class="btn-hk-whatsapp py-2 px-3">
                            <i class="fab fa-whatsapp me-2"></i>Hubungi Toko
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Catalog Hero Section -->
    <header class="catalog-hero">
        <div class="container">
            <div class="catalog-breadcrumb">
                <a href="index.php"><i class="fas fa-home me-1"></i>Beranda</a> 
                <span class="mx-2 text-muted">/</span> 
                <a href="index.php#kategori">Kategori</a> 
                <span class="mx-2 text-muted">/</span> 
                <span class="text-navy fw-bold"><?= htmlspecialchars($categoryTitle) ?></span>
            </div>
            
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-8" data-aos="fade-right">
                    <h1 class="catalog-title"><?= htmlspecialchars($categoryTitle) ?></h1>
                    <p class="catalog-desc mb-0">
                        <?= htmlspecialchars($categorySubtitle) ?>
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0" data-aos="fade-left">
                    <span class="badge bg-white text-navy border px-3 py-2 fs-6 shadow-xs">
                        <i class="fas fa-box-open text-gold me-2"></i><?= count($products) ?> Produk Tersedia
                    </span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content & Catalog -->
    <main class="py-5 bg-main">
        <div class="container">
            
            <!-- Filter Card Form -->
            <div class="filter-card" data-aos="fade-up">
                <div class="filter-card-header">
                    <h5><i class="fas fa-sliders-h text-gold"></i>Filter & Pencarian Produk</h5>
                    <?php if (!empty($search) || $minPrice !== null || $maxPrice !== null || !empty($gender) || !empty($size_input)): ?>
                        <a href="dalaman.php" class="text-danger fw-semibold fs-7 text-decoration-none">
                            <i class="fas fa-times-circle me-1"></i>Hapus Semua Filter
                        </a>
                    <?php endif; ?>
                </div>

                <form method="GET" action="dalaman.php" class="row g-3 align-items-end">
                    <!-- Search Input -->
                    <div class="col-lg-3 col-md-6">
                        <label class="filter-input-label">Cari Nama Produk</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control filter-input-control border-start-0 ps-0" placeholder="Underpants, Lingerie, Kaos Dalam..." value="<?= htmlspecialchars($search) ?>">
                        </div>
                    </div>

                    <!-- Min Price -->
                    <div class="col-lg-2 col-md-6 col-6">
                        <label class="filter-input-label">Harga Minimum</label>
                        <input type="number" name="minPrice" class="filter-input-control" placeholder="Rp Min" value="<?= htmlspecialchars($minPriceInput) ?>" min="0" step="5000">
                    </div>

                    <!-- Max Price -->
                    <div class="col-lg-2 col-md-6 col-6">
                        <label class="filter-input-label">Harga Maksimum</label>
                        <input type="number" name="maxPrice" class="filter-input-control" placeholder="Rp Max" value="<?= htmlspecialchars($maxPriceInput) ?>" min="0" step="5000">
                    </div>

                    <!-- Gender Select -->
                    <div class="col-lg-2 col-md-6 col-6">
                        <label class="filter-input-label">Jenis / Gender</label>
                        <select name="gender" class="filter-input-control">
                            <option value="">Semua Gender</option>
                            <option value="Pria" <?= $gender === 'Pria' ? 'selected' : '' ?>>Pria</option>
                            <option value="Wanita" <?= $gender === 'Wanita' ? 'selected' : '' ?>>Wanita</option>
                            <option value="Unisex" <?= $gender === 'Unisex' ? 'selected' : '' ?>>Unisex</option>
                        </select>
                    </div>

                    <!-- Size Range -->
                    <div class="col-lg-1 col-md-6 col-6">
                        <label class="filter-input-label">Ukuran</label>
                        <select name="size_range" class="filter-input-control">
                            <option value="">Semua</option>
                            <?php foreach ($size_order as $s): ?>
                                <option value="<?= $s ?>" <?= $size_input === $s ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-lg-2 col-md-12 d-flex gap-2">
                        <button type="submit" class="btn-hk-primary w-100 py-2">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <a href="dalaman.php" class="btn-hk-outline py-2 px-3" title="Reset Filter">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </form>
            </div>

            <!-- Active Filters Pill Bar -->
            <?php if (!empty($search) || $minPrice !== null || $maxPrice !== null || !empty($gender) || !empty($size_input)): ?>
                <div class="active-filters-bar mb-4">
                    <span class="text-muted fs-7 me-2 fw-semibold">Filter Aktif:</span>
                    <?php if (!empty($search)): ?>
                        <span class="filter-badge-pill">Cari: "<?= htmlspecialchars($search) ?>"</span>
                    <?php endif; ?>
                    <?php if ($minPrice !== null): ?>
                        <span class="filter-badge-pill">Min: Rp <?= number_format($minPrice, 0, ',', '.') ?></span>
                    <?php endif; ?>
                    <?php if ($maxPrice !== null): ?>
                        <span class="filter-badge-pill">Max: Rp <?= number_format($maxPrice, 0, ',', '.') ?></span>
                    <?php endif; ?>
                    <?php if (!empty($gender)): ?>
                        <span class="filter-badge-pill">Gender: <?= htmlspecialchars($gender) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($size_input)): ?>
                        <span class="filter-badge-pill">Ukuran: <?= htmlspecialchars($size_input) ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Product Grid -->
            <div class="product-catalog-grid">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $p): 
                        $thumb = getThumbPath($p['image'], $defaultFallbackImage);
                        $formattedPrice = !empty($p['price']) ? 'Rp ' . number_format($p['price'], 0, ',', '.') : 'Hubungi Toko';
                        $productGender = !empty($p['gender']) ? $p['gender'] : 'Unisex';
                        $productSize = !empty($p['size_range']) ? $p['size_range'] : 'S-XL';
                        $productStock = !empty($p['stock']) ? $p['stock'] : 20;
                    ?>
                        <div class="product-item-card" data-aos="fade-up">
                            <div class="product-card-thumb">
                                <img src="<?= $thumb ?>" alt="<?= htmlspecialchars($p['name']) ?>" onerror="this.src='<?= $defaultFallbackImage ?>'">
                                <span class="product-badge-gender"><?= htmlspecialchars($productGender) ?></span>
                                <span class="product-badge-stock">Stok: <?= $productStock ?></span>
                            </div>
                            
                            <div class="product-card-details">
                                <h5 class="product-card-name"><?= htmlspecialchars($p['name']) ?></h5>
                                <div class="product-card-price"><?= $formattedPrice ?></div>
                                
                                <div class="product-card-meta">
                                    <span>Ukuran:</span>
                                    <span class="product-size-tag"><?= htmlspecialchars($productSize) ?></span>
                                </div>
                                
                                <button type="button" class="product-btn-action" onclick="openProductModal(<?= $p['id'] ?>, '<?= addslashes(htmlspecialchars($p['name'])) ?>', '<?= $thumb ?>', '<?= $formattedPrice ?>', '<?= htmlspecialchars($productGender) ?>', '<?= htmlspecialchars($productSize) ?>', <?= $productStock ?>, 'Pakaian Dalam')">
                                    <i class="fas fa-eye me-1"></i>Detail & Pesan
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="empty-catalog-state">
                        <div class="empty-catalog-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h4>Tidak Ada Produk yang Sesuai</h4>
                        <p>Kami tidak menemukan produk pakaian dalam yang sesuai dengan filter pencarian Anda. Silakan coba atur ulang filter atau gunakan kata kunci lain.</p>
                        <a href="dalaman.php" class="btn-hk-primary">
                            <i class="fas fa-redo me-2"></i>Reset Filter Pencarian
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            
        </div>
    </main>

    <!-- Product Detail Modal -->
    <div class="modal fade modal-product-detail" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProductName">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-5">
                            <div class="modal-product-thumb">
                                <img id="modalProductImg" src="dress.png" alt="Produk">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <span class="badge bg-subtle text-navy border mb-2" id="modalProductCategory">Pakaian Dalam</span>
                            <h3 class="font-serif text-navy mb-2" id="modalProductTitle">Nama Produk</h3>
                            <div class="fs-4 fw-bold text-gold mb-3" id="modalProductPrice">Rp 0</div>
                            
                            <table class="modal-spec-table">
                                <tr>
                                    <td>Kategori</td>
                                    <td id="modalSpecCategory">Pakaian Dalam</td>
                                </tr>
                                <tr>
                                    <td>Gender / Tipe</td>
                                    <td id="modalSpecGender">Pria / Wanita</td>
                                </tr>
                                <tr>
                                    <td>Pilihan Ukuran</td>
                                    <td id="modalSpecSize">S - XL</td>
                                </tr>
                                <tr>
                                    <td>Ketersediaan Stok</td>
                                    <td><span class="badge bg-success-subtle text-success border" id="modalSpecStock">Tersedia</span></td>
                                </tr>
                                <tr>
                                    <td>Kualitas Bahan</td>
                                    <td>Katun halus bernapas, lembut di kulit, karet elastis nyaman tidak gatal.</td>
                                </tr>
                            </table>

                            <div class="mt-4 pt-3 border-top d-flex gap-2">
                                <a id="modalWhatsAppBtn" href="#" target="_blank" class="btn-hk-whatsapp flex-grow-1">
                                    <i class="fab fa-whatsapp me-2"></i>Pesan via WhatsApp Sekarang
                                </a>
                                <button type="button" class="btn-hk-outline" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="hk-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="logohonkong2d.png" alt="UD. Toko Hongkong" style="height: 38px;" onerror="this.src='logohongkong.png'">
                        <h5 class="m-0 font-serif text-white">UD. TOKO HONGKONG</h5>
                    </div>
                    <p class="footer-brand-desc">
                        Destinasi belanja busana terpercaya sejak 1987. Menyediakan aneka koleksi atasan, bawahan, dan pakaian dalam berkualitas dengan harga terbaik untuk keluarga dan kebutuhan bisnis sandang Anda.
                    </p>
                    <div class="footer-social-links">
                        <a href="https://wa.me/6281357044752" target="_blank" class="footer-social-btn"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="footer-social-btn"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="footer-social-btn"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-heading">Navigasi</h6>
                    <ul class="footer-links">
                        <li><a href="index.php#beranda"><i class="fas fa-angle-right"></i>Beranda</a></li>
                        <li><a href="index.php#tentang"><i class="fas fa-angle-right"></i>Tentang Kami</a></li>
                        <li><a href="index.php#kategori"><i class="fas fa-angle-right"></i>Kategori Produk</a></li>
                        <li><a href="index.php#gallery"><i class="fas fa-angle-right"></i>Galeri Produk</a></li>
                        <li><a href="index.php#reviews"><i class="fas fa-angle-right"></i>Review Pelanggan</a></li>
                        <li><a href="index.php#kontak"><i class="fas fa-angle-right"></i>Hubungi Kami</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-heading">Katalog Kategori</h6>
                    <ul class="footer-links">
                        <li><a href="atasan.php"><i class="fas fa-angle-right"></i>Koleksi Atasan (Kemeja & Kaos)</a></li>
                        <li><a href="bawahan.php"><i class="fas fa-angle-right"></i>Koleksi Bawahan (Jeans & Rok)</a></li>
                        <li><a href="dalaman.php" class="text-gold fw-semibold"><i class="fas fa-angle-right"></i>Pakaian Dalam (Underwear)</a></li>
                        <li><a href="login.php"><i class="fas fa-lock me-1"></i>Portal Admin Toko</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-heading">Informasi Toko</h6>
                    <div class="footer-contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Pasar Kapasan Baru Lt. I Blok 3 No. 19, Surabaya</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-phone-alt"></i>
                        <span>+62 813 5704 4752 / +62 856 0700 4686</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>info@tokohongkongkapasan.com</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-clock"></i>
                        <span>Senin - Sabtu: 08.00 - 17.00 WIB</span>
                    </div>
                </div>
            </div>

            <div class="footer-bottom-bar">
                <div>
                    &copy; 2025 <strong>UD. Toko Hongkong Kapasan</strong>. Hak Cipta Dilindungi.
                </div>
                <div>
                    <span>Pasar Kapasan Baru Surabaya • Pusat Fashion Terpercaya</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 700,
            easing: 'ease-out-cubic',
            once: true,
            offset: 60
        });

        // Navbar Scroll Effect
        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 40) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Function to Open Modal Detail
        function openProductModal(id, name, img, price, gender, size, stock, category) {
            document.getElementById('modalProductName').textContent = name;
            document.getElementById('modalProductTitle').textContent = name;
            document.getElementById('modalProductImg').src = img;
            document.getElementById('modalProductPrice').textContent = price;
            document.getElementById('modalProductCategory').textContent = category;
            document.getElementById('modalSpecCategory').textContent = category;
            document.getElementById('modalSpecGender').textContent = gender;
            document.getElementById('modalSpecSize').textContent = size;
            document.getElementById('modalSpecStock').textContent = `Tersedia (${stock} pcs)`;

            const waMsg = encodeURIComponent(`Halo UD. Toko Hongkong, saya ingin memesan produk:\n\n*${name}*\nKategori: ${category}\nHarga: ${price}\nUkuran: ${size}\n\nApakah stok masih tersedia untuk dipesan?`);
            document.getElementById('modalWhatsAppBtn').href = `https://wa.me/6281357044752?text=${waMsg}`;

            const modalEl = document.getElementById('productModal');
            const bsModal = new bootstrap.Modal(modalEl);
            bsModal.show();
        }
    </script>
</body>

</html>
