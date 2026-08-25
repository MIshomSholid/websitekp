<?php
// config.php - Database Configuration Bridge for Backward Compatibility
require_once __DIR__ . '/app/config/Database.php';

$pdo = Database::getConnection();