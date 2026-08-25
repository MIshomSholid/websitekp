<?php
// login.php - Portal Admin Login (MVC Entry Point)
require_once __DIR__ . '/app/bootstrap.php';

$controller = new AuthController();
$controller->login();
