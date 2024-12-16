<?php
session_start();
include '../db/koneksi.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

// Fetch pending owners
$pending_owners_query = "SELECT * FROM tb_owner WHERE status = 'nonaktif'";
$pending_owners_result = mysqli_query($conn, $pending_owners_query);



// In admin dashboard or a separate validation page// Modify the query to join with tb_gender
$pending_costumes_query = "SELECT c.*, o.owner_name, k.kat_name, s.series_name, g.gender 
                           FROM tb_costume c
                           JOIN tb_owner o ON c.id_owner = o.id_owner
                           JOIN tb_kategori k ON c.id_kat = k.id_kat
                           JOIN tb_series s ON c.id_series = s.id_series
                           JOIN tb_gender g ON c.id_gender = g.id_gender
                           WHERE c.validation_status = 'rejected'"; // Note: changed from validation_status to status based on the schema

$pending_costumes_result = mysqli_query($conn, $pending_costumes_query);

$hasDataOwner = $pending_owners_result->num_rows > 0;
$hasDataCostume = $pending_costumes_result->num_rows > 0;


$total_owners = ($total_owners_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_owner WHERE status = 'aktif'"))
    ? mysqli_fetch_assoc($total_owners_result)['total']
    : 0;

$total_costumes = ($total_costumes_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_costume WHERE status = 'aktif'"))
    ? mysqli_fetch_assoc($total_costumes_result)['total']
    : 0;

// Handle owner activation
if (isset($_GET['activate_owner'])) {
    $owner_id = mysqli_real_escape_string($conn, $_GET['activate_owner']);
    $activate_query = "UPDATE tb_owner SET status = 'aktif' WHERE id_owner = '$owner_id'";
    mysqli_query($conn, $activate_query);
    header("Location: dashboard.php");
    exit();
}

// Handle costume approval/rejection
// Periksa apakah tombol setuju atau tolak diklik
if (isset($_GET['approve_costume'])) {
    $costume_id = mysqli_real_escape_string($conn, $_GET['approve_costume']);
    $approve_query = "UPDATE tb_costume
                      SET validation_status = 'approved',
                          status = 'aktif'
                      WHERE id_cos = '$costume_id'";
    $result = mysqli_query($conn, $approve_query);

    if ($result) {
        // Redirect atau refresh halaman setelah berhasil
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Tampilkan pesan error jika query gagal
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_GET['reject_costume'])) {
    $costume_id = mysqli_real_escape_string($conn, $_GET['reject_costume']);
    $reject_query = "UPDATE tb_costume
                     SET validation_status = 'rejected',
                         status = 'nonaktif'
                     WHERE id_cos = '$costume_id'";
    $result = mysqli_query($conn, $reject_query);

    if ($result) {
        // Redirect atau refresh halaman setelah berhasil
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Tampilkan pesan error jika query gagal
        echo "Error: " . mysqli_error($conn);
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
    <link rel="stylesheet" href="../styles/css/app-light.css" id="lightTheme" disabled>
    <link rel="stylesheet" href="../styles/css/app-dark.css" id="darkTheme">
</head>

<body>
    <div class="container">
        <?php include 'nav.php'; ?>
        <div class="container">
            <h1 class="mt-4">Admin Dashboard</h1>

            <div class="row mb-3 g-2">
                <!-- Total Owners Card -->
                <div class="col-6">
                    <div class="card text-center shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Total Owners</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text display-4 fw-bold text-primary">
                                <?php echo $total_owners; ?>
                            </p>
                        </div>
                        <div class="card-footer text-muted">
                            Total jumlah pemilik aktif
                        </div>
                    </div>
                </div>

                <!-- Total Costumes Card -->
                <div class="col-6">
                    <div class="card text-center shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Total Costumes</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text display-4 fw-bold text-success">
                                <?php echo $total_costumes; ?>
                            </p>
                        </div>
                        <div class="card-footer text-muted">
                            Total jumlah kostum yang tersedia
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-12">
                    <h3 class="bg-warning text-dark rounded p-1">Pending Owner Registrations</h3>
                    <?php if ($hasDataOwner): ?>
                        <table class="table table-striped <?php echo !$hasDataOwner ? 'd-none' : ''; ?>">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Instagram</th>
                                    <th>Email</th>
                                    <th>No. Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($owner = mysqli_fetch_assoc($pending_owners_result)) { ?>
                                    <tr>
                                        <td><?php echo $owner['id_owner']; ?></td>
                                        <td>
                                            <img src="../img/owner/<?php echo $owner['foto']; ?>"
                                                alt="<?php echo $owner['owner_name']; ?>"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                        </td>
                                        <td><?php echo $owner['owner_name']; ?></td>
                                        <td>@<?php echo $owner['ig']; ?></td>
                                        <td><?php echo $owner['email']; ?></td>
                                        <td><?php echo $owner['no_telp']; ?></td>
                                        <td>
                                            <a href="?activate_owner=<?php echo $owner['id_owner']; ?>"
                                                class="btn btn-success btn-sm">Aktivasi</a>
                                            <a href="owners.php?delete=<?php echo $owner['id_owner']; ?>"
                                                onclick="return confirm('Yakin ingin menghapus owner?')"
                                                class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                </div>
                <div class="col-12">
                    <h3 class="bg-warning text-dark rounded p-1">Pending Costumes</h3>
                    <?php if ($hasDataCostume): ?>

                        <table class="table table-striped <?php echo !$hasDataCostume ? 'd-none' : ''; ?>">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Kostum</th>
                                    <th>Owner</th>
                                    <th>Kategori</th>
                                    <th>Seri</th>
                                    <th>Gender</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($costume = mysqli_fetch_assoc($pending_costumes_result)) { ?>
                                    <tr>
                                        <td><?php echo $costume['id_cos']; ?></td>
                                        <td><?php echo $costume['cos_name']; ?></td>
                                        <td><?php echo $costume['owner_name']; ?></td>
                                        <td><?php echo $costume['kat_name']; ?></td>
                                        <td><?php echo $costume['series_name']; ?></td>
                                        <td><?php echo $costume['gender']; ?></td>
                                        <td>Rp <?php echo number_format($costume['price'], 0, ',', '.'); ?></td>
                                        <td>
                                            <a href="?approve_costume=<?php echo $costume['id_cos']; ?>"
                                                class="btn btn-success btn-sm">Setuju</a>
                                            <a href="?reject_costume=<?php echo $costume['id_cos']; ?>"
                                                class="btn btn-danger btn-sm">Tolak</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>

        </div>





    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>