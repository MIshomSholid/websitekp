<?php
// app/models/User.php

require_once __DIR__ . '/../config/Database.php';

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, username FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function getAll(string $searchParam = ''): array
    {
        $search = '%' . trim($searchParam) . '%';
        $stmt = $this->db->prepare("SELECT id, username FROM users WHERE username LIKE ? ORDER BY id DESC");
        $stmt->execute([$search]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrderedById(): array
    {
        $stmt = $this->db->query("SELECT id, username FROM users ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function usernameExists(string $username, ?int $excludeId = null): bool
    {
        if ($excludeId !== null) {
            $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
            $stmt->execute([$username, $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
        }
        return (bool) $stmt->fetch();
    }

    public function create(string $username, string $plainPassword): bool
    {
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hashedPassword]);
    }

    public function update(int $id, string $username, ?string $plainPassword = null): bool
    {
        if (!empty($plainPassword)) {
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
            return $stmt->execute([$username, $hashedPassword, $id]);
        } else {
            $stmt = $this->db->prepare("UPDATE users SET username = ? WHERE id = ?");
            return $stmt->execute([$username, $id]);
        }
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function countTotal(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }
}
