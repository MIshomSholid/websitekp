<?php
session_start();

// Check if user wants to logout
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    session_destroy();
    header('Location: login.php');
    exit;
}

// If user is not logged in, redirect to login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - Konfirmasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .glassmorphism {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 flex items-center justify-center p-4">
    <div class="glassmorphism rounded-2xl shadow-2xl p-8 w-full max-w-md animate-fadeIn">
        <!-- Icon -->
        <div class="text-center mb-6">
            <div class="inline-flex p-4 gradient-bg rounded-full shadow-lg mb-4">
                <i class="fas fa-sign-out-alt text-white text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Konfirmasi Logout</h1>
            <p class="text-gray-600">Apakah Anda yakin ingin keluar dari sistem?</p>
        </div>

        <!-- Buttons -->
        <div class="space-y-3">
            <button onclick="window.location.href='?confirm=yes'" 
                    class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-sign-out-alt"></i>
                Ya, Logout
            </button>
            
            <button onclick="window.location.href='manajemen_admin.php'" 
                    class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Manajemen Admin
            </button>
            
            <button onclick="window.history.back()" 
                    class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-times"></i>
                Batal
            </button>
        </div>

        <!-- Footer Info -->
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>Anda akan diarahkan ke halaman login setelah logout</p>
        </div>
    </div>

    <script>
        // Auto focus on page load
        document.addEventListener('DOMContentLoaded', function(){
            document.body.focus();
        });

        // Handle keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // ESC key to cancel
            if (e.key === 'Escape') {
                window.history.back();
            }
            // Enter key to confirm logout
            if (e.key === 'Enter') {
                window.location.href = '?confirm=yes';
            }
        });
    </script>
</body>
</html>