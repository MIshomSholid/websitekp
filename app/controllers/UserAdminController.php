<?php
// app/controllers/UserAdminController.php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../helpers/AuthHelper.php';

class UserAdminController extends BaseController
{
    private User $userModel;
    private Product $productModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->productModel = new Product();
    }

    public function dashboard(): void
    {
        AuthHelper::requireLogin();

        try {
            $adminCount = $this->userModel->countTotal();
            $productCount = $this->productModel->countTotal();
            $activeProducts = $this->productModel->countActive();
            $admins = $this->userModel->getAllOrderedById();
        } catch (Exception $e) {
            $adminCount = 0;
            $productCount = 0;
            $activeProducts = 0;
            $admins = [];
        }

        $this->render('admin/dashboard', [
            'adminCount' => $adminCount,
            'productCount' => $productCount,
            'activeProducts' => $activeProducts,
            'admins' => $admins
        ]);
    }

    public function index(): void
    {
        AuthHelper::requireLogin();

        // Handle AJAX requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $this->handleAjax();
            return;
        }

        // Get all admins with search functionality
        $searchParam = isset($_GET['search']) ? trim($_GET['search']) : '';
        try {
            $admins = $this->userModel->getAll($searchParam);
            $total_admins = $this->userModel->countTotal();
        } catch (Exception $e) {
            die('Database error: ' . $e->getMessage());
        }

        $this->render('admin/users', [
            'admins' => $admins,
            'total_admins' => $total_admins,
            'searchParam' => $searchParam
        ]);
    }

    public function checkUsername(): void
    {
        AuthHelper::requireLogin();
        $this->render('admin/check_username');
    }

    private function handleAjax(): void
    {
        switch ($_POST['action']) {
            case 'add_admin':
                $username = trim($_POST['username'] ?? '');
                $password = $_POST['password'] ?? '';

                if (empty($username) || empty($password)) {
                    $this->json(['success' => false, 'message' => 'Username dan password harus diisi!']);
                }

                if ($this->userModel->usernameExists($username)) {
                    $this->json(['success' => false, 'message' => 'Username sudah terdaftar!']);
                }

                try {
                    $this->userModel->create($username, $password);
                    $this->json(['success' => true, 'message' => 'Admin baru berhasil ditambahkan!']);
                } catch (Exception $e) {
                    $this->json(['success' => false, 'message' => 'Gagal menambahkan admin: ' . $e->getMessage()]);
                }
                break;

            case 'edit_admin':
                $id = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
                $username = trim($_POST['username'] ?? '');
                $password = $_POST['password'] ?? '';

                if (!$id) {
                    $this->json(['success' => false, 'message' => 'ID admin tidak valid!']);
                }

                if (empty($username)) {
                    $this->json(['success' => false, 'message' => 'Username harus diisi!']);
                }

                if ($this->userModel->usernameExists($username, $id)) {
                    $this->json(['success' => false, 'message' => 'Username sudah digunakan oleh admin lain!']);
                }

                try {
                    $this->userModel->update($id, $username, $password);
                    $this->json(['success' => true, 'message' => 'Data admin berhasil diperbarui!']);
                } catch (Exception $e) {
                    $this->json(['success' => false, 'message' => 'Gagal mengupdate admin: ' . $e->getMessage()]);
                }
                break;

            case 'delete_admin':
                $id = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
                if (!$id) {
                    $this->json(['success' => false, 'message' => 'ID admin tidak valid!']);
                }

                if ($id == AuthHelper::getUserId()) {
                    $this->json(['success' => false, 'message' => 'Tidak dapat menghapus akun Anda sendiri yang sedang aktif!']);
                }

                try {
                    $this->userModel->delete($id);
                    $this->json(['success' => true, 'message' => 'Admin berhasil dihapus!']);
                } catch (Exception $e) {
                    $this->json(['success' => false, 'message' => 'Gagal menghapus admin: ' . $e->getMessage()]);
                }
                break;

            case 'get_admin':
                $id = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
                if (!$id) {
                    $this->json(['success' => false, 'message' => 'ID admin tidak valid!']);
                }

                try {
                    $admin = $this->userModel->findById($id);
                    if ($admin) {
                        $this->json(['success' => true, 'admin' => $admin]);
                    } else {
                        $this->json(['success' => false, 'message' => 'Admin tidak ditemukan!']);
                    }
                } catch (Exception $e) {
                    $this->json(['success' => false, 'message' => 'Gagal mengambil data admin!']);
                }
                break;

            default:
                $this->json(['success' => false, 'message' => 'Aksi tidak valid!']);
        }
    }
}
