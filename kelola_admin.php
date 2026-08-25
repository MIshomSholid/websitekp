<?php
// kelola_admin.php - Kelola Admin Management (MVC Entry Point)
require_once __DIR__ . '/app/bootstrap.php';

$controller = new UserAdminController();
$controller->index();
