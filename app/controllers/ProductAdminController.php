<?php
// app/controllers/ProductAdminController.php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../helpers/AuthHelper.php';
require_once __DIR__ . '/../helpers/UploadHelper.php';

class ProductAdminController extends BaseController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function index(): void
    {
        date_default_timezone_set('Asia/Jakarta');
        AuthHelper::requireLogin();

        // Handle AJAX requests
        if (isset($_POST['action'])) {
            $this->handleAjax();
            return;
        }

        // Get products by category
        $categories = ['atasan', 'bawahan', 'dalaman'];
        $productsByCategory = [];
        foreach ($categories as $category) {
            $productsByCategory[$category] = $this->productModel->getByCategory($category);
        }

        // Get statistics
        $totalProducts = array_sum(array_map('count', $productsByCategory));
        $activeProducts = array_sum(array_map(function ($products) {
            return count(array_filter($products, fn($p) => $p['status'] === 'aktif'));
        }, $productsByCategory));

        $this->render('admin/products', [
            'categories' => $categories,
            'productsByCategory' => $productsByCategory,
            'totalProducts' => $totalProducts,
            'activeProducts' => $activeProducts
        ]);
    }

    private function handleAjax(): void
    {
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
                        $image = UploadHelper::uploadImage($_FILES['image']);
                    }

                    $status = $_POST['status'] ?? 'aktif';
                    if (!in_array($status, ['aktif', 'nonaktif'])) {
                        throw new Exception('Status tidak valid!');
                    }

                    $lastId = $this->productModel->create([
                        'name' => $name,
                        'category' => $category,
                        'price' => $price,
                        'stock' => $stock,
                        'gender' => $gender,
                        'size_range' => $size_range,
                        'image' => $image,
                        'status' => $status
                    ]);

                    $createdAt = date('d/m/Y H:i');

                    $this->json([
                        'success' => true,
                        'message' => "Produk $category telah berhasil ditambahkan!",
                        'data' => [
                            'id' => $lastId,
                            'name' => $name,
                            'category' => $category,
                            'price' => $price,
                            'stock' => $stock,
                            'gender' => $gender,
                            'size_range' => $size_range,
                            'image' => $image,
                            'status' => $status,
                            'created_at' => $createdAt
                        ]
                    ]);
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

                    $currentProduct = $this->productModel->getById($id);
                    if (!$currentProduct) {
                        throw new Exception('Produk tidak ditemukan!');
                    }

                    $image = $currentProduct['image'];
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        if ($image) {
                            UploadHelper::deleteImage($image);
                        }
                        $image = UploadHelper::uploadImage($_FILES['image']);
                    }

                    $status = $_POST['status'] ?? 'aktif';
                    if (!in_array($status, ['aktif', 'nonaktif'])) {
                        throw new Exception('Status tidak valid!');
                    }

                    $this->productModel->update($id, [
                        'name' => $name,
                        'category' => $category,
                        'price' => $price,
                        'stock' => $stock,
                        'gender' => $gender,
                        'size_range' => $size_range,
                        'image' => $image,
                        'status' => $status
                    ]);

                    $updatedProduct = $this->productModel->getById($id);
                    $updatedProduct['created_at'] = UploadHelper::formatDate($updatedProduct['created_at']);

                    $this->json([
                        'success' => true,
                        'message' => 'Produk berhasil diperbarui!',
                        'data' => $updatedProduct
                    ]);
                    break;

                case 'delete_product':
                    $id = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
                    if (!$id) {
                        throw new Exception('ID produk tidak valid!');
                    }

                    $product = $this->productModel->getById($id);
                    if ($product) {
                        if ($product['image']) {
                            UploadHelper::deleteImage($product['image']);
                        }
                        $this->productModel->delete($id);
                        $this->json(['success' => true, 'message' => 'Produk berhasil dihapus!']);
                    } else {
                        throw new Exception('Produk tidak ditemukan!');
                    }
                    break;

                case 'get_product':
                    $id = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
                    if (!$id) {
                        throw new Exception('ID produk tidak valid!');
                    }
                    $product = $this->productModel->getById($id);
                    if ($product) {
                        $product['created_at'] = UploadHelper::formatDate($product['created_at']);
                        $this->json(['success' => true, 'data' => $product]);
                    } else {
                        throw new Exception('Produk tidak ditemukan!');
                    }
                    break;

                case 'toggle_status':
                    $id = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
                    if (!$id) {
                        throw new Exception('ID produk tidak valid!');
                    }
                    $this->productModel->toggleStatus($id);
                    $status = $this->productModel->getStatusById($id);

                    $this->json([
                        'success' => true,
                        'message' => 'Status berhasil diubah!',
                        'status' => $status
                    ]);
                    break;

                default:
                    throw new Exception('Aksi tidak valid!');
            }
        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
