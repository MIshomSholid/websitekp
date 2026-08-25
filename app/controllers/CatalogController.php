<?php
// app/controllers/CatalogController.php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../helpers/UploadHelper.php';

class CatalogController extends BaseController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function atasan(): void
    {
        $this->showCategory(
            'atasan',
            'Koleksi Atasan',
            'Koleksi lengkap kemeja formal & casual, kaos katun polos premium, blouse wanita, dan busana atasan berkualitas terbaik dengan harga grosir & eceran.',
            'Katalog Koleksi Atasan UD. Toko Hongkong Kapasan Surabaya. Kemeja formal & casual, kaos polos premium, blouse wanita grosir & eceran.',
            'assets/images/kaos.png',
            'Kemeja, Kaos, Blouse...',
            'atasan.php'
        );
    }

    public function bawahan(): void
    {
        $this->showCategory(
            'bawahan',
            'Koleksi Bawahan',
            'Pilihan celana jeans tangguh, celana panjang formal kerja, celana santai kasual, serta aneka rok wanita motif dan polos berkualitas tinggi dengan harga grosir & eceran.',
            'Katalog Koleksi Bawahan UD. Toko Hongkong Kapasan Surabaya. Celana jeans, celana formal, rok wanita berkualitas grosir & eceran.',
            'assets/images/suit.png',
            'Celana Jeans, Rok, Formal...',
            'bawahan.php'
        );
    }

    public function dalaman(): void
    {
        $this->showCategory(
            'dalaman',
            'Pakaian Dalam',
            'Koleksi pakaian dalam pria & wanita, underpants katun halus, kaos dalam bernapas, serta lingerie elegan dengan kenyamanan maksimal untuk aktivitas harian Anda.',
            'Katalog Koleksi Pakaian Dalam UD. Toko Hongkong Kapasan Surabaya. Underpants pria, underwear wanita lembut, kaos dalam katun, lingerie berkualitas.',
            'assets/images/dress.png',
            'Underpants, Lingerie, Kaos Dalam...',
            'dalaman.php'
        );
    }

    private function showCategory(
        string $category,
        string $title,
        string $subtitle,
        string $metaDescription,
        string $fallbackImage,
        string $searchPlaceholder,
        string $actionUrl
    ): void {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $maxPriceInput = isset($_GET['maxPrice']) ? trim($_GET['maxPrice']) : '';
        $minPriceInput = isset($_GET['minPrice']) ? trim($_GET['minPrice']) : '';
        $minPrice = ($minPriceInput !== '' && is_numeric($minPriceInput)) ? (float) $minPriceInput : null;
        $maxPrice = ($maxPriceInput !== '' && is_numeric($maxPriceInput)) ? (float) $maxPriceInput : null;
        $size_input = isset($_GET['size_range']) ? strtoupper(trim($_GET['size_range'])) : '';
        $gender = isset($_GET['gender']) ? trim($_GET['gender']) : '';
        $size_order = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'];

        $products = $this->productModel->getByCategoryFiltered(
            $category,
            $search,
            $minPrice,
            $maxPrice,
            $gender,
            $size_input
        );

        $this->render('public/catalog', [
            'currentCategory' => $category,
            'categoryTitle' => $title,
            'categorySubtitle' => $subtitle,
            'categoryMetaDescription' => $metaDescription,
            'defaultFallbackImage' => $fallbackImage,
            'searchPlaceholder' => $searchPlaceholder,
            'actionUrl' => $actionUrl,
            'products' => $products,
            'search' => $search,
            'minPriceInput' => $minPriceInput,
            'maxPriceInput' => $maxPriceInput,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'size_input' => $size_input,
            'gender' => $gender,
            'size_order' => $size_order
        ]);
    }
}
