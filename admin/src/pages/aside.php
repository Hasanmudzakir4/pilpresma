<?php
// Dapatkan nama halaman yang sedang aktif
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="./dashboard.php" class="brand-link">
        <img src="../../../src/img/ppu.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light"><?= getAdminUsername(); ?></span>
    </a>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Dashboard Menu -->
            <li class="nav-item">
                <a href="./dashboard.php" class="nav-link <?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <!-- Mahasiswa Menu -->
            <li class="nav-item <?php echo (in_array($currentPage, ['semester1.php', 'semester3.php', 'semester5.php', 'semester7.php'])) ? 'menu-open' : ''; ?>">
                <a href="#" class="nav-link <?php echo (in_array($currentPage, ['semester1.php', 'semester3.php', 'semester5.php', 'semester7.php'])) ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-table"></i>
                    <p>Mahasiswa <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./semester1.php" class="nav-link <?php echo ($currentPage == 'semester1.php') ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Semester 1</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./semester3.php" class="nav-link <?php echo ($currentPage == 'semester3.php') ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Semester 3</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./semester5.php" class="nav-link <?php echo ($currentPage == 'semester5.php') ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Semester 5</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./semester7.php" class="nav-link <?php echo ($currentPage == 'semester7.php') ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Semester 7</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?php echo (in_array($currentPage, ['register.php', 'kandidat.php'])) ? 'menu-open' : ''; ?>">
                <a href="#" class="nav-link <?php echo (in_array($currentPage, ['register.php', 'kandidat.php'])) ? 'active' : ''; ?>">
                    <i class="nav-icon fa-solid fa-user-plus"></i>
                    <p>Users & Kandidat<i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./register.php" class="nav-link <?php echo ($currentPage == 'register.php') ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./kandidat.php" class="nav-link <?php echo ($currentPage == 'kandidat.php') ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kandidat</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?php echo (in_array($currentPage, ['admin.php', 'profileKandidat.php'])) ? 'menu-open' : ''; ?>">
                <a href="#" class="nav-link <?php echo (in_array($currentPage, ['admin.php', 'profileKandidat.php'])) ? 'active' : ''; ?>">
                    <i class="nav-icon fa-regular fa-id-card"></i>
                    <p>Profile<i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./admin.php" class="nav-link <?php echo ($currentPage == 'admin.php') ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Admin</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./profileKandidat.php" class="nav-link <?php echo ($currentPage == 'profileKandidat.php') ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kandidat</p>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Logout Menu -->
            <li class="nav-item">
                <a href="./logout.php" class="nav-link <?php echo ($currentPage == 'logout.php') ? 'active' : ''; ?>">
                    <i class="nav-icon fa-solid fa-right-to-bracket"></i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</aside>