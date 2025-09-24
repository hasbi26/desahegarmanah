<!DOCTYPE html>
<html lang="id">

<head>
    <?= $this->include('layouts/partials/head') ?>
    <title>Login | Desa Hegarmanah</title>
    <style>
    body,
    html {
        height: 100%;
    }

    .login-bg {
        min-height: 100vh;
        background: radial-gradient(1200px 600px at 10% 10%, #e8f0ff 0, rgba(255, 255, 255, 0) 60%),
            radial-gradient(1200px 600px at 90% 90%, #eefbf3 0, rgba(255, 255, 255, 0) 60%),
            linear-gradient(135deg, #f4f7ff 0%, #ffffff 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .login-card {
        max-width: 980px;
        width: 100%;
        border: 0;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(21, 36, 69, .08);
        overflow: hidden;
    }

    .login-left {
        background: #1DA5B4;
        color: #fff;
        position: relative;
    }

    .login-left .overlay {
        position: absolute;
        inset: 0;
        background: url('<?= base_url('img/sdgs1.png') ?>') center 90%/180px no-repeat;
        opacity: .15;
    }

    .brand-title {
        font-weight: 700;
        letter-spacing: .4px;
        color: #ffffffff;
    }

    .brand-desc {
        opacity: .95;
    }

    .form-label {
        font-weight: 600;
        color: #14233c;
    }

    .input-group-text {
        background: #f6f8fb;
        border-right: 0;
    }

    .form-control {
        border-left: 0;
    }

    .btn-submit {
        border-radius: 10px;
        padding: 10px 16px;
        background: #1DA5B4;
        color: #fff;
    }

    .btn-submit:hover {
        background: #1798a6;
        color: #fff;
    }

    .small-muted {
        color: #6c757d;
        font-size: .9rem;
    }
    </style>
</head>

<body>
    <div class="login-bg">
        <div class="card login-card">
            <div class="row g-0">
                <div class="col-lg-6 p-5 login-left">
                    <div class="overlay"></div>
                    <div class="position-relative" style="z-index:2">
                        <div class="mb-4">
                            <!-- <span class="badge bg-light" style="color:#211DB4;">SiDesa</span> -->
                        </div>
                        <h2 class="brand-title mb-2">Desa Hegarmanah</h2>
                        <p class="brand-desc mb-4">Population Management System Desa Hegarmanah</p>
                        <img src="<?= base_url('/img/illustration.png') ?>" alt="Ilustrasi" class="img-fluid"
                            style="max-height: 260px; height: 260px;">
                    </div>
                </div>
                <div class="col-lg-6 p-4 p-md-5 bg-white">
                    <h4 class="mb-1">Selamat Datang</h4>
                    <p class="small-muted mb-4">Masuk untuk melanjutkan</p>

                    <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="flashMessage">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                    <?php elseif (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="flashMessage">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/auth/login') ?>" method="POST" autocomplete="on">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="lni lni-user"></i></span>
                                <input type="text" class="form-control" name="username" id="username"
                                    placeholder="Nama pengguna" required autofocus>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Password</label>
                            <div class="input-group" id="passwordGroup">
                                <span class="input-group-text"><i class="lni lni-lock"></i></span>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Kata sandi" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                                    tabindex="-1"><i class="lni lni-eye"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Ingat saya</label>
                            </div>
                            <a class="small" href="#"
                                onclick="alert('Hubungi admin untuk reset password.'); return false;">Lupa password?</a>
                        </div>

                        <button class="btn btn-submit w-100" type="submit">Masuk</button>
                    </form>

                    <p class="small-muted mt-4 mb-0">© <?= date('Y') ?> Desa Hegarmanah</p>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Auto-hide flash messages
    setTimeout(function() {
        let flash = document.getElementById('flashMessage');
        if (flash) {
            flash.style.transition = 'opacity 0.5s ease';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 500);
        }
    }, 3000);

    // Toggle password visibility
    (function() {
        const btn = document.getElementById('togglePassword');
        const input = document.getElementById('password');
        if (!btn || !input) return;
        btn.addEventListener('click', function() {
            const isPwd = input.type === 'password';
            input.type = isPwd ? 'text' : 'password';
            this.innerHTML = isPwd ? '<i class="lni lni-eye-cross"></i>' : '<i class="lni lni-eye"></i>';
        });
    })();
    </script>
</body>

</html>