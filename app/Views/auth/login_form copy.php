<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
      crossorigin="anonymous"
    />
    <style>
        /* Importing fonts from Google */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        /* Resetting */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: url('<?= base_url('img/default.jpg') ?>') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wrapper {
            width: 90%;
            max-width: 400px;
            margin-right: 250px !important; 
            min-height: 450px;
            margin: 20px auto;
            padding: 30px 20px;
            background-color: #ecf0f3;
            border-radius: 15px;
            /* box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff; */
        }

        .logo {
            width: 80px;
            margin: auto;
        }

        .logo img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0px 0px 3px #5f5f5f,
                0px 0px 0px 5px #027edb,
                8px 8px 15px #a7aaa7,
                -8px -8px 15px #fff;
        }

        .wrapper .name {
            font-weight: 600;
            font-size: clamp(1.2rem, 5vw, 1.4rem);
            letter-spacing: 1.3px;
            padding-left: 10px;
            color: #555;
            text-align: center;
        }

        .wrapper .form-field input {
            width: 100%;
            display: block;
            border: none;
            outline: none;
            background: none;
            font-size: clamp(0.9rem, 4vw, 1.1rem);
            color: #666;
            padding: 10px 15px 10px 10px;
        }

        .wrapper .form-field {
            padding-left: 10px;
            margin-bottom: 15px;
            border-radius: 20px;
            box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
            display: flex;
            align-items: center;
        }

        .wrapper .form-field .fas {
            color: #555;
            margin-right: 10px;
        }

        .wrapper .btn {
            box-shadow: none;
            width: 100%;
            height: 40px;
            background-color: #03A9F4;
            color: #fff;
            border-radius: 25px;
            box-shadow: 3px 3px 3px #b1b1b1,
                -3px -3px 3px #fff;
            letter-spacing: 1.3px;
            font-size: clamp(0.9rem, 4vw, 1rem);
        }

        .wrapper .btn:hover {
            background-color: #039BE5;
        }

        .wrapper a {
            text-decoration: none;
            font-size: clamp(0.7rem, 3.5vw, 0.8rem);
            color: #03A9F4;
        }

        .wrapper a:hover {
            color: #039BE5;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .wrapper {
                margin: 15px;
                padding: 20px 15px;
                min-height: 400px;
                margin-right: 0px !important;
            }

            .logo {
                width: 60px;
            }

            .logo img {
                height: 60px;
            }

            .wrapper .form-field {
                margin-bottom: 12px;
            }

            .wrapper .btn {
                height: 36px;
            }
        }

        @media (max-width: 400px) {
            .wrapper {
                padding: 15px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="flashMessage">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php elseif (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="flashMessage">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="logo">
            <img src="<?= base_url('img/logo-sdgs.png') ?>" alt="SDGS Desa Jatimulya Logo">
        </div>
        <div class="name mt-4">
            SDGS Desa Jatimulya
        </div>
        <form class="p-3 mt-3" action="<?= base_url('/auth/login') ?>" method="POST">
            <div class="form-field">
                <span class="far fa-user"></span>
                <input type="text" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-field">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <button class="btn mt-3" type="submit">Login</button>
        </form>
        <div class="text-center fs-6">
            <!-- <a href="#">Forget password?</a> or <a href="#">Sign up</a> -->
        </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"
      crossorigin="anonymous"
    ></script>
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