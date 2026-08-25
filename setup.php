<?php
// setup.php
require_once 'config.php';

try {
    // Create users table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL
        )
    ");

    // Create products table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            image VARCHAR(255),
            status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Insert default admin user if not exists
    $username = 'admin';
    $password = password_hash('admin123', PASSWORD_DEFAULT); // Hash the password
    $stmt = $pdo->prepare("INSERT IGNORE INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    echo "Database setup completed successfully! Default user: admin/admin123";
} catch (PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
?>