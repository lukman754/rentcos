<?php
session_start();
include '../db/koneksi.php';

// Redirect if not logged in
if (!isset($_SESSION['owner_logged_in'])) {
    header("Location: index.php");
    exit();
}

$owner_id = $_SESSION['owner_id'];
$error_message = '';
$success_message = '';

// Fetch current owner data
$query = "SELECT * FROM tb_owner WHERE id_owner = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();
$owner_data = $result->fetch_assoc();

// Handle profile update
if (isset($_POST['update_profile'])) {
    $owner_name = $_POST['owner_name'];
    $ig = $_POST['ig'];
    $desc = $_POST['desc'];
    $no_telp = $_POST['no_telp'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // File upload handling for multiple photos
    $fotos = [$owner_data['foto']]; // Default to existing photo

    // Process 3 possible photo uploads
    for ($i = 1; $i <= 3; $i++) {
        $current_foto = $fotos[0]; // Default to first photo

        if (!empty($_FILES['foto' . $i]['name'])) {
            $target_dir = "../img/owner/";
            $file_extension = strtolower(pathinfo($_FILES['foto' . $i]['name'], PATHINFO_EXTENSION));
            $new_filename = 'owner_' . $owner_id . '_' . $i . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;

            // File type validation
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($file_extension, $allowed_types)) {
                if (move_uploaded_file($_FILES['foto' . $i]['tmp_name'], $target_file)) {
                    $current_foto = $new_filename;
                } else {
                    $error_message .= "Sorry, there was an error uploading file $i. ";
                }
            } else {
                $error_message .= "Invalid file type for file $i. Please upload JPG, JPEG, PNG, or GIF. ";
            }
        }

        // Store the photo filename
        $fotos[] = $current_foto;
    }

    // Remove the first default photo from the array
    array_shift($fotos);

    // Update profile query
    $update_query = "UPDATE tb_owner SET 
        owner_name = ?, 
        ig = ?, 
        `desc` = ?, 
        no_telp = ?, 
        email = ?, 
        address = ?, 
        foto = ? 
        WHERE id_owner = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param(
        "sssssssi",
        $owner_name,
        $ig,
        $desc,
        $no_telp,
        $email,
        $address,
        $fotos[0],
        $owner_id
    );

    if ($update_stmt->execute()) {
        $success_message = "Profile updated successfully!";
        // Refresh owner data
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $owner_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $owner_data = $result->fetch_assoc();
    } else {
        $error_message = "Error updating profile: " . $conn->error;
    }
}


// Handle password change
// Handle password change
if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Ambil password tersimpan dari database
    $check_password_query = "SELECT password FROM tb_owner WHERE id_owner = ?";
    $check_stmt = $conn->prepare($check_password_query);
    $check_stmt->bind_param("i", $owner_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Verifikasi password lama
        if (password_verify($old_password, $user['password'])) {
            // Validasi password baru
            if ($new_password === $confirm_password) {
                // Hash password baru
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update password
                $update_query = "UPDATE tb_owner SET password = ? WHERE id_owner = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("si", $hashed_new_password, $owner_id);

                if ($update_stmt->execute()) {
                    $success_message = "Password berhasil diubah!";
                } else {
                    $error_message = "Gagal mengubah password. Silakan coba lagi.";
                }
            } else {
                $error_message = "Password baru tidak cocok.";
            }
        } else {
            $error_message = "Password lama salah.";
        }
    } else {
        $error_message = "Data pengguna tidak ditemukan.";
    }
}


// Rest of the previous code remains the same...
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Owner Dashboard - Rentcos</title>

    <script src="https://kit.fontawesome.com/8c8ccf764d.js" crossorigin="anonymous"></script>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="../styles/css/simplebar.css">
    <!-- Fonts CSS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="../styles/css/feather.css">
    <link rel="stylesheet" href="../styles/css/dataTables.bootstrap4.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="../styles/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="../styles/css/app-light.css" id="lightTheme" disabled>
    <link rel="stylesheet" href="../styles/css/app-dark.css" id="darkTheme">
    <script>
        // Preview image function
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</head>


