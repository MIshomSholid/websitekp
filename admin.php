<?php
// admin.php - Kelola Produk Admin (MVC Entry Point)
require_once __DIR__ . '/app/bootstrap.php';

$controller = new ProductAdminController();
$controller->index();