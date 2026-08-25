<?php
// index.php - UD. Toko Hongkong Kapasan Official Website (MVC Entry Point)
require_once __DIR__ . '/app/bootstrap.php';

$controller = new HomeController();
$controller->index();