<body class="bg-gray-100">
    <div class="container">
        <nav class="topnav navbar navbar-light">
            <ul class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
                <img src="../img/logo.png" style="width: 100px" alt="">
            </ul>
            <ul class="nav">

                <li class="nav-item">
                    <a class="nav-link text-muted my-2" href="dashboard.php">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="nav-item nav-notif">
                    <a class="nav-link text-muted my-2" href="#" data-bs-toggle="modal"
                        data-bs-target="#addCostumeModal">
                        <i class="fas fa-tshirt"></i>
                        <span class="text-success">+</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted my-2" href="profile.php" data-toggle="modal"
                        data-target=".modal-notif">
                        <i class="fas fa-user-cog"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Error and Success Messages -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <div class="row g-1">
            <div class="col-md-6 mb-2">
                <!-- Profile Information Form -->
                <div class="bg-white shadow-md rounded p-3">
                    <h2 class="text-2xl font-bold mb-4">Update Profile</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <!-- Multiple Photo Upload -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Profile Photo</label>
                            <div>
                                <label class="block text-gray-700 text-sm mb-2">Foto</label>
                                <input type="file" name="foto" class="form-control foto-input mb-2"
                                    accept="../img/owner/*" onchange="prceviewImage(this, 'preview-foto')">
                                <img id="preview-foto" class="img-preview object-cover rounded"
                                    src="../img/owner/<?php echo htmlspecialchars($owner_data['foto'] ?? ''); ?>"
                                    alt="Foto Preview" width="200" height="200">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="owner_name">
                                Owner Name
                            </label>
                            <input class="form-control" id="owner_name" name="owner_name" type="text"
                                value="<?php echo htmlspecialchars($owner_data['owner_name']); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="ig">
                                Instagram
                            </label>
                            <input class="form-control" id="ig" name="ig" type="text"
                                value="<?php echo htmlspecialchars($owner_data['ig']); ?>">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="desc">
                                Description
                            </label>
                            <textarea class="form-control" id="desc" name="desc"
                                rows="4"><?php echo htmlspecialchars($owner_data['desc']); ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="no_telp">
                                Phone Number
                            </label>
                            <input class="form-control" id="no_telp" name="no_telp" type="tel"
                                value="<?php echo htmlspecialchars($owner_data['no_telp']); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                Email
                            </label>
                            <input class="form-control" id="email" name="email" type="email"
                                value="<?php echo htmlspecialchars($owner_data['email']); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
                                Address
                            </label>
                            <textarea class="form-control" id="address" name="address"
                                rows="3"><?php echo htmlspecialchars($owner_data['address']); ?></textarea>
                        </div>






                        <!-- Submit Button -->
                        <div class="flex items-center justify-between">

                            <a href="dashboard.php" name="update_costume" class="btn ">Cancel</a>
                            <button class="btn btn-success" type="submit" name="update_profile">
                                Update Profile
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-md-6">
                <!-- Change Password Form -->
                <div class="bg-white shadow-md rounded p-3">
                    <h2 class="text-2xl font-bold mb-4">Change Password</h2>
                    <form action="" method="POST">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="old_password">
                                Current Password
                            </label>
                            <input class="form-control" id="old_password" name="old_password" type="password">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="new_password">
                                New Password
                            </label>
                            <input class="form-control" id="new_password" name="new_password" type="password" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_password">
                                Confirm New Password
                            </label>
                            <input class="form-control" id="confirm_password" name="confirm_password" type="password"
                                required>
                        </div>

                        <div class="flex items-center justify-between">
                            <button class="btn btn-warning mt-3" type="submit" name="change_password">
                                Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Anime Section End -->
    <?php include 'footer.html'; ?>
    <!-- Footer Section End -->

    <script src="../styles/js/jquery.min.js"></script>
    <script src="../styles/js/popper.min.js"></script>
    <script src="../styles/js/moment.min.js"></script>
    <script src="../styles/js/bootstrap.min.js"></script>
    <script src="../styles/js/simplebar.min.js"></script>
    <script src='../styles/js/daterangepicker.js'></script>
    <script src='../styles/js/jquery.stickOnScroll.js'></script>
    <script src="../styles/js/tinycolor-min.js"></script>
    <script src="../styles/js/config.js"></script>
    <script src='../styles/js/jquery.dataTables.min.js'></script>
    <script src='../styles/js/dataTables.bootstrap4.min.js'></script>

</body>

</html>