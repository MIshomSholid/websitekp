<?php
// manajemen_admin.php - Dashboard Manajemen Admin (MVC Entry Point)
require_once __DIR__ . '/app/bootstrap.php';

$controller = new UserAdminController();
$controller->dashboard();
