@php
    // Redirect to forbidden page if not logged in
    if (!auth()->check()) {
        header('Location: /login');
        exit;
    }

    // Get the current user's role_id
    $userRoleId = auth()->user()->role_id;

    // Check if super admin
    $isSuperAdmin = $userRoleId == 1;

    // Get user's role with access permissions
    $userRole = App\Models\Roles::find($userRoleId);

    // Parse permissions from the role's akses field
    $permissions = [];
    if (!$isSuperAdmin && $userRole && $userRole->akses) {
        $permissions = is_string($userRole->akses) ? json_decode($userRole->akses, true) : $userRole->akses;
        $permissions = $permissions ?: [];
    }

    // Fungsi untuk memeriksa apakah pengguna memiliki izin tertentu
    function hasPermission($moduleKey, $actionKey, $permissions, $isSuperAdmin) {
        if ($isSuperAdmin) return true;
        
        // Jika module ada dalam permissions dan actionKey ada dalam array nilai module
        if (isset($permissions[$moduleKey]) && 
            is_array($permissions[$moduleKey]) && 
            in_array($actionKey, $permissions[$moduleKey])) {
            return true;
        }
        
        return false;
    }

    // Fungsi untuk memeriksa apakah pengguna memiliki salah satu izin (read, create, edit, delete)
    function hasAnyPermission($moduleKey, $permissions, $isSuperAdmin) {
        if ($isSuperAdmin) return true;
        
        $actions = ['read', 'create', 'edit', 'delete'];
        
        foreach ($actions as $action) {
            if (hasPermission($moduleKey, $action, $permissions, $isSuperAdmin)) {
                return true;
            }
        }
        
        return false;
    }
@endphp


<aside class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="logo">
            <i class="fas fa-chart-line"></i>
            <span class="logo-text">Dashboard</span>
        </a>
    </div>
    <nav class="sidebar-menu">
        <div class="menu-title">Menu Utama</div>
        <div class="menu-item active">
            <i class="fas fa-home"></i>
            <span class="menu-text">Beranda</span>
        </div>

        <!-- Dropdown Menu Analitik -->
        <div class="menu-item dropdown">
            <div class="dropdown-header">
                <i class="fas fa-chart-bar"></i>
                <span class="menu-text">Analitik</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </div>

            <div class="dropdown-content">
                <a href="#">
                    <div class="sub-menu-item">
                        <i class="fas fa-chart-line"></i>
                        <span class="menu-text">Dashboard Analitik</span>
                    </div>
                </a>

                <div class="sub-menu-item">
                    <a href="#">
                        <i class="fas fa-user"></i>
                        <span class="menu-text">Demografi Pengguna</span>
                    </a>
                </div>

                <div class="sub-menu-item">
                    <a href="#">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="menu-text">Analisis Penjualan</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Dropdown Menu Proyek -->
        <div class="menu-item dropdown">
            <div class="dropdown-header">
                <a href="#">
                </a>
                <i class="fas fa-tasks"></i>
                <span class="menu-text">Proyek</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </div>
            <div class="dropdown-content">
                <div class="sub-menu-item">
                    <a href="#">
                        <i class="fas fa-list"></i>
                        <span class="menu-text">Daftar Proyek</span>
                    </a>
                </div>
                <div class="sub-menu-item">
                    <a href="#">
                        <i class="fas fa-plus-circle"></i>
                        <span class="menu-text">Tambah Proyek</span>
                    </a>
                </div>
                <div class="sub-menu-item">
                    <a href="#">
                        <i class="fas fa-users"></i>
                        <span class="menu-text">Tim Proyek</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="menu-item">
            <i class="fas fa-calendar"></i>
            <span class="menu-text">Jadwal</span>
        </div>

        <div class="menu-title">Pengaturan</div>
        <div class="menu-item">
            <i class="fas fa-user"></i>
            <span class="menu-text">Profil</span>
        </div>

        <!-- Dropdown Menu Pengaturan -->
        <div class="menu-item dropdown">
            <div class="dropdown-header">
                <i class="fas fa-cog"></i>
                <span class="menu-text">Pengaturan</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </div>
            <div class="dropdown-content">
                <div class="sub-menu-item">
                    <a href="#">
                        <i class="fas fa-user-cog"></i>
                        <span class="menu-text">Akun</span>
                    </a>
                </div>
                <div class="sub-menu-item">
                    <a href="#">
                        <i class="fas fa-bell"></i>
                        <span class="menu-text">Notifikasi</span>
                    </a>
                </div>
                <div class="sub-menu-item">
                    <a href="#">
                        <i class="fas fa-lock"></i>
                        <span class="menu-text">Keamanan</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="menu-item dropdown">
            <div class="dropdown-header">
                <i class="fa-solid fa-shield"></i>
                <span class="menu-text">privilege</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </div>

            <div class="dropdown-content">
                <div class="sub-menu-item">
                    <a href="/showrole">
                        <i class="fas fa-user-cog"></i>
                        <span class="menu-text">Role</span>
                    </a>
                </div>
                <div class="sub-menu-item">
                    <a href="/showuser">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        <span class="menu-text">User</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="menu-item">
            <i class="fas fa-question-circle"></i>
            <span class="menu-text">Bantuan</span>
        </div>
        <div class="menu-item">
            <i class="fas fa-sign-out-alt"></i>
            <span class="menu-text">Keluar</span>
        </div>
    </nav>
</aside>
