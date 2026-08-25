<?php
// app/models/Product.php

require_once __DIR__ . '/../config/Database.php';

class Product
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAllActive(): array
    {
        try {
            $stmt = $this->db->query("SELECT * FROM products WHERE status = 'aktif' ORDER BY created_at DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in Product::getAllActive: " . $e->getMessage());
            return [];
        }
    }

    public function getByCategoryFiltered(
        string $category,
        string $search = '',
        ?float $minPrice = null,
        ?float $maxPrice = null,
        string $gender = '',
        string $sizeInput = ''
    ): array {
        $sizeOrder = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'];

        try {
            $sql = "SELECT id, name, image, category, status, price, stock, gender, size_range, created_at 
                    FROM products 
                    WHERE category = :category 
                    AND status = 'aktif'";
            
            $params = [':category' => $category];

            // Price Filter
            if ($minPrice !== null && $maxPrice !== null) {
                $sql .= " AND price BETWEEN :minPrice AND :maxPrice";
                $params[':minPrice'] = $minPrice;
                $params[':maxPrice'] = $maxPrice;
            } elseif ($minPrice !== null) {
                $sql .= " AND price >= :minPrice";
                $params[':minPrice'] = $minPrice;
            } elseif ($maxPrice !== null) {
                $sql .= " AND price <= :maxPrice";
                $params[':maxPrice'] = $maxPrice;
            }

            // Search Filter
            if (!empty($search)) {
                $sql .= " AND name LIKE :search";
                $params[':search'] = "%$search%";
            }

            // Gender Filter
            if (!empty($gender) && $gender !== 'all' && $gender !== 'Semua') {
                $sql .= " AND (gender = :gender OR gender = 'Unisex')";
                $params[':gender'] = $gender;
            }

            // Size Filter
            if (!empty($sizeInput) && $sizeInput !== 'ALL' && $sizeInput !== 'SEMUA') {
                if (in_array($sizeInput, $sizeOrder)) {
                    $sql .= " AND (size_range LIKE :size_like OR size_range = 'S-XL' OR size_range = 'All Size')";
                    $params[':size_like'] = "%$sizeInput%";
                }
            }

            $sql .= " ORDER BY created_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in Product::getByCategoryFiltered: " . $e->getMessage());
            return [];
        }
    }

    public function getByCategory(string $category): array
    {
        $stmt = $this->db->prepare("SELECT id, name, category, price, stock, gender, size_range, image, status, created_at FROM products WHERE category = ? ORDER BY created_at DESC");
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, name, category, price, stock, gender, size_range, image, status, created_at FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product ?: null;
    }

    public function getImageById(int $id): ?string
    {
        $stmt = $this->db->prepare("SELECT image FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['image'] : null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare("INSERT INTO products (name, category, price, stock, gender, size_range, image, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([
            $data['name'],
            $data['category'],
            $data['price'],
            $data['stock'],
            $data['gender'],
            $data['size_range'],
            $data['image'],
            $data['status']
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("UPDATE products SET name = ?, category = ?, price = ?, stock = ?, gender = ?, size_range = ?, image = ?, status = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'],
            $data['category'],
            $data['price'],
            $data['stock'],
            $data['gender'],
            $data['size_range'],
            $data['image'],
            $data['status'],
            $id
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function toggleStatus(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE products SET status = CASE WHEN status = 'aktif' THEN 'nonaktif' ELSE 'aktif' END WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getStatusById(int $id): ?string
    {
        $stmt = $this->db->prepare("SELECT status FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['status'] : null;
    }

    public function countTotal(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM products")->fetchColumn();
    }

    public function countActive(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM products WHERE status = 'aktif'")->fetchColumn();
    }
}
