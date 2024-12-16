<?php
session_start();
include '../db/koneksi.php';

// Redirect if not logged in
if (!isset($_SESSION['owner_logged_in'])) {
    header("Location: index.php");
    exit();
}

$owner_id = $_SESSION['owner_id'];

// Fetch owner's costumes with full details
$costumes_query = "SELECT c.*, s.series_name, st.status as status_name, k.kat_name, g.gender 
                   FROM tb_costume c
                   JOIN tb_series s ON c.id_series = s.id_series
                   JOIN tb_status st ON c.id_status = st.id_status
                   JOIN tb_kategori k ON c.id_kat = k.id_kat
                   JOIN tb_gender g ON c.id_gender = g.id_gender
                   WHERE c.id_owner = '$owner_id'";
$costumes_result = mysqli_query($conn, $costumes_query);

// Fetch dropdowns
$series_query = "SELECT * FROM tb_series";
$series_result = mysqli_query($conn, $series_query);

$kategori_query = "SELECT * FROM tb_kategori";
$kategori_result = mysqli_query($conn, $kategori_query);

$gender_query = "SELECT * FROM tb_gender";
$gender_result = mysqli_query($conn, $gender_query);

$status_query = "SELECT * FROM tb_status";
$status_result = mysqli_query($conn, $status_query);

