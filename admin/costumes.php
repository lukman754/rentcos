<?php
session_start();
include '../db/koneksi.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

// Fetch owner's costumes with full details
$costumes_query = "SELECT c.*, o.owner_name, s.series_name, st.status as status_name, k.kat_name, g.gender 
                   FROM tb_costume c
                   JOIN tb_series s ON c.id_series = s.id_series
                   JOIN tb_status st ON c.id_status = st.id_status
                   JOIN tb_kategori k ON c.id_kat = k.id_kat
                   JOIN tb_owner o ON c.id_owner = o.id_owner
                   JOIN tb_gender g ON c.id_gender = g.id_gender";
$costumes_result = mysqli_query($conn, $costumes_query);


if (isset($_GET['toggle_costume'])) {
    $costume_id = mysqli_real_escape_string($conn, $_GET['toggle_costume']);

    // Ambil status saat ini dari database
    $status_query = "SELECT validation_status FROM tb_costume WHERE id_cos = '$costume_id'";
    $status_result = mysqli_query($conn, $status_query);

    if ($status_result && mysqli_num_rows($status_result) > 0) {
        $row = mysqli_fetch_assoc($status_result);
        $current_status = $row['validation_status'];

        // Tentukan status baru
        if ($current_status === 'rejected') {
            $new_status = 'approved';
            $new_active_status = 'aktif';
        } else {
            $new_status = 'rejected';
            $new_active_status = 'nonaktif';
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
    <title>Admin Dashboard - Rentcos</title>
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
        <?php include 'nav.php'; ?>
        <main class="w-100 px-md-4">

            <h3 class="mt-4">Daftar Kostum</h3>
            <div class="table-responsive">
                <table id="costumeTable" class="table table-sm table-hover">
                    <thead>

                        <tr>
                            <th>Photo</th>
                            <th>Owner</th>
                            <th>Name</th>
                            <th>Series</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($costume = mysqli_fetch_assoc($costumes_result)) { ?>
                            <tr <?php if ($costume['validation_status'] == 'pending') {
                                echo 'style="background:#655100; opacity: 0.4;"';
                            } else if ($costume['validation_status'] == 'rejected') {
                                echo 'class="bg-danger "';
                            } ?>>

                                <td>
                                    <?php
                                    $photos = array_filter([$costume['foto1'], $costume['foto2'], $costume['foto3']]);
                                    $firstPhoto = $photos ? $photos[0] : 'default.jpg'; // Default photo jika kosong
                                    ?>
                                    <a href="../costume-detail.php?id=<?php echo $costume['id_cos'] ?>">
                                    <img src="../img/costume/<?php echo $firstPhoto; ?>" alt="Costume Photo" class="" style="max-width: 100px;">
                                    </a>
                                </td>

                                <td><a href="detail-owner.php?id=<?php echo $costume['id_owner']; ?>"><span class="badge bg-secondary text-dark"><?php echo $costume['owner_name']; ?></span></a>
                                </td>
                                <td><?php echo $costume['cos_name']; ?></td>
                                <td><?php echo $costume['series_name']; ?></td>
                                <td><?php echo $costume['kat_name']; ?></td>
                                <td><?php
                                // Tetapkan kelas warna berdasarkan status
                                $status = strtolower($costume['status_name']); // Pastikan dalam lowercase
                                $badgeClass = 'bg-secondary text-white'; // Default warna (abu-abu)
                                if ($status === 'available') {
                                    $badgeClass = 'bg-success text-white'; // Hijau
                                } elseif ($status === 'booked') {
                                    $badgeClass = 'bg-warning text-white'; // Kuning
                                } elseif ($status === 'coming soon') {
                                    $badgeClass = 'bg-secondary text-white'; // Abu-abu 
                                }
                                ?>
                                    <span class="badge <?php echo $badgeClass; ?>">
                                        <?php echo ucfirst($costume['status_name']); ?>
                                    </span>
                                </td>
                                <td><?php echo !empty($costume['price']) ? 'Rp ' . number_format($costume['price'], 0, ',', '.') : 'N/A'; ?>
                                </td>
                                <td>
                                    <!-- Tombol Modal Detail -->
                                    <button class="btn btn-sm btn-info mb-1" data-bs-toggle="modal"
                                        data-bs-target="#detailModal<?php echo $costume['id_cos']; ?>">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                    <a href="?toggle_costume=<?php echo $costume['id_cos']; ?>"
                                        class="btn btn-warning btn-sm mb-1"><i class="fa-solid fa-power-off"></i></a>
                                    <!-- Tombol Delete -->
                                    <a href="../owner/delete_costume.php?id=<?php echo $costume['id_cos']; ?>"
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
                                                    </p>
                                                    <a
                                                        href="<?php echo $costume['link']; ?>" class="text-warning"><?php echo $costume['link']; ?></a>

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
</body>

</html>