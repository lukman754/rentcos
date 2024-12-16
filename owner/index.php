<?php
session_start();
include '../db/koneksi.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];

    $query = "SELECT * FROM tb_owner WHERE email = '$email' AND status = 'aktif'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $owner = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $owner['password'])) {
            $_SESSION['owner_logged_in'] = true;
            $_SESSION['owner_id'] = $owner['id_owner'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Email atau password salah";
        }
    } else {
        $error = "Email salah atau akun belum aktif";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Anime Template" />
    <meta name="keywords" content="Anime, unica, creative, html" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Owner Dashboard - Rentcos</title>


    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    <!-- Css Styles -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="../css/elegant-icons.css" type="text/css" />
    <link rel="stylesheet" href="../css/plyr.css" type="text/css" />
    <link rel="stylesheet" href="../css/nice-select.css" type="text/css" />
    <link rel="stylesheet" href="../css/owl.carousel.min.css" type="text/css" />
    <link rel="stylesheet" href="../css/slicknav.min.css" type="text/css" />
    <link rel="stylesheet" href="../css/style.css" type="text/css" />
</head>


<body>

    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>


    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="../img/normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Login Owner</h2>
                        <p>Welcome to the official Rentcos.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->


    <!-- Login Section Begin -->
    <section class="login spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>Login</h3>
                        <?php if (isset($error)) { ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php } ?>
                        <form method="post">
                            <div class="input__item">
                                <input type="text" name="email" placeholder="Email address" />
                                <span class="icon_mail"></span>
                            </div>
                            <div class="input__item">
                                <input type="password" name="password" placeholder="Password" />
                                <span class="icon_lock"></span>
                            </div>
                            <button type="submit" name="login" class="site-btn">Login Now</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__register">
                        <h3>Belum punya Akun?</h3>
                        <a href="register.php" class="primary-btn">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Section End -->


    <!-- Anime Section End -->
    <?php include 'footer.html'; ?>
    <!-- Footer Section End -->


    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here....." />
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/player.js"></script>
    <script src="../js/jquery.nice-select.min.js"></script>
    <script src="../js/mixitup.min.js"></script>
    <script src="../js/jquery.slicknav.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/main.js"></script>

</body>

</html>