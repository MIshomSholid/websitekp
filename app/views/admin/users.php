<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Admin - UD. Toko Hongkong</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0b192c;
            --secondary-color: #122b48;
            --accent-color: #c99726;
            --dark-color: #0b192c;
            --light-color: #f4f1ea;
            --success-color: #15803d;
            --danger-color: #b91c1c;
            --warning-color: #c99726;
            --gradient-primary: linear-gradient(135deg, #0b192c 0%, #122b48 100%);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light-color);
            margin: 0;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: var(--gradient-primary);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-header h4 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
            display: inline-block;
        }

        .sidebar.collapsed .sidebar-header h4 {
            display: none;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.5rem 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0 25px 25px 0;
            margin-right: 1rem;
            white-space: nowrap;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateX(5px);
        }

        .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            text-align: center;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            transition: all 0.3s ease;
            display: block;
        }

        .main-content.collapsed {
            margin-left: 70px;
        }

        .header {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .toggle-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 1rem;
        }

        .header-title {
            margin: 0;
            color: var(--dark-color);
            font-size: 1.5rem;
            font-weight: 600;
        }

        .content {
            padding: 2rem;
        }

        .dashboard-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--light-color);
        }

        .card-title {
            margin: 0;
            color: var(--dark-color);
            font-size: 1.3rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .card-title i {
            margin-right: 0.5rem;
            color: var(--accent-color);
        }

        .btn-primary-custom {
            background: var(--gradient-primary);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(11, 25, 44, 0.3);
            color: white;
        }

        .btn-primary-custom i {
            margin-right: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control-custom {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.75rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control-custom:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(201, 151, 38, 0.15);
            outline: none;
        }

        .table-custom {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 0;
        }

        .table-custom thead {
            background: var(--gradient-primary);
            color: white;
        }

        .table-custom th {
            font-weight: 600;
            border: none;
            padding: 1rem;
            color: white;
        }

        .table-custom td {
            padding: 1rem;
            border-top: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        .table-custom tbody tr:hover {
            background: #f8fafc;
        }

        .btn-action {
            padding: 0.4rem 0.8rem;
            border: none;
            border-radius: 5px;
            font-size: 0.875rem;
            margin: 0 0.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: var(--warning-color);
            color: white;
        }

        .btn-delete {
            background: var(--danger-color);
            color: white;
        }

        .btn-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: var(--gradient-primary);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 1.5rem;
        }

        .modal-title {
            font-weight: 600;
            color: white;
        }

        .btn-close {
            filter: invert(1);
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid #e5e7eb;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            font-size: 2.5rem;
            color: var(--accent-color);
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6b7280;
            font-weight: 500;
        }

        .alert-custom {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid var(--danger-color);
        }

        .alert-custom i {
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }

        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #e5e7eb;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .admin-avatar-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: var(--accent-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }

        .password-toggle-wrapper {
            position: relative;
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
        }

        .password-toggle-btn:hover {
            color: var(--dark-color);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 250px;
            }

            .sidebar.collapsed {
                transform: translateX(-100%);
                width: 250px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.collapsed {
                margin-left: 0;
            }

            .header {
                padding: 1rem;
            }

            .content {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading" id="loading">
        <div class="spinner"></div>
    </div>

    <!-- Sidebar Navigation -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4>Admin Panel</h4>
        </div>
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="manajemen_admin.php">
                        <i class="fas fa-chart-bar"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin.php">
                        <i class="fas fa-tshirt"></i>
                        <span>Kelola Produk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="kelola_admin.php">
                        <i class="fas fa-users-cog"></i>
                        <span>Kelola Admin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content Area -->
    <div class="main-content" id="mainContent">
        <!-- Top Header Bar -->
        <div class="header">
            <div class="header-left">
                <button class="toggle-btn" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="header-title" id="pageTitle">Kelola Admin</h1>
            </div>
            <div class="header-right d-flex align-items-center gap-2">
                <a href="index.php" target="_blank" class="btn btn-outline-secondary btn-sm d-none d-sm-inline-flex align-items-center">
                    <i class="fas fa-external-link-alt me-1"></i>Lihat Website
                </a>
                <a href="logout.php" class="btn btn-outline-danger btn-sm d-flex align-items-center">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </a>
            </div>
        </div>

        <div class="content">
            <!-- Summary Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div class="stat-number"><?= $total_admins ?></div>
                    <div class="stat-label">Total Administrator</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number"><?= $total_admins ?></div>
                    <div class="stat-label">Admin Status Aktif</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number"><?= date('d/m/Y') ?></div>
                    <div class="stat-label">Update Terakhir</div>
                </div>
            </div>

            <!-- Main Management Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-shield"></i>
                        Daftar Administrator
                    </h3>
                    <button class="btn-primary-custom" onclick="openModal()">
                        <i class="fas fa-plus"></i>
                        Tambah Admin
                    </button>
                </div>

                <!-- Search Area -->
                <div class="row mb-3 g-2 align-items-center">
                    <div class="col-md-6 col-lg-5">
                        <form method="GET" action="kelola_admin.php" id="searchForm" class="d-flex gap-2">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" name="search" id="searchInput" class="form-control form-control-custom border-start-0 ps-0" placeholder="Cari admin berdasarkan username..." value="<?= htmlspecialchars($searchParam) ?>">
                            </div>
                            <button type="submit" class="btn btn-primary-custom"><i class="fas fa-search"></i></button>
                            <?php if (!empty($searchParam)): ?>
                                <a href="kelola_admin.php" class="btn btn-outline-secondary d-flex align-items-center" title="Reset Pencarian"><i class="fas fa-times"></i></a>
                            <?php endif; ?>
                        </form>
                    </div>
                    <div class="col-md-6 col-lg-7 text-md-end mt-2 mt-md-0">
                        <span class="text-muted small"><i class="fas fa-info-circle me-1"></i>Menampilkan <strong><?= count($admins) ?></strong> administrator terdaftar</span>
                    </div>
                </div>

                <!-- Admin Table -->
                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th style="width: 80px;">ID</th>
                                <th>Administrator</th>
                                <th>Status Akun</th>
                                <th style="width: 180px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="adminTableBody">
                            <?php if (empty($admins)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="fas fa-user-slash fa-2x mb-2 d-block text-muted"></i>
                                        Tidak ada data administrator yang ditemukan.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($admins as $admin): ?>
                                    <tr data-id="<?= (int) $admin['id'] ?>">
                                        <td><strong>#<?= $admin['id'] ?></strong></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="admin-avatar-circle">
                                                    <?= strtoupper(substr($admin['username'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-navy"><?= htmlspecialchars($admin['username']) ?></div>
                                                    <?php if ($admin['id'] == $_SESSION['user_id']): ?>
                                                        <span class="badge bg-primary-subtle text-primary border" style="font-size: 0.72rem;">Akun Anda</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Aktif
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn-action btn-edit" onclick="editAdmin(<?= $admin['id'] ?>)" title="Edit Admin">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <?php if ($admin['id'] != $_SESSION['user_id']): ?>
                                                <button class="btn-action btn-delete" onclick="deleteAdmin(<?= $admin['id'] ?>, '<?= addslashes(htmlspecialchars($admin['username'])) ?>')" title="Hapus Admin">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Modal Form -->
    <div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Admin Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="adminForm">
                        <input type="hidden" id="adminId" name="id">

                        <div class="form-group">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" class="form-control form-control-custom" id="username" name="username" placeholder="Masukkan username" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password" id="passwordLabel">Password</label>
                            <div class="password-toggle-wrapper">
                                <input type="password" class="form-control form-control-custom" id="password" name="password" placeholder="Masukkan password" required>
                                <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility()">
                                    <i id="passwordIcon" class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted" id="passwordHelp" style="display: none;">Biarkan kosong jika tidak ingin mengubah password saat ini.</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="adminForm" class="btn-primary-custom" id="submitBtn">
                        <i class="fas fa-save"></i> <span id="submitText">Simpan Admin</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Dependencies Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let currentEditId = null;
        let adminModalInstance = null;

        $(document).ready(function () {
            adminModalInstance = new bootstrap.Modal(document.getElementById('adminModal'));

            // Sidebar Toggle
            $('#toggleSidebar').click(function () {
                const $sidebar = $('#sidebar');
                const $mainContent = $('#mainContent');
                const isMobile = window.innerWidth <= 768;

                if (isMobile) {
                    $sidebar.toggleClass('show');
                    if ($sidebar.hasClass('show')) {
                        $sidebar.removeClass('collapsed');
                    }
                } else {
                    $sidebar.toggleClass('collapsed');
                    $mainContent.toggleClass('collapsed');
                }
            });

            // Close sidebar when clicking outside on mobile
            $(document).on('click', function (e) {
                if (window.innerWidth <= 768) {
                    const $sidebar = $('#sidebar');
                    const $toggleBtn = $('#toggleSidebar');
                    if ($sidebar.hasClass('show') && !$sidebar.is(e.target) && $sidebar.has(e.target).length === 0 && !$toggleBtn.is(e.target)) {
                        $sidebar.removeClass('show');
                    }
                }
            });

            // Live search debounce
            let searchTimer;
            $('#searchInput').on('input', function () {
                const val = $(this).val().trim();
                clearTimeout(searchTimer);
                searchTimer = setTimeout(function () {
                    if (val.length === 0 || val.length >= 2) {
                        $('#searchForm').submit();
                    }
                }, 600);
            });
        });

        function showLoading() {
            $('#loading').show();
        }

        function hideLoading() {
            $('#loading').hide();
        }

        function showAlert(message, type = 'success') {
            const alert = $(`<div class="alert-custom alert-${type}">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                ${message}
            </div>`);
            $('body').append(alert);
            setTimeout(() => alert.fadeOut(300, () => alert.remove()), 3500);
        }

        function openModal() {
            currentEditId = null;
            $('#modalTitle').text('Tambah Admin Baru');
            $('#submitText').text('Simpan Admin');
            $('#passwordLabel').text('Password');
            $('#password').prop('required', true).val('');
            $('#passwordHelp').hide();
            $('#adminId').val('');
            $('#username').val('');
            adminModalInstance.show();
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'fas fa-eye';
            }
        }

        function editAdmin(id) {
            showLoading();
            $.post('', { action: 'get_admin', id: id }, function (response) {
                hideLoading();
                if (response.success) {
                    currentEditId = id;
                    const admin = response.admin;
                    $('#modalTitle').text('Edit Administrator');
                    $('#submitText').text('Update Admin');
                    $('#passwordLabel').text('Password Baru');
                    $('#password').prop('required', false).val('');
                    $('#passwordHelp').show();
                    $('#adminId').val(admin.id);
                    $('#username').val(admin.username);
                    adminModalInstance.show();
                } else {
                    showAlert(response.message, 'danger');
                }
            }, 'json').fail(function () {
                hideLoading();
                showAlert('Terjadi kesalahan saat memuat data admin!', 'danger');
            });
        }

        function deleteAdmin(id, username) {
            if (confirm(`Apakah Anda yakin ingin menghapus admin "${username}"?`)) {
                showLoading();
                $.post('', { action: 'delete_admin', id: id }, function (response) {
                    hideLoading();
                    if (response.success) {
                        showAlert(response.message, 'success');
                        setTimeout(() => window.location.reload(), 1200);
                    } else {
                        showAlert(response.message, 'danger');
                    }
                }, 'json').fail(function () {
                    hideLoading();
                    showAlert('Terjadi kesalahan saat menghapus admin!', 'danger');
                });
            }
        }

        $('#adminForm').on('submit', function (e) {
            e.preventDefault();
            const action = currentEditId ? 'edit_admin' : 'add_admin';
            const formData = $(this).serialize() + '&action=' + action;

            showLoading();
            $.post('', formData, function (response) {
                hideLoading();
                if (response.success) {
                    showAlert(response.message, 'success');
                    adminModalInstance.hide();
                    setTimeout(() => window.location.reload(), 1200);
                } else {
                    showAlert(response.message, 'danger');
                }
            }, 'json').fail(function () {
                hideLoading();
                showAlert('Terjadi kesalahan saat menyimpan data!', 'danger');
            });
        });
    </script>
</body>

</html>
