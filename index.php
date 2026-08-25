<?php
// index.php - UD. Toko Hongkong Kapasan Official Website
require_once 'config.php';

try {
    $stmt = $pdo->query("SELECT * FROM products WHERE status = 'aktif' ORDER BY created_at DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $products = [];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD. Toko Hongkong Kapasan - Pusat Fashion Grosir & Eceran Surabaya</title>
    <meta name="description" content="UD. Toko Hongkong Kapasan adalah toko fashion terpercaya di Pasar Kapasan Baru Surabaya sejak 1987. Menyediakan aneka busana atasan, bawahan, dan pakaian dalam berkualitas grosir & eceran.">
    <meta name="keywords" content="toko hongkong kapasan, fashion surabaya, pasar kapasan baru, grosir baju kapasan, kemeja, celana jeans, pakaian dalam">

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
            <a class="navbar-brand-hk" href="#beranda">
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
                        <a class="nav-link hk-nav-link active" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hk-nav-link" href="#tentang">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hk-nav-link" href="#kategori">Kategori Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hk-nav-link" href="#gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hk-nav-link" href="#reviews">Review Pelanggan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hk-nav-link" href="#kontak">Kontak</a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a href="https://wa.me/6281357044752?text=Halo%20UD.%20Toko%20Hongkong%20Kapasan,%20saya%20tertarik%20melihat%20katalog%20produk%20dan%20informasi%20pembelian." target="_blank" class="btn-hk-whatsapp py-2 px-3">
                            <i class="fab fa-whatsapp me-2"></i>Hubungi Toko
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="900">
                    <div class="hero-badge">
                        <i class="fas fa-award text-gold"></i>
                        <span>Pusat Fashion Pasar Kapasan Surabaya • Est. 1987</span>
                    </div>
                    <h1 class="hero-title">
                        Pusat Busana Berkualitas, <span class="text-gold-highlight">Pilihan Terpercaya</span> Keluarga & Bisnis.
                    </h1>
                    <p class="hero-subtitle">
                        Menyediakan aneka koleksi atasan, bawahan, dan pakaian dalam pilihan dengan bahan berkualitas tinggi dan harga grosir maupun eceran langsung dari pusat perdagangan fashion legendaris Pasar Kapasan Baru Surabaya.
                    </p>
                    
                    <div class="hero-cta-group">
                        <a href="#kategori" class="btn-hk-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Lihat Koleksi Produk
                        </a>
                        <a href="#tentang" class="btn-hk-outline">
                            Tentang Kami
                        </a>
                    </div>
                    
                    <div class="hero-trust-list">
                        <div class="hero-trust-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Grosir & Eceran</span>
                        </div>
                        <div class="hero-trust-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Bahan Pilihan & Nyaman</span>
                        </div>
                        <div class="hero-trust-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Pengiriman Seluruh Indonesia</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="900" data-aos-delay="200">
                    <div class="hero-visual-wrapper">
                        <!-- Main Mascot Showcase -->
                        <div class="hero-main-card">
                            <img src="maskot.png" alt="Maskot UD. Toko Hongkong" class="hero-main-img" onerror="this.src='logohongkong.png'">
                        </div>
                        
                        <!-- Floating Heritage Badge -->
                        <div class="floating-heritage-badge">
                            <div class="badge-icon">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="badge-text">
                                <h6>38+ Tahun Terpercaya</h6>
                                <p>Pasar Kapasan Surabaya</p>
                            </div>
                        </div>
                        
                        <!-- Floating Quality Tag -->
                        <div class="floating-tag-badge">
                            <i class="fas fa-shield-alt"></i>
                            <span>Kualitas Bahan Terjamin</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="section-padding about-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5" data-aos="fade-right" data-aos-duration="800">
                    <div class="about-visual-box">
                        <div class="about-image-card">
                            <img src="logohongkong2.png" alt="UD. Toko Hongkong Sejak 1987" onerror="this.src='logohongkong.png'">
                        </div>
                        <div class="about-location-pill">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong>Lokasi Toko Fisik:</strong>
                                <span>Pasar Kapasan Baru Lt. I Blok 3 No. 19 Surabaya</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-7" data-aos="fade-left" data-aos-duration="800" data-aos-delay="150">
                    <div class="about-content-box">
                        <div class="section-eyebrow">
                            <i class="fas fa-history"></i>
                            <span>WARISAN & KUALITAS SEJAK 1987</span>
                        </div>
                        <h2 class="section-title">Dedikasi Menghadirkan Busana Berkualitas untuk Setiap Generasi</h2>
                        <p class="about-lead">
                            UD. Toko Hongkong adalah destinasi belanja busana yang telah menjadi mitra setia masyarakat Surabaya dan sekitarnya selama lebih dari 38 tahun.
                        </p>
                        <p class="about-text">
                            Berlokasi di pusat grosir pakaian terkemuka Pasar Kapasan Baru Surabaya, kami berkomitmen menghadirkan aneka ragam sandang mulai dari pakaian formal, kasual, hingga kebutuhan pakaian dalam harian dengan jaminan kualitas bahan terbaik serta harga yang sangat bersaing.
                        </p>
                        
                        <!-- Value Pillars -->
                        <div class="value-pillars-grid">
                            <div class="value-pillar-item">
                                <div class="pillar-icon">
                                    <i class="fas fa-tshirt"></i>
                                </div>
                                <div class="pillar-content">
                                    <h6>Koleksi Lengkap & Selalu Up-to-Date</h6>
                                    <p>Variasi pakaian atasan, bawahan, dan pakaian dalam untuk pria, wanita, hingga keluarga dengan model terkini.</p>
                                </div>
                            </div>
                            
                            <div class="value-pillar-item">
                                <div class="pillar-icon">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <div class="pillar-content">
                                    <h6>Harga Grosir & Eceran Bersahabat</h6>
                                    <p>Memberikan keuntungan terbaik untuk pembeli perorangan maupun pemilik usaha toko dan reseller.</p>
                                </div>
                            </div>
                            
                            <div class="value-pillar-item">
                                <div class="pillar-icon">
                                    <i class="fas fa-hand-holding-heart"></i>
                                </div>
                                <div class="pillar-content">
                                    <h6>Pelayanan Terpercaya & Berpengalaman</h6>
                                    <p>Lebih dari tiga dekade melayani dengan integritas, kejujuran kualitas, dan kepuasan pelanggan.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Stats Counter Bar -->
                        <div class="stats-counter-bar">
                            <div class="stat-box">
                                <div class="stat-num">38+</div>
                                <div class="stat-lbl">Tahun Pengalaman</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-num">1000+</div>
                                <div class="stat-lbl">Variasi Produk</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-num">7000+</div>
                                <div class="stat-lbl">Produk Terdistribusi</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-num">99%</div>
                                <div class="stat-lbl">Kepuasan Pelanggan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Section -->
    <section id="kategori" class="section-padding category-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-eyebrow">
                    <i class="fas fa-layer-group"></i>
                    <span>KATALOG KOLEKSI</span>
                </div>
                <h2 class="section-title">Kategori Busana Pilihan</h2>
                <p class="section-subtitle">
                    Jelajahi berbagai pilihan busana yang dirancang dengan material nyaman dan potongan pas untuk melengkapi penampilan Anda setiap hari.
                </p>
            </div>

            <div class="category-editorial-grid">
                <!-- Atasan -->
                <div class="category-editorial-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="category-card-media">
                        <img src="Uploads/685ed85fd19d8.png" alt="Koleksi Atasan" onerror="this.src='kaos.png'">
                        <div class="category-card-badge">Kategori 01</div>
                    </div>
                    <div class="category-card-body">
                        <h4 class="category-card-title">Koleksi Atasan</h4>
                        <p class="category-card-desc">
                            Lengkapi gaya formal maupun santai dengan aneka kemeja pria/wanita, kaos katun premium, serta blouse elegan berbahan adem.
                        </p>
                        <div class="category-highlight-pills">
                            <span class="cat-pill">Kaos Polos</span>
                            <span class="cat-pill">Kemeja Formal</span>
                            <span class="cat-pill">Blouse Wanita</span>
                            <span class="cat-pill">Outerwear</span>
                        </div>
                        <div class="category-card-action">
                            <a href="atasan.php" class="category-link-btn">
                                Lihat Semua Koleksi Atasan <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bawahan -->
                <div class="category-editorial-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="category-card-media">
                        <img src="suit.png" alt="Koleksi Bawahan" onerror="this.src='suit.png'">
                        <div class="category-card-badge">Kategori 02</div>
                    </div>
                    <div class="category-card-body">
                        <h4 class="category-card-title">Koleksi Bawahan</h4>
                        <p class="category-card-desc">
                            Pilihan celana jeans tangguh, celana panjang formal, hingga aneka rok motif dan polos yang fleksibel untuk mobilitas harian.
                        </p>
                        <div class="category-highlight-pills">
                            <span class="cat-pill">Celana Jeans</span>
                            <span class="cat-pill">Celana Formal</span>
                            <span class="cat-pill">Rok Motif & Polos</span>
                            <span class="cat-pill">Celana Santai</span>
                        </div>
                        <div class="category-card-action">
                            <a href="bawahan.php" class="category-link-btn">
                                Lihat Semua Koleksi Bawahan <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pakaian Dalam -->
                <div class="category-editorial-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="category-card-media">
                        <img src="Uploads/685ede693f271.png" alt="Pakaian Dalam" onerror="this.src='dress.png'">
                        <div class="category-card-badge">Kategori 03</div>
                    </div>
                    <div class="category-card-body">
                        <h4 class="category-card-title">Pakaian Dalam</h4>
                        <p class="category-card-desc">
                            Kenyamanan mendasar setiap hari dengan underpants pria, underwear wanita lembut, kaos dalam katun, hingga lingerie berkualitas.
                        </p>
                        <div class="category-highlight-pills">
                            <span class="cat-pill">Underpants Pria</span>
                            <span class="cat-pill">Underwear Wanita</span>
                            <span class="cat-pill">Kaos Dalam</span>
                            <span class="cat-pill">Lingerie</span>
                        </div>
                        <div class="category-card-action">
                            <a href="dalaman.php" class="category-link-btn">
                                Lihat Semua Pakaian Dalam <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="section-padding gallery-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-eyebrow">
                    <i class="fas fa-camera"></i>
                    <span>LOOKBOOK & GALLERY</span>
                </div>
                <h2 class="section-title">Galeri Produk & Suasana Toko</h2>
                <p class="section-subtitle">
                    Koleksi nyata produk-produk favorit yang siap melengkapi gaya harian maupun kebutuhan usaha busana Anda.
                </p>
            </div>

            <div class="gallery-grid-editorial">
                <!-- Gallery 1 -->
                <div class="gallery-card" data-aos="zoom-in" data-aos-delay="100" onclick="showGalleryToast('Koleksi Kaos Premium Cotton')">
                    <img src="kaos.png" alt="Koleksi Kaos Premium">
                    <div class="gallery-card-overlay">
                        <span class="gallery-card-tag">Atasan Casual</span>
                        <h5 class="gallery-card-title">Koleksi Kaos Premium Cotton</h5>
                    </div>
                </div>

                <!-- Gallery 2 -->
                <div class="gallery-card" data-aos="zoom-in" data-aos-delay="200" onclick="showGalleryToast('Koleksi Fashion Wanita & Dress')">
                    <img src="dress.png" alt="Fashion Wanita">
                    <div class="gallery-card-overlay">
                        <span class="gallery-card-tag">Fashion Wanita</span>
                        <h5 class="gallery-card-title">Busana & Dress Feminin</h5>
                    </div>
                </div>

                <!-- Gallery 3 -->
                <div class="gallery-card" data-aos="zoom-in" data-aos-delay="300" onclick="showGalleryToast('Koleksi Busana Formal Pria')">
                    <img src="suit.png" alt="Fashion Pria">
                    <div class="gallery-card-overlay">
                        <span class="gallery-card-tag">Fashion Pria</span>
                        <h5 class="gallery-card-title">Kemeja & Celana Formal</h5>
                    </div>
                </div>

                <!-- Gallery 4 -->
                <div class="gallery-card" data-aos="zoom-in" data-aos-delay="400" onclick="showGalleryToast('Koleksi Busana Keluarga & Anak')">
                    <img src="kids.png" alt="Fashion Anak">
                    <div class="gallery-card-overlay">
                        <span class="gallery-card-tag">Keluarga & Anak</span>
                        <h5 class="gallery-card-title">Busana Keluarga & Anak</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section id="reviews" class="section-padding review-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-eyebrow">
                    <i class="fas fa-star text-gold"></i>
                    <span>TESTIMONIAL PELANGGAN</span>
                </div>
                <h2 class="section-title">Ulasan & Kepercayaan Pelanggan</h2>
                <p class="section-subtitle">
                    Pengalaman nyata para pelanggan setia yang telah berbelanja di UD. Toko Hongkong Pasar Kapasan Surabaya.
                </p>
            </div>

            <div class="reviews-slider-track">
                <!-- Testimonial 1 -->
                <div class="review-editorial-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="review-rating-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-quote-text">
                        "Pakaiannya sangat berkualitas, bahannya nyaman dan adem dipakai seharian. Harganya sangat bersahabat untuk belanja grosir maupun eceran. Pelayanan toko sangat ramah dan profesional!"
                    </p>
                    <div class="review-author-group">
                        <div class="author-avatar-initial">A</div>
                        <div class="author-info">
                            <h6>Ahmad S.</h6>
                            <span>Pelanggan Setia Surabaya • 17 Okt 2025</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="review-editorial-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="review-rating-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="review-quote-text">
                        "Koleksi blouse dan roknya sangat cantik serta jahitannya rapi. Saya sering ambil stok untuk toko online saya di Sidoarjo, barang selalu cepat laku dan pelanggan puas."
                    </p>
                    <div class="review-author-group">
                        <div class="author-avatar-initial">R</div>
                        <div class="author-info">
                            <h6>Rina W.</h6>
                            <span>Reseller Sidoarjo • 15 Okt 2025</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="review-editorial-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="review-rating-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-quote-text">
                        "Pilihan pakaian anak dan kebutuhan pakaian dalam keluarga sangat lengkap di sini. Bahan katunnya lembut, tidak panas, dan awet dicuci berkali-kali."
                    </p>
                    <div class="review-author-group">
                        <div class="author-avatar-initial">D</div>
                        <div class="author-info">
                            <h6>Dewi L.</h6>
                            <span>Gresik • 4 Jun 2025</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 4 -->
                <div class="review-editorial-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="review-rating-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="review-quote-text">
                        "Koleksi kemeja pria dan jaketnya sangat variatif. Dari dulu keluarga kami kalau belanja baju di Pasar Kapasan selalu langsung menuju ke UD. Toko Hongkong."
                    </p>
                    <div class="review-author-group">
                        <div class="author-avatar-initial">Z</div>
                        <div class="author-info">
                            <h6>Zuhri A.</h6>
                            <span>Surabaya • 17 Feb 2025</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 5 -->
                <div class="review-editorial-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="review-rating-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-quote-text">
                        "Desain modern dan bahan tidak mudah kusut. Sangat cocok dipakai kerja kantoran maupun hangout santai. Kualitasnya jauh melampaui harga yang dibayarkan."
                    </p>
                    <div class="review-author-group">
                        <div class="author-avatar-initial">R</div>
                        <div class="author-info">
                            <h6>Rangga T.</h6>
                            <span>Malang • 22 Sep 2025</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 6 -->
                <div class="review-editorial-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="review-rating-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-quote-text">
                        "Toko sandang paling terpercaya di Kapasan. Pembelian partai besar selalu dilayani dengan cepat, ada garansi barang, dan diskon grosir yang menguntungkan."
                    </p>
                    <div class="review-author-group">
                        <div class="author-avatar-initial">A</div>
                        <div class="author-info">
                            <h6>Attila B.</h6>
                            <span>Surabaya • 7 Mar 2025</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Summary Banner -->
            <div class="reviews-summary-banner" data-aos="fade-up">
                <div class="summary-rating-badge">
                    <div class="rating-big-number">4.8</div>
                    <div class="rating-summary-text">
                        <h5>Rata-Rata Kepuasan Pelanggan</h5>
                        <p>Berdasarkan lebih dari 600+ ulasan pembeli terverifikasi</p>
                    </div>
                </div>
                <div>
                    <a href="https://wa.me/6281357044752?text=Halo%20UD.%20Toko%20Hongkong,%20saya%20ingin%20tanya%20produk%20dan%20layanan." target="_blank" class="btn-hk-gold">
                        <i class="fab fa-whatsapp me-2"></i>Konsultasi Produk via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontak" class="section-padding contact-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-eyebrow">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>KUNJUNGI KAMI</span>
                </div>
                <h2 class="section-title">Lokasi Toko & Kontak Resmi</h2>
                <p class="section-subtitle">
                    Kunjungi toko fisik kami di Pasar Kapasan Surabaya atau hubungi layanan pelanggan kami untuk konsultasi dan pemesanan.
                </p>
            </div>

            <div class="row g-4 align-items-stretch">
                <!-- Info Column -->
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="contact-card-box">
                        <h4 class="font-serif text-navy mb-3">Informasi Kontak & Jam Buka</h4>
                        <p class="text-muted mb-4">Kami siap melayani kebutuhan pembelian pakaian eceran maupun partai grosir untuk seluruh wilayah Indonesia.</p>
                        
                        <div class="contact-info-list">
                            <div class="contact-info-item">
                                <div class="contact-info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-info-text">
                                    <h6>Alamat Toko Fisik</h6>
                                    <p>Pasar Kapasan Baru Lt. I Blok 3 No. 19, Surabaya, Jawa Timur</p>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="contact-info-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="contact-info-text">
                                    <h6>Jam Operasional</h6>
                                    <p>
                                        Senin – Sabtu: 08.00 – 17.00 WIB<br>
                                        Minggu: 09.00 – 15.00 WIB
                                    </p>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="contact-info-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="contact-info-text">
                                    <h6>Telepon / Hotline</h6>
                                    <p>
                                        <a href="tel:+6281357044752">+62 813 5704 4752</a> / 
                                        <a href="tel:+6285607004686">+62 856 0700 4686</a>
                                    </p>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="contact-info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-info-text">
                                    <h6>Email Resmi</h6>
                                    <p><a href="mailto:info@tokohongkongkapasan.com">info@tokohongkongkapasan.com</a></p>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="contact-info-icon" style="background:#25d366; color:#fff;">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div class="contact-info-text">
                                    <h6>Layanan WhatsApp Fast Response</h6>
                                    <p>
                                        <a href="https://wa.me/6281357044752?text=Halo%20UD.%20Toko%20Hongkong,%20saya%20ingin%20bertanya%20tentang%20produk%20fashion." target="_blank" class="fw-bold text-success">
                                            +62 813 5704 4752 (Klik untuk Chat)
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Column -->
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="map-card-box">
                        <h4 class="font-serif text-navy mb-3">Peta Lokasi Pasar Kapasan Baru</h4>
                        <div class="map-embed-wrapper">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.940742131976!2d112.74831687588147!3d-7.247573971189429!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7f917ca218151%3A0x6e9f2ee182df5e0c!2sPasar%20Kapasan%20Baru!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade"
                                title="Peta Lokasi UD Toko Hongkong di Pasar Kapasan Baru Surabaya">
                            </iframe>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <div>
                                <small class="text-muted d-block">Akses mudah dari seluruh penjuru Surabaya.</small>
                                <span class="badge bg-subtle text-navy fw-semibold">Lt. I Blok 3 No. 19</span>
                            </div>
                            <a href="https://maps.google.com/?q=Pasar+Kapasan+Baru+Surabaya" target="_blank" class="btn-hk-outline py-2 px-3">
                                <i class="fas fa-directions me-1"></i>Buka di Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="hk-footer">
        <div class="container">
            <div class="row g-4">
                <!-- Col 1: Brand Info -->
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="logohonkong2d.png" alt="UD. Toko Hongkong" style="height: 38px;" onerror="this.src='logohongkong.png'">
                        <h5 class="m-0 font-serif text-white">UD. TOKO HONGKONG</h5>
                    </div>
                    <p class="footer-brand-desc">
                        Destinasi belanja busana terpercaya sejak 1987. Menyediakan koleksi atasan, bawahan, dan pakaian dalam berkualitas dengan harga terbaik untuk keluarga dan kebutuhan bisnis sandang Anda.
                    </p>
                    <div class="footer-social-links">
                        <a href="https://wa.me/6281357044752" target="_blank" class="footer-social-btn" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="footer-social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="footer-social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-heading">Navigasi</h6>
                    <ul class="footer-links">
                        <li><a href="#beranda"><i class="fas fa-angle-right"></i>Beranda</a></li>
                        <li><a href="#tentang"><i class="fas fa-angle-right"></i>Tentang Kami</a></li>
                        <li><a href="#kategori"><i class="fas fa-angle-right"></i>Kategori Produk</a></li>
                        <li><a href="#gallery"><i class="fas fa-angle-right"></i>Galeri Produk</a></li>
                        <li><a href="#reviews"><i class="fas fa-angle-right"></i>Review Pelanggan</a></li>
                        <li><a href="#kontak"><i class="fas fa-angle-right"></i>Hubungi Kami</a></li>
                    </ul>
                </div>

                <!-- Col 3: Catalog Links -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-heading">Katalog Produk</h6>
                    <ul class="footer-links">
                        <li><a href="atasan.php"><i class="fas fa-angle-right"></i>Koleksi Atasan (Kemeja & Kaos)</a></li>
                        <li><a href="bawahan.php"><i class="fas fa-angle-right"></i>Koleksi Bawahan (Jeans & Rok)</a></li>
                        <li><a href="dalaman.php"><i class="fas fa-angle-right"></i>Pakaian Dalam (Underwear)</a></li>
                        <li><a href="login.php"><i class="fas fa-lock me-1"></i>Portal Admin Toko</a></li>
                    </ul>
                </div>

                <!-- Col 4: Store Contact -->
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
                    &copy; 2025 <strong>UD. Toko Hongkong Kapasan</strong>. Hak Cipta Dilindungi Undang-Undang.
                </div>
                <div>
                    <span class="text-light-muted">Pasar Kapasan Baru Surabaya • Pusat Fashion Terpercaya</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Notification Container -->
    <div id="galleryToast" class="custom-alert-toast">
        <i class="fas fa-info-circle text-gold me-2"></i>
        <span id="toastMessage">Informasi produk dipilih</span>
    </div>

    <!-- JavaScript Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>
        // Initialize AOS Animation
        AOS.init({
            duration: 750,
            easing: 'ease-out-cubic',
            once: true,
            offset: 80
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

        // Smooth Scroll with Navbar Offset & Auto Collapse on Mobile
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href').substring(1);
                if (!targetId) return;
                
                const targetEl = document.getElementById(targetId);
                if (targetEl) {
                    e.preventDefault();
                    
                    // Close mobile menu if open
                    const navbarCollapse = document.getElementById('navbarNav');
                    if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                        const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                        if (bsCollapse) bsCollapse.hide();
                    }
                    
                    const navHeight = document.getElementById('mainNavbar').offsetHeight || 75;
                    const elementPosition = targetEl.getBoundingClientRect().top + window.scrollY;
                    const offsetPosition = elementPosition - navHeight + 10;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Active Link on Scroll Spy
        window.addEventListener('scroll', function () {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.hk-nav-link');
            const navHeight = document.getElementById('mainNavbar').offsetHeight || 75;
            let current = '';

            sections.forEach(section => {
                const sectionTop = section.offsetTop - navHeight - 30;
                const sectionHeight = section.offsetHeight;
                if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });

        // Toast Helper
        function showGalleryToast(message) {
            const toast = document.getElementById('galleryToast');
            const msgEl = document.getElementById('toastMessage');
            if (toast && msgEl) {
                msgEl.textContent = message;
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            }
        }
    </script>
</body>

</html>