// Handle costume addition
// Handle costume addition
if (isset($_POST['add_costume'])) {
    // Sanitize and validate inputs
    $kategori_id = mysqli_real_escape_string($conn, $_POST['kategori_id']);
    $series_id = mysqli_real_escape_string($conn, $_POST['series_id']);
    $gender_id = mysqli_real_escape_string($conn, $_POST['gender_id']);
    $status_id = mysqli_real_escape_string($conn, $_POST['status_id']);
    $cos_name = mysqli_real_escape_string($conn, $_POST['cos_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);

    // Handle file uploads
    $foto_names = [];
    $upload_dir = '../uploads/';

    for ($i = 1; $i <= 3; $i++) {
        $foto_key = 'foto' . $i;
        if (isset($_FILES[$foto_key]) && $_FILES[$foto_key]['error'] == 0) {
            $foto_name = $owner_id . $i . '_' . basename($_FILES[$foto_key]['name']);
            $foto_path = $upload_dir . $foto_name;

            // Move uploaded file to ../img/costume/ directory
            $upload_dir = '../img/costume/';
            if (move_uploaded_file($_FILES[$foto_key]['tmp_name'], $upload_dir . $foto_name)) {
                $foto_names[$foto_key] = $foto_name;
            }
        }
    }

    // Prepare insert query with pending validation status
    $insert_query = "INSERT INTO tb_costume (
        id_owner, id_kat, id_series, id_gender, id_status, 
        foto1, foto2, foto3, cos_name, c_desc, 
        brand, size, price, link, time, 
        status, validation_status
    ) VALUES (
        '$owner_id', '$kategori_id', '$series_id', '$gender_id', '$status_id', 
        '" . ($foto_names['foto1'] ?? '') . "', 
        '" . ($foto_names['foto2'] ?? '') . "', 
        '" . ($foto_names['foto3'] ?? '') . "', 
        '$cos_name', '$description', '$brand', '$size', '$price', '$link', '$time', 
        'nonaktif', 'rejected'
    )";

    mysqli_query($conn, $insert_query);

    // Redirect to a page that shows pending status
    header("Location: dashboard.php");
    exit();
}

if (isset($_GET['toggle_costume'])) {
    $costume_id = mysqli_real_escape_string($conn, $_GET['toggle_costume']);

    // Ambil status saat ini dari database
    $status_query = "SELECT validation_status FROM tb_costume WHERE id_cos = '$costume_id'";
    $status_result = mysqli_query($conn, $status_query);

    if ($status_result && mysqli_num_rows($status_result) > 0) {
        $row = mysqli_fetch_assoc($status_result);
        $current_status = $row['validation_status'];

        // Jika status adalah 'rejected', tidak boleh diubah
        if ($current_status === 'rejected') {
            echo "<script>alert('Status \"rejected\" tidak dapat diubah.'); window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
        } else {
            // Tentukan status baru
            if ($current_status === 'approved') {
                $new_status = 'pending';
                $new_active_status = 'nonaktif';
            } else if ($current_status === 'pending') {
                $new_status = 'approved';
                $new_active_status = 'aktif';
            }

            // Update status di database
            $update_query = "UPDATE tb_costume
                             SET validation_status = '$new_status',
                                 status = '$new_active_status'
                             WHERE id_cos = '$costume_id'";
            $update_result = mysqli_query($conn, $update_query);

            if ($update_result) {
                // Redirect atau refresh halaman setelah berhasil
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                // Tampilkan pesan error jika query gagal
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Error: Costume ID tidak ditemukan.";
    }
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
<style>
    .img-preview {
        max-width: 200px;
        max-height: 200px;
        margin: 10px 0;
        display: none;
    }

    #navbarDropdownMenuLink::after {
        content: none !important;
    }
</style>

<body>
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
                <li class="nav-item">
                    <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="dark">
                        <i class="fas fa-toggle-on"></i>
                    </a>
                </li>
                <li class="nav-item nav-notif">
                    <a class="nav-link text-muted my-2" href="#" data-bs-toggle="modal"
                        data-bs-target="#addCostumeModal">
                        <i class="fas fa-tshirt"></i>
                        <span class="text-success">+</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link text-muted my-2 dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-cog"></i>

                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="profile.php">Settings</a>
                        <a class="dropdown-item bg-danger" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <main class="w-100 px-md-4">

            <h2 class="h3 mb-4 mt-4 page-title d-flex justify-content-between">Dashboard <a class="btn btn-info btn-sm"
                    href="../toko-owner.php?id=<?php echo $owner_id ?>">Lihat
                    Toko</a></h2>

            <?php include "detail-profile.php"; ?>
            <h3 class="mt-4" id="daftarKostum">Daftar Kostum</h3>
            <div class="table-responsive">
                <table id="costumeTable" class="table table-sm table-hover">
                    <thead>

                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Series</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($costume = mysqli_fetch_assoc($costumes_result)) { ?>
                            <tr <?php if ($costume['validation_status'] == 'pending') {
                                echo 'style="background:#191b1f; opacity: 0.4;"';
                            } else if ($costume['validation_status'] == 'rejected') {
                                echo 'class="bg-danger "';
                            } else if ($costume['status'] == 'nonaktif') {
                                echo 'class="bg-secondary "';
                            } ?>>
                                <td>
                                    <?php
                                    $photos = array_filter([$costume['foto1'], $costume['foto2'], $costume['foto3']]);
                                    $firstPhoto = $photos ? $photos[0] : 'default.jpg'; // Default photo jika kosong
                                    ?>
                                    <img src="../img/costume/<?php echo $firstPhoto; ?>" alt="Costume Photo" class=""
                                        style="max-width: 100px;">
                                </td>
                                <td><?php echo $costume['cos_name']; ?></td>
                                <td><?php echo $costume['series_name']; ?></td>
                                <td><?php echo $costume['kat_name']; ?></td>


                                <td><?php echo !empty($costume['price']) ? 'Rp ' . number_format($costume['price'], 0, ',', '.') : 'N/A'; ?>
                                </td>
                                <?php
                                // Ambil status saat ini dari kostum
                                $status = strtolower($costume['status_name']);
                                ?>
                                <td>
                                    <form action="update_status.php" method="POST">
                                        <input type="hidden" name="id_cos" value="<?php echo $costume['id_cos']; ?>">
                                        <div class="btn-group" role="group" aria-label="Status Costume">
                                            <button type="submit" name="id_status" value="available"
                                                class="btn btn-sm <?php echo $status === 'available' ? 'btn-success' : 'btn-outline-success'; ?>">Avail</button>
                                            <button type="submit" name="id_status" value="booked"
                                                class="btn btn-sm <?php echo $status === 'booked' ? 'btn-warning' : 'btn-outline-warning'; ?>">Booked</button>
                                            <button type="submit" name="id_status" value="coming soon"
                                                class="btn btn-sm <?php echo $status === 'coming soon' ? 'btn-secondary' : 'btn-outline-secondary'; ?>">Soon</button>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <!-- Tombol Modal Detail -->
                                    <button class="btn btn-sm btn-info mb-1" data-bs-toggle="modal"
                                        data-bs-target="#detailModal<?php echo $costume['id_cos']; ?>">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                    <!-- Tombol Edit -->
                                    <a href="edit_costume.php?id=<?php echo $costume['id_cos']; ?>"
                                        class="btn btn-sm btn-primary  mb-1">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="?toggle_costume=<?php echo $costume['id_cos']; ?>"
                                        class="btn btn-warning btn-sm mb-1"><i class="fa-solid fa-power-off"></i></a>
                                    <!-- Tombol Delete -->
                                    <a href="delete_costume.php?id=<?php echo $costume['id_cos']; ?>"
                                        class="btn btn-sm btn-danger  mb-1"
                                        onclick="return confirm('Are you sure you want to delete this costume?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- Modal Detail -->
                            <div class="modal fade" id="detailModal<?php echo $costume['id_cos']; ?>" tabindex="-1"
                                aria-labelledby="detailModalLabel<?php echo $costume['id_cos']; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailModalLabel<?php echo $costume['id_cos']; ?>">
                                                Costume Details
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div id="modalCarousel<?php echo $costume['id_cos']; ?>"
                                                        class="carousel slide" data-bs-ride="carousel">
                                                        <div class="carousel-inner">
                                                            <?php
                                                            $active = true;
                                                            foreach ($photos as $photo) {
                                                                echo "<div class='carousel-item " . ($active ? 'active' : '') . "'>";
                                                                echo "<img src='../img/costume/{$photo}' class='d-block w-100 mb-2' alt='Costume Photo'>";
                                                                echo "</div>";
                                                                $active = false;
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php if (count($photos) > 1): ?>
                                                            <button class="btn carousel-control-prev" type="button"
                                                                data-bs-target="#modalCarousel<?php echo $costume['id_cos']; ?>"
                                                                data-bs-slide="prev">
                                                                <span class="carousel-control-prev-icon"
                                                                    aria-hidden="true"></span>
                                                            </button>
                                                            <button class="btn carousel-control-next" type="button"
                                                                data-bs-target="#modalCarousel<?php echo $costume['id_cos']; ?>"
                                                                data-bs-slide="next">
                                                                <span class="carousel-control-next-icon"
                                                                    aria-hidden="true"></span>
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Name:</strong> <?php echo $costume['cos_name']; ?></p>
                                                    <p><strong>Description:</strong> <?php echo $costume['c_desc']; ?>
                                                    </p>
                                                    <p><strong>Brand:</strong> <?php echo $costume['brand']; ?></p>
                                                    <p><strong>Size:</strong> <?php echo $costume['size']; ?></p>
                                                    <p><strong>Created:</strong>
                                                        <?php echo date('d M Y', strtotime($costume['created_at'])); ?>
                                                    </p>
                                                    <p><strong>Rental Period:</strong>
                                                        <?php echo $costume['time'] . ' days'; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>

    <!-- Add Costume Modal -->
    <div class="modal fade" id="addCostumeModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-white">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kostum Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Kategori</label>
                                <select name="kategori_id" class="form-control" required>
                                    <?php mysqli_data_seek($kategori_result, 0); ?>
                                    <?php while ($kategori = mysqli_fetch_assoc($kategori_result)) { ?>
                                        <option value="<?php echo $kategori['id_kat']; ?>">
                                            <?php echo $kategori['kat_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Series</label>
                                <div class="input-group">
                                    <input type="text" id="seriesSearch"
                                        class="form-control bg-dark text-light border-0" placeholder="Cari Series...">
                                    <select name="series_id" class="form-control" required id="seriesSelect">
                                        <option value="">Pilih Series</option>
                                        <?php mysqli_data_seek($series_result, 0); ?>
                                        <?php while ($series = mysqli_fetch_assoc($series_result)) { ?>
                                            <option value="<?php echo $series['id_series']; ?>">
                                                <?php echo $series['series_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Gender</label>
                                <select name="gender_id" class="form-control" required>
                                    <?php mysqli_data_seek($gender_result, 0); ?>
                                    <?php while ($gender = mysqli_fetch_assoc($gender_result)) { ?>
                                        <option value="<?php echo $gender['id_gender']; ?>">
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
                                        <option value="<?php echo $status['id_status']; ?>">
                                            <?php echo $status['status']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Nama Kostum</label>
                                <input type="text" name="cos_name" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Brand</label>
                                <input type="text" name="brand" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Size</label>
                                <input type="text" name="size" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Harga</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Durasi Rental (Hari)</label>
                                <input type="number" name="time" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Link </label>
                                <input type="text" name="link" class="form-control">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label>Deskripsi</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <?php for ($i = 1; $i <= 3; $i++) { ?>
                                <div class="col-md-4 mb-3">
                                    <label>Foto <?php echo $i; ?></label>
                                    <input type="file" name="foto<?php echo $i; ?>" class="form-control foto-input"
                                        accept="image/*" data-preview-id="preview-foto<?php echo $i; ?>">
                                    <img id="preview-foto<?php echo $i; ?>" class="img-preview" src="" alt="Foto Preview">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a href="../admin/series.php" class="btn btn-info">Tambah Series</a>
                        <div class="btn-group">
                            <a data-bs-dismiss="modal" class="btn">Batal</a>

                            <button type="submit" name="add_costume" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
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
    <script>
        $('#dataTable-1').DataTable(
            {
                autoWidth: true,
                "lengthMenu": [
                    [16, 32, 64, -1],
                    [16, 32, 64, "All"]
                ]
            });
    </script>
    <script src="../styles/js/apps.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-56159088-1');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fotoInputs = document.querySelectorAll('.foto-input');

            fotoInputs.forEach(input => {
                input.addEventListener('change', function () {
                    const previewId = this.getAttribute('data-preview-id');
                    const previewImg = document.getElementById(previewId);

                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            previewImg.src = e.target.result;
                            previewImg.style.display = 'block';
                        }

                        reader.readAsDataURL(this.files[0]);
                    } else {
                        previewImg.style.display = 'none';
                    }
                });
            });
        });

        function filterTable(input, columnIndex) {
            const filter = input.value.toLowerCase();
            const table = document.getElementById('costumeTable');
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cell = row.cells[columnIndex];
                if (cell) {
                    const text = cell.textContent || cell.innerText;
                    row.style.display = text.toLowerCase().includes(filter) ? '' : 'none';
                }
            });
        }

        $(document).ready(function () {
            $('#costumeTable').DataTable({
                searching: true,  // Aktifkan pencarian
                paging: true,     // Aktifkan paginasi
                ordering: true    // Aktifkan pengurutan
            });
        });


    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('seriesSearch');
            const seriesSelect = document.getElementById('seriesSelect');

            searchInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase().trim();

                let matchedOption = null;

                // Loop through all options and show/hide based on search term
                Array.from(seriesSelect.options).forEach(option => {
                    if (option.value === '') {
                        // Always keep "Pilih Series" option visible
                        option.style.display = 'block';
                        return;
                    }

                    const optionText = option.text.toLowerCase();

                    if (optionText.includes(searchTerm)) {
                        option.style.display = 'block';
                        // Check if this is the first match, if so, select it
                        if (!matchedOption) {
                            matchedOption = option;
                        }
                    } else {
                        option.style.display = 'none';
                    }
                });

                // Automatically select the first matched option
                if (matchedOption) {
                    seriesSelect.value = matchedOption.value;
                }
            });
        });
    </script>

    <style>
        #seriesSearch {
            max-width: 50%;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        #seriesSelect {
            max-width: 50%;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
    </style>
</body>

</html>