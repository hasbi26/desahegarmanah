<?php
// Ensure variables exist to avoid undefined notices
$role = $role ?? session('role');
$wilayah_nama = $wilayah_nama ?? session('wilayah_nama');
$username = $username ?? session('username');
?>
<main class="main-wrapper">
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-6">
                    <div class="header-left d-flex align-items-center">
                        <div class="menu-toggle-btn mr-15">
                            <button id="menu-toggle" class="main-btn btn-hover"
                                style="background: #1DA5B4; color: #fff;">
                                <i class="lni lni-chevron-left me-2"></i> Menu
                            </button>
                        </div>
                        <div class="header-search d-none d-md-flex">
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-6">
                    <div class="header-right">

                        <!-- profile start -->
                        <div class="profile-box ml-15">
                            <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="profile-info">
                                    <div class="info">
                                        <div class="image">
                                            <img src="<?= base_url('/img/logo.png') ?>" alt="" />
                                        </div>
                                        <div>
                                            <h6 class="fw-500"><?= esc($username ?? '-') ?></h6>
                                            <p><?php
                                                // Determine role label: show RT/DESA/KECAMATAN/KABUPATEN, otherwise '-'
                                                $label = '-';
                                                $rawRole = $role ?? session('role');

                                                if (is_numeric($rawRole)) {
                                                    // Support numeric role codes
                                                    switch ((int)$rawRole) {
                                                        case 2: $label = 'RT'; break;
                                                        case 3: $label = 'DESA'; break;
                                                        case 4: $label = 'KECAMATAN'; break;
                                                        case 5: $label = 'KABUPATEN'; break;
                                                        default: $label = 'Admin'; break;
                                                    }
                                                } else {
                                                    // Support string roles like 'rt', 'desa', 'kecamatan', 'kabupaten' or mixed (e.g., 'desa/admin')
                                                    $val = strtolower((string)$rawRole);
                                                    if (strpos($val, 'rt') !== false) {
                                                        $label = 'RT';
                                                    } elseif (strpos($val, 'desa') !== false) {
                                                        $label = 'DESA';
                                                    } elseif (strpos($val, 'kecamatan') !== false) {
                                                        $label = 'KECAMATAN';
                                                    } elseif (strpos($val, 'kabupaten') !== false) {
                                                        $label = 'KABUPATEN';
                                                    } elseif (strpos($val, 'admin') !== false) {
                                                        $label = 'Admin';
                                                    }
                                                }

                                                echo $label;
                                            ?></p>
                                            <!-- Debug sementara -->
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                                <li>
                                    <div class="author-info flex items-center !p-1">
                                        <div class="image">
                                            <img src="<?= base_url('/img/logo.png') ?>" alt="image">
                                        </div>
                                        <div class="content">
                                            <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs"
                                                href="#">
                                                <?= esc($username ?? '-') ?>
                                            </a>
                                            <h4 class="text-sm"><?= esc($role ?? '-') ?></h4>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?= base_url('settings') ?>"> <i class="lni lni-cog"></i> Settings </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="/auth/logout"> <i class="lni lni-exit"></i> Sign Out </a>
                                </li>
                            </ul>
                        </div>
                        <!-- profile end -->
                    </div>
                </div>
            </div>
        </div>
    </header>