<?php
// app/controllers/AuthController.php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/AuthHelper.php';

class AuthController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login(): void
    {
        AuthHelper::startSession();

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                AuthHelper::login((int) $user['id']);
                $this->redirect('manajemen_admin.php');
            } else {
                $error = 'Username atau password yang Anda masukkan salah.';
            }
        }

        $this->render('auth/login', [
            'error' => $error
        ]);
    }

    public function logout(): void
    {
        AuthHelper::startSession();

        // Check if user wants to logout
        if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
            AuthHelper::logout();
            $this->redirect('login.php');
        }

        // If user is not logged in, redirect to login
        if (!AuthHelper::isLoggedIn()) {
            $this->redirect('login.php');
        }

        $this->render('auth/logout');
    }
}
