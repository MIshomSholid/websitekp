<?php
// atasan.php - UD. Toko Hongkong Kapasan (MVC Entry Point)
require_once __DIR__ . '/app/bootstrap.php';

$controller = new CatalogController();
$controller->atasan();
