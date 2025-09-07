<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->include('layouts/partials/head') ?>

    <style>
.svg-icon {
  width: 350px !important;
  height: auto !important; /* biar proporsi tetap */
}

    </style>
</head>
     
     <!-- ========== signin-section start ========== -->
      <section class="signin-section">
        <div class="container-fluid">

          <div class="row g-0 auth-row">
            <div class="col-lg-6">
              <div class="auth-cover-wrapper bg-primary-100">
                <div class="auth-cover">
                  <div class="title text-center">
                    <h1 class="text-primary mb-10">Welcome</h1>
                    <p class="text-medium">
                     Sustainable Development Goals Desa Jatimulya
                    </p>
                  </div>
                  <div class="cover-image">
                    <img src="assets/images/auth/sdgs.svg" alt="" class="svg-icon" />
                  </div>
                  <!-- <div class="shape-image">
                  </div> -->
                </div>
              </div>
            </div>
            <!-- end col -->
            <div class="col-lg-6">
              <div class="signin-wrapper">
                <div class="form-wrapper">
                  <h6 class="mb-15">Sign In Form</h6>

                  <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="flashMessage">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php elseif (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="flashMessage">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>


                  <p class="text-sm mb-25">
                  </p>
                  <form class="p-3 mt-3" action="<?= base_url('/auth/login') ?>" method="POST">
                    <div class="row">
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>User Name</label>
                          <input type="text" placeholder="User Name" name="username" id="username" />
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Password</label>
                          <input type="password" name="password" id="password" placeholder="Password" />
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-xxl-6 col-lg-12 col-md-6">
                        <div class="form-check checkbox-style mb-30">
                          <input class="form-check-input" type="checkbox" value="" id="checkbox-remember" />
                          <label class="form-check-label" for="checkbox-remember">
                            Remember me next time</label>
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-xxl-6 col-lg-12 col-md-6">
                        <div class="text-start text-md-end text-lg-start text-xxl-end mb-30">
                          <a href="reset-password.html" class="hover-underline">
                            Forgot Password?
                          </a>
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="button-group d-flex justify-content-center flex-wrap">
                          <button class="main-btn primary-btn btn-hover w-100 text-center">
                            Sign In
                          </button>
                        </div>
                      </div>
                    </div>
                    <!-- end row -->
                  </form>
                  <!-- <div class="singin-option pt-40">
                    <p class="text-sm text-medium text-center text-gray">
                      Easy Sign In With
                    </p>
                    <div class="button-group pt-40 pb-40 d-flex justify-content-center flex-wrap">
                      <button class="main-btn primary-btn-outline m-2">
                        <i class="lni lni-facebook-fill mr-10"></i>
                        Facebook
                      </button>
                      <button class="main-btn danger-btn-outline m-2">
                        <i class="lni lni-google mr-10"></i>
                        Google
                      </button>
                    </div>
                    <p class="text-sm text-medium text-dark text-center">
                      Don’t have any account yet?
                      <a href="signup.html">Create an account</a>
                    </p>
                  </div> -->
                </div>
              </div>
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
      </section>
      <!-- ========== signin-section end ========== -->


      

    <script>
        setTimeout(function() {
            let flash = document.getElementById('flashMessage');
            if (flash) {
                flash.style.transition = 'opacity 0.5s ease';
                flash.style.opacity = '0';
                setTimeout(() => flash.remove(), 500);
            }
        }, 3000);
    </script>
</body>
</html>