<?php
session_start();
include '../db/koneksi.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

// Hapus owner
if (isset($_GET['delete'])) {
    $id_owner = mysqli_real_escape_string($conn, $_GET['delete']);

    // Hapus foto owner terlebih dahulu
    $query_foto = "SELECT foto FROM tb_owner WHERE id_owner = '$id_owner'";
    $result_foto = mysqli_query($conn, $query_foto);
    $foto = mysqli_fetch_assoc($result_foto)['foto'];

    // Hapus file foto dari server jika ada
    if (file_exists("../uploads/" . $foto)) {
        unlink("../uploads/" . $foto);
    }

    // Hapus semua kostum milik owner
    mysqli_query($conn, "DELETE FROM tb_costume WHERE id_owner = '$id_owner'");

    // Hapus owner
    $query_delete = "DELETE FROM tb_owner WHERE id_owner = '$id_owner'";
    mysqli_query($conn, $query_delete);

    header("Location: owners.php");
    exit();
}

// Ambil data semua owner
$query = "SELECT o.*, 
            (SELECT COUNT(*) FROM tb_costume c WHERE c.id_owner = o.id_owner) as total_kostum 
          FROM tb_owner o ORDER BY o.created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

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

    <style>
        .owner-photo {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php include 'nav.php'; ?>
        <main class="container">
            <h2 class="mb-4">Manajemen Owner</h2>

            <table id="ownersTable" class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Instagram</th>
                        <th>Email</th>
                        <th>No Telepon</th>
                        <th>Total Kostum</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td>
                                <a href="../toko-owner.php?id=<?php echo $row['id_owner'] ?>">
                                    <img src="../img/owner/<?= htmlspecialchars($row['foto']) ?>" class="owner-photo"
                                        alt="Foto Owner">
                                </a>
                            </td>
                            <td><?= htmlspecialchars($row['owner_name']) ?></td>
                            <td><?= htmlspecialchars($row['ig']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['no_telp']) ?></td>
                            <td><?= $row['total_kostum'] ?></td>
                            <td>
                                <span class="badge <?= $row['status'] == 'aktif' ? 'bg-success' : 'bg-warning' ?>">
                                    <?= $row['status'] ?>
                                </span>
                            </td>
                            <td>

                                <a href="detail-owner.php?id=<?= $row['id_owner'] ?>" class="btn btn-sm btn-info"> <i
                                        class="fas fa-info-circle"></i></a>
                                <a href="owners.php?delete=<?= $row['id_owner'] ?>"
                                    onclick="return confirm('Yakin ingin menghapus owner?')" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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

    <script>
        $(document).ready(function () {
            $('#ownersTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
        });
    </script>
</body>

</html>