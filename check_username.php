<?php
// check_username.php - Username Checker Tool (MVC Entry Point)
require_once __DIR__ . '/app/bootstrap.php';

$controller = new UserAdminController();
$controller->checkUsername();