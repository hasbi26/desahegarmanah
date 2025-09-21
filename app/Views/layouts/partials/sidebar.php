<div id="layoutSidenav_nav">
    <?php helper('url'); ?>
    <!-- ======== Preloader =========== -->
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <aside class="sidebar-nav-wrapper">
        <div class="navbar-logo" style="border-bottom: 1px solid #e7eaf3; padding-bottom: 10px;">
            <a href="<?= base_url('dashboard') ?>" style="font-size: 20px; font-weight: 600; color: #1DA5B4;">
                Pengelolaan Data Penduduk
            </a>
        </div>
        <nav class="sidebar-nav">
            <p class="menu-title" style=" margin-left: 20px; margin-bottom: 15px; margin-top: -20px; font-weight: 500;">MENU UTAMA</p>
            <ul>
                <li class="nav-item">
                    <a class="<?= url_is('dashboard') ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
                        <span class="icon"><i class="lni lni-stats-up"></i></span>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="collapsed" data-bs-toggle="collapse" href="#kelolaData" role="button" aria-expanded="false" aria-controls="kelolaData">
                        <span class="icon"><i class="lni lni-database"></i></span>
                        <span class="text">Kelola Data</span>
                        <span class="arrow"><i class="lni lni-chevron-down"></i></span>
                    </a>
                    <div class="collapse" id="kelolaData">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="<?= url_is('penduduk') || url_is('penduduk/*') ? 'active' : '' ?>" href="<?= base_url('penduduk') ?>">
                                    <span class="icon"><i class="lni lni-users"></i></span>
                                    <span class="text">Kelola Penduduk Tetap</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="<?= url_is('penduduk/create') ? 'active' : '' ?>" href="<?= base_url('penduduk/create') ?>">
                                    <span class="icon"><i class="lni lni-circle-plus"></i></span>
                                    <span class="text">Tambah Penduduk Tetap</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="<?= url_is('musiman') || url_is('musiman/*') ? 'active' : '' ?>" href="<?= base_url('musiman') ?>">
                                    <span class="icon"><i class="lni lni-calendar"></i></span>
                                    <span class="text">Kelola Penduduk Musiman</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="<?= url_is('musiman/create') ? 'active' : '' ?>" href="<?= base_url('musiman/create') ?>">
                                    <span class="icon"><i class="lni lni-circle-plus"></i></span>
                                    <span class="text">Tambah Penduduk Musiman</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php $__role = session('role');
                $__isAdmin = ((int)($__role ?? 0) === 1) || (strtolower((string)($__role ?? '')) === 'admin'); ?>
                <?php if ($__isAdmin): ?>
                    <li class="nav-item">
                        <a class="<?= url_is('users') || url_is('users/*') ? 'active' : '' ?>" href="<?= base_url('users') ?>">
                            <span class="icon"><i class="lni lni-protection"></i></span>
                            <span class="text">Pengguna</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php $__role = strtolower((string)session('role')); ?>
                <?php if ($__role === 'desa/admin'): ?>
                    <li class="nav-item">
                        <a class="collapsed" data-bs-toggle="collapse" href="#kelolaUser" role="button" aria-expanded="false" aria-controls="kelolaUser">
                            <span class="icon"><i class="lni lni-users"></i></span>
                            <span class="text">Kelola User</span>
                            <span class="arrow"><i class="lni lni-chevron-down"></i></span>
                        </a>
                        <div class="collapse" id="kelolaUser">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                    <a class="<?= url_is('users') || url_is('users/*') ? 'active' : '' ?>" href="<?= base_url('users') ?>">
                                        <span class="icon"><i class="lni lni-user"></i></span>
                                        <span class="text">Daftar User</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="<?= url_is('users/form') ? 'active' : '' ?>" href="<?= base_url('users/form') ?>">
                                        <span class="icon"><i class="lni lni-circle-plus"></i></span>
                                        <span class="text">Tambah User</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="<?= url_is('settings') ? 'active' : '' ?>" href="<?= base_url('settings') ?>">
                        <span class="icon"><i class="lni lni-cog"></i></span>
                        <span class="text">Settings</span>
                    </a>
                </li>
                <span class="divider">
                    <hr />
                </span>
            </ul>
        </nav>
    </aside>
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->
</div>
<style>
    .arrow {
        transition: transform 0.3s ease;
    }

    .collapsed .arrow {
        transform: rotate(0deg);
    }

    .arrow {
        transform: rotate(180deg);
    }
</style>