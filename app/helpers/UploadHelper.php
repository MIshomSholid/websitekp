<?php
// app/helpers/UploadHelper.php

class UploadHelper
{
    public static function uploadImage(array $file, string $uploadDir = 'Uploads/'): string
    {
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $fileName = uniqid() . '.' . $fileExtension;
        $targetPath = rtrim($uploadDir, '/\\') . DIRECTORY_SEPARATOR . $fileName;

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileExtension, $allowedTypes)) {
            throw new Exception('Format file tidak didukung! Hanya JPG, PNG, GIF yang diperbolehkan.');
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            throw new Exception('Ukuran file terlalu besar! Maksimal 2MB.');
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($mime, $allowedMimes)) {
            throw new Exception('Tipe file tidak valid!');
        }

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $fileName;
        }

        throw new Exception('Gagal mengupload file!');
    }

    public static function deleteImage(?string $fileName, string $uploadDir = 'Uploads/'): void
    {
        if (!$fileName) {
            return;
        }

        $filePath = rtrim($uploadDir, '/\\') . DIRECTORY_SEPARATOR . $fileName;
        if (file_exists($filePath) && is_file($filePath)) {
            unlink($filePath);
        }
    }

    public static function formatDate(?string $date): string
    {
        return $date ? date('d/m/Y H:i', strtotime($date)) : '-';
    }

    public static function getThumbPath(?string $imgName, string $fallback = 'assets/images/kaos.png'): string
    {
        if (!empty($imgName) && file_exists(__DIR__ . '/../../Uploads/' . $imgName)) {
            return 'Uploads/' . htmlspecialchars($imgName);
        }
        return $fallback;
    }
}
