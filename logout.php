<?php
// logout.php - Admin Logout (MVC Entry Point)
require_once __DIR__ . '/app/bootstrap.php';

$controller = new AuthController();
$controller->logout();