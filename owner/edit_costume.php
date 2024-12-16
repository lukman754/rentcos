<?php
session_start();
include '../db/koneksi.php';

// Redirect if not logged in
if (!isset($_SESSION['owner_logged_in'])) {
    header("Location: index.php");
    exit();
}

$owner_id = $_SESSION['owner_id'];
$costume_id = $_GET['id'] ?? null;

// Fetch costume details
$costume_query = "SELECT * FROM tb_costume WHERE id_cos = '$costume_id' AND id_owner = '$owner_id'";
$costume_result = mysqli_query($conn, $costume_query);
$costume = mysqli_fetch_assoc($costume_result);

if (!$costume) {
    die("Costume not found or you don't have permission to edit.");
}

// Fetch dropdowns
$series_query = "SELECT * FROM tb_series";
$series_result = mysqli_query($conn, $series_query);

$kategori_query = "SELECT * FROM tb_kategori";
$kategori_result = mysqli_query($conn, $kategori_query);

$gender_query = "SELECT * FROM tb_gender";
$gender_result = mysqli_query($conn, $gender_query);

$status_query = "SELECT * FROM tb_status";
$status_result = mysqli_query($conn, $status_query);

// Handle costume update
if (isset($_POST['update_costume'])) {
    $update_data = [
        'id_kat' => mysqli_real_escape_string($conn, $_POST['kategori_id']),
        'id_series' => mysqli_real_escape_string($conn, $_POST['series_id']),
        'id_gender' => mysqli_real_escape_string($conn, $_POST['gender_id']),
        'id_status' => mysqli_real_escape_string($conn, $_POST['status_id']),
        'cos_name' => mysqli_real_escape_string($conn, $_POST['cos_name']),
        'c_desc' => mysqli_real_escape_string($conn, $_POST['description']),
        'brand' => mysqli_real_escape_string($conn, $_POST['brand']),
        'size' => mysqli_real_escape_string($conn, $_POST['size']),
        'price' => mysqli_real_escape_string($conn, $_POST['price']),
        'link' => mysqli_real_escape_string($conn, $_POST['link']),
        'time' => mysqli_real_escape_string($conn, $_POST['time']),
        'validation_status' => 'pending',
    ];

    // Handle image uploads
    for ($i = 1; $i <= 3; $i++) {
        $foto_key = 'foto' . $i;
        $remove_key = 'remove_foto' . $i;

        // Check if removing existing image
        if (isset($_POST[$remove_key])) {
            $update_data[$foto_key] = '';
            // Optional: Delete physical file if needed
            if (!empty($costume[$foto_key])) {
                $file_path = "../img/costume/" . $costume[$foto_key];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
        }

        // Handle new image upload
        if (!empty($_FILES[$foto_key]['name'])) {
            $file_name = uniqid() . '_' . basename($_FILES[$foto_key]['name']);
            $target_path = "../img/costume/" . $file_name;

            if (move_uploaded_file($_FILES[$foto_key]['tmp_name'], $target_path)) {
                $update_data[$foto_key] = $file_name;

                // Delete old file if exists
                if (!empty($costume[$foto_key])) {
                    $old_file_path = "../img/costume/" . $costume[$foto_key];
                    if (file_exists($old_file_path)) {
                        unlink($old_file_path);
                    }
                }
            }
        }
    }

    // Build update query
    $set_clauses = [];
    foreach ($update_data as $key => $value) {
        $set_clauses[] = "$key = '$value'";
    }
    $update_query = "UPDATE tb_costume SET " . implode(', ', $set_clauses) . " WHERE id_cos = '$costume_id'";

    mysqli_query($conn, $update_query);
    header("Location: dashboard.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
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
</head>
<body>
    <div class="container">
        <nav class="topnav navbar navbar-light">
            <ul class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
                <img src="../img/logo.png" style="width: 100px" alt="">
            </ul>
            <ul class="nav">
                
                <li class="nav-item">
                    <a class="nav-link text-muted my-2" href="dashboard.php" >
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
        <form method="post" enctype="multipart/form-data">
            
            <div class="modal-body">
                
        <h3>Edit Costume</h3>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Kategori</label>
                        <select name="kategori_id" class="form-control" required>
                            <?php mysqli_data_seek($kategori_result, 0); ?>
                            <?php while ($kategori = mysqli_fetch_assoc($kategori_result)) { ?>
                                <option value="<?php echo $kategori['id_kat']; ?>" 
                                    <?php echo ($kategori['id_kat'] == $costume['id_kat']) ? 'selected' : ''; ?>>
                                    <?php echo $kategori['kat_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Seri</label>
                        <select name="series_id" class="form-control" required>
                            <?php mysqli_data_seek($series_result, 0); ?>
                            <?php while ($series = mysqli_fetch_assoc($series_result)) { ?>
                                <option value="<?php echo $series['id_series']; ?>" 
                                    <?php echo ($series['id_series'] == $costume['id_series']) ? 'selected' : ''; ?>>
                                    <?php echo $series['series_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Gender</label>
                        <select name="gender_id" class="form-control" required>
                            <?php mysqli_data_seek($gender_result, 0); ?>
                            <?php while ($gender = mysqli_fetch_assoc($gender_result)) { ?>
                                <option value="<?php echo $gender['id_gender']; ?>" 
                                    <?php echo ($gender['id_gender'] == $costume['id_gender']) ? 'selected' : ''; ?>>
                                    <?php echo $gender['gender']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select name="status_id" class="form-control" required>
                            <?php mysqli_data_seek($status_result, 0); ?>
                            <?php while ($status = mysqli_fetch_assoc($status_result)) { ?>
                                <option value="<?php echo $status['id_status']; ?>" 
                                    <?php echo ($status['id_status'] == $costume['id_status']) ? 'selected' : ''; ?>>
                                    <?php echo $status['status']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Nama Kostum</label>
                        <input type="text" name="cos_name" class="form-control" value="<?php echo htmlspecialchars($costume['cos_name']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Brand</label>
                        <input type="text" name="brand" class="form-control" value="<?php echo htmlspecialchars($costume['brand']); ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Size</label>
                        <input type="text" name="size" class="form-control" value="<?php echo htmlspecialchars($costume['size']); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Harga</label>
                        <input type="number" name="price" class="form-control" value="<?php echo htmlspecialchars($costume['price']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Durasi Rental (Hari)</label>
                        <input type="number" name="time" class="form-control" value="<?php echo htmlspecialchars($costume['time']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Link Referensi</label>
                        <input type="text" name="link" class="form-control" value="<?php echo htmlspecialchars($costume['link']); ?>">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control"><?php echo htmlspecialchars($costume['c_desc']); ?></textarea>
                    </div>
                </div>

                <div class="row">
                    <?php for ($i = 1; $i <= 3; $i++) { ?>
                        <div class="col-md-4 mb-3">
                         <label>Foto <?php echo $i; ?></label>
                            <input type="file" name="foto<?php echo $i; ?>" class="form-control foto-input" accept="image/*"
                                data-preview-id="preview-foto<?php echo $i; ?>">
                        
                            <!-- Remove image button -->
                            <button type="button" class="btn btn-danger btn-sm w-100 mt-2 remove-image-btn" data-preview-id="preview-foto<?php echo $i; ?>"
                                data-input-name="foto<?php echo $i; ?>">
                                Hapus
                            </button>
                        
                            <img id="preview-foto<?php echo $i; ?>" class="img-preview mt-2 rounded w-100"
                                src="../img/costume/<?php echo htmlspecialchars($costume['foto' . $i] ?? ''); ?>" width="250px">
                        </div>

                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                
                <a href="dashboard.php" name="update_costume" class="btn ">Cancel</a>
                <button type="submit" name="update_costume" class="btn btn-primary">Update Costume</button>
            </div>
        </form>
    </div>
    
    <!-- Anime Section End -->
    <?php include 'footer.html'; ?>
    <!-- Footer Section End -->

</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality
    const fileInputs = document.querySelectorAll('.foto-input');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const previewId = this.getAttribute('data-preview-id');
            const previewImg = document.getElementById(previewId);
            
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImg.src = event.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    // Select all remove image buttons
    const removeButtons = document.querySelectorAll(".remove-image-btn");

    removeButtons.forEach(button => {
        button.addEventListener("click", function () {
            const previewId = this.getAttribute("data-preview-id"); // Get the preview image ID
            const inputName = this.getAttribute("data-input-name"); // Get the file input name

            // Find the preview image and clear its src
            const previewImage = document.getElementById(previewId);
            if (previewImage) {
                previewImage.src = ""; // Clear image preview
            }

            // Find the file input and reset its value
            const fileInput = document.querySelector(`input[name="${inputName}"]`);
            if (fileInput) {
                fileInput.value = ""; // Reset input
            }
        });
    });

});

</script>
</html>