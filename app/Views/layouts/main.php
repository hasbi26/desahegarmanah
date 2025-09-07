<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->include('layouts/partials/head') ?>
</head>
<body class="sb-nav-fixed">

    <!-- Topbar -->
     <?= $this->include('layouts/partials/topbar') ?>

    <div id="layoutSidenav">
        <!-- Sidebar -->
        <?= $this->include('layouts/partials/sidebar') ?>

        <!-- Content -->
        <div id="layoutSidenav_content">
            <!-- <main class="container-fluid"> -->
                <?= $this->renderSection('content') ?>
                <?= $this->renderSection('scripts') ?>

            <!-- </main> -->

            <!-- Footer -->
            <?= $this->include('layouts/partials/footer') ?>
        </div>
    </div>

    <!-- Scripts -->

    <?= $this->include('layouts/partials/scripts') ?>
</body>
</html>
