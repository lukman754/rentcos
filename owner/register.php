<?php
include '../db/koneksi.php';

// Function to generate a unique filename
function generateUniqueFileName($originalName)
{
    $timestamp = date('YmdHis');
    $random = rand(1000, 9999);
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    return $timestamp . '_' . $random . '.' . $extension;
}

if (isset($_POST['register'])) {
    // Validate and sanitize inputs
    $owner_name = mysqli_real_escape_string($conn, trim($_POST['owner_name']));
    $ig = mysqli_real_escape_string($conn, trim($_POST['ig']));
    $no_telp = mysqli_real_escape_string($conn, trim($_POST['no_telp']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hashing

    // Status Akun saat daftar
    $status = 'nonaktif';
    $created_at = date('Y-m-d H:i:s');

    // Image upload handling
    $foto = ''; // Default empty image path
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $upload_dir = '../img/owner/';

        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Generate unique filename
        $original_filename = $_FILES['foto']['name'];
        $unique_filename = generateUniqueFileName($original_filename);
        $upload_path = $upload_dir . $unique_filename;

        // Move uploaded file
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $upload_path)) {
            $foto = $unique_filename; // Store only the filename in database
        } else {
            $error = "Gagal mengunggah foto";
        }
    }

    // Check if email already exists
    $email_check = mysqli_query($conn, "SELECT * FROM tb_owner WHERE email = '$email'");
    if (mysqli_num_rows($email_check) > 0) {
        $error = "Email sudah terdaftar";
    }
    // Check if Instagram username already exists
    else {
        $ig_check = mysqli_query($conn, "SELECT * FROM tb_owner WHERE ig = '$ig'");
        if (mysqli_num_rows($ig_check) > 0) {
            $error = "Instagram sudah terdaftar";
        }
        // If no existing email or IG, proceed with registration
        else {
            $query = "INSERT INTO tb_owner (
                owner_name, ig, `desc`, no_telp, address, email, 
                password, created_at, foto, status
            ) VALUES (
                '$owner_name', '$ig', '$desc', '$no_telp', '$address', 
                '$email', '$password', '$created_at', '$foto', '$status'
            )";

            if (mysqli_query($conn, $query)) {
                $success = "Registrasi berhasil. Tunggu konfirmasi admin.";
            } else {
                $error = "Registrasi gagal: " . mysqli_error($conn);
            }
        }
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
    <!-- Page Preloader -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="../img/normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Owner Registration</h2>
                        <p>Welcome to the registration page for Owners.</p>
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
                <div class="col-12">
                    <div class="login__form">
                        <h3>Register</h3>
                        <?php
                        if (isset($success)) {
                            echo "<div class='alert alert-success'>$success</div>";
                        }
                        if (isset($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                        ?>
                        <form method="post" enctype="multipart/form-data">
                            <div class="input__item w-100">
                                <input type="file" name="foto" class="pt-2" accept="image/*"
                                    onchange="previewImage(this)" required>
                                <span class="fa fa-cloud-upload"></span>

                                <div class="mt-2">
                                    <img id="imagePreview" src="" alt="Image Preview"
                                        style="max-width: 200px; display: none; border: 1px solid #ddd; border-radius: 5px; padding: 5px;">
                                </div>
                            </div>



                            <div class="input__item w-100">
                                <input type="text" name="owner_name" placeholder="Enter your name" required>
                                <span class="icon_id"></span>
                            </div>


                            <div class="input__item w-100">
                                <input type="text" name="ig" placeholder="@your_instagram" required>
                                <span class=""><i class="social_instagram"></i></span>
                            </div>

                            <div class="input__item w-100">
                                <input type="text" name="no_telp" placeholder="081234567890" required>
                                <span class="icon_phone"></span>
                            </div>
                            <div class="input__item w-100">
                                <input type="text" name="email" placeholder="Email address" />
                                <span class="icon_mail"></span>
                            </div>
                            <div class="input__item w-100">
                                <input type="password" name="password" placeholder="Password" />
                                <span class="icon_lock"></span>
                            </div>
                            <button type="submit" name="register" class="site-btn">Register Now</button>
                            <a href="index.php" class="forget_pass">Login</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Section End -->

    <!-- Footer Section Begin -->

    <!-- Anime Section End -->
    <?php include 'footer.html'; ?>
    <!-- Footer Section End -->

    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.style.display = 'block';
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <!-- Js Plugins -->
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
</body>


</html>