<?php
session_start();
include 'db/koneksi.php';

$owner_id = $_GET['id'];
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination setup
$results_per_page = 8; // Number of costumes per page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1
$offset = ($page - 1) * $results_per_page;

// Base query to count total results
$count_query_base = "SELECT COUNT(*) as total 
                     FROM tb_costume c 
                     INNER JOIN tb_owner o ON c.id_owner = o.id_owner 
                     INNER JOIN tb_series s ON c.id_series = s.id_series 
                     INNER JOIN tb_status st ON c.id_status = st.id_status 
                     WHERE o.id_owner = ?";

// Modify count query if search is active
if (!empty($search_query)) {
    $count_query_base .= " AND (c.cos_name LIKE ? OR s.series_name LIKE ?)";
}

// Prepare and execute count query
$stmt_count = $conn->prepare($count_query_base);
if (!empty($search_query)) {
    $search_param = "%$search_query%";
    $stmt_count->bind_param("iss", $owner_id, $search_param, $search_param);
} else {
    $stmt_count->bind_param("i", $owner_id);
}
$stmt_count->execute();
$count_result = $stmt_count->get_result();
$total_results = $count_result->fetch_assoc()['total'];

// Calculate total pages
$total_pages = ceil($total_results / $results_per_page);

// Fetch Costume Data with pagination
$costume_query_base = "SELECT c.*, o.*, s.*, st.* 
                       FROM tb_costume c 
                       INNER JOIN tb_owner o ON c.id_owner = o.id_owner 
                       INNER JOIN tb_series s ON c.id_series = s.id_series 
                       INNER JOIN tb_status st ON c.id_status = st.id_status 
                       WHERE o.id_owner = ?";

// Add search condition if search query exists
if (!empty($search_query)) {
    $costume_query_base .= " AND (c.cos_name LIKE ? OR s.series_name LIKE ?)";
}

// Add pagination
$costume_query_base .= " LIMIT ? OFFSET ?";

// Prepare and execute the query
$stmt = $conn->prepare($costume_query_base);

if (!empty($search_query)) {
    $search_param = "%$search_query%";
    $stmt->bind_param("issii", $owner_id, $search_param, $search_param, $results_per_page, $offset);
} else {
    $stmt->bind_param("iii", $owner_id, $results_per_page, $offset);
}

$stmt->execute();
$costume_result = $stmt->get_result();

// Fetch Owner Data
$owner_query = "SELECT 
                  o.*,
                  GROUP_CONCAT(DISTINCT m.media_name SEPARATOR ', ') AS media_list,
                  GROUP_CONCAT(DISTINCT g.gender SEPARATOR ', ') AS gender_list,
                  GROUP_CONCAT(DISTINCT k.kat_name SEPARATOR ', ') AS kategori_list
              FROM 
                  tb_owner o
              JOIN 
                  tb_costume c ON o.id_owner = c.id_owner
              LEFT JOIN 
                  tb_series s ON c.id_series = s.id_series
              LEFT JOIN 
                  tb_media m ON s.id_media = m.id_media
              LEFT JOIN 
                  tb_gender g ON c.id_gender = g.id_gender
              LEFT JOIN 
                  tb_kategori k ON c.id_kat = k.id_kat 
              WHERE o.status = 'aktif' AND o.id_owner = ?";
$stmt_owner = $conn->prepare($owner_query);
$stmt_owner->bind_param("i", $owner_id);
$stmt_owner->execute();
$result = $stmt_owner->get_result();

// Cek apakah data ditemukan
if ($result->num_rows > 0) {
    $owner = $result->fetch_assoc();
} else {
    echo "Data owner tidak ditemukan.";
    exit();
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
    <title>Rentcos</title>


    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/8c8ccf764d.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
        </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <!--===============================================================================================-->


    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />


    <!-- Css Styles -->
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css" />
    <link rel="stylesheet" href="css/plyr.css" type="text/css" />
    <link rel="stylesheet" href="css/nice-select.css" type="text/css" />
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css" />
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css" />
    <link rel="stylesheet" href="css/style.css" type="text/css" />

    <!-- Isotope JS -->
    <script src="https://cdn.jsdelivr.net/npm/isotope-layout@3.0.6/dist/isotope.pkgd.min.js"></script>

</head>
<style>
    a {
        text-decoration: none;

    }

    .img-preview {
        max-width: 200px;
        max-height: 200px;
        margin: 10px 0;
        display: none;
    }

    #navbarDropdownMenuLink::after {
        content: none !important;
    }

    .btn-instagram-gradient {
        display: inline-flex;
        /* Gunakan flexbox untuk mengatur posisi */
        justify-content: center;
        /* Posisikan teks di tengah secara horizontal */
        align-items: center;
        /* Posisikan teks di tengah secara vertikal */
        text-decoration: none;
        color: white;
        font-size: 0.875rem;
        /* Ukuran font kecil */
        font-weight: bold;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
        background-size: 200%;
        /* Untuk animasi gradien */
        background-position: 0% 50%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-instagram-gradient:hover {
        background-position: 100% 50%;
        transform: scale(1.05);
    }
</style>

<body>
    <!-- Header Section Begin -->
    <?php include 'function/header.php'; ?>
    <!-- Header End -->
    <div class="container">



        <main class="w-100 px-md-4 mb-3">
            <!-- Breadcrumb Begin -->
            <div class="breadcrumb-option mb-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb__links">
                                <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                                <a href="owners.php">Owners</a>
                                <span><?php echo $owner['owner_name']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Breadcrumb End -->
            <div class="container-fluid rounded bg-dark">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="row mt-5 align-items-center">
                            <div class="col-md-6 col-lg-3 text-center mb-5">
                                <div class="avatar avatar-xl">
                                    <img src="img/owner/<?= htmlspecialchars($owner['foto'] ?? './assets/avatars/default.jpg') ?>"
                                        alt="Foto Profil" class="avatar-img rounded-circle" width="150px">
                                    <p
                                        class="small btn-instagram-gradient  mb-2 mx-2 mt-3 text-muted d-flex align-items-center">
                                        <a href="https://instagram.com/<?= htmlspecialchars($owner['ig']) ?>"
                                            target="_blank" class="ms-3">
                                            <i class="fa fa-instagram text-white me-2">
                                            </i> <span class="text-white"><?= htmlspecialchars($owner['ig']) ?></span>
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-9">
                                <div class="row align-items-center">
                                    <div class="col-md-7">
                                        <h4 class="mb-1 text-white"><?= htmlspecialchars($owner['owner_name']) ?></h4>

                                        <p class="small mb-3"><span
                                                class="badge bg-warning text-dark"><?= htmlspecialchars($owner['media_list'] ?? 'Tidak ada media') ?></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-7">
                                        <p class="text-white"><?= nl2br(htmlspecialchars($owner['desc'])) ?></p>
                                    </div>
                                    <div class="col">
                                        <p class="small mb-2 text-white">
                                            <i class="fa fa-map-marker-alt text-primary me-2"></i>
                                            Alamat: <?= htmlspecialchars($owner['address']) ?>
                                        </p>
                                        <p class="small mb-2 text-white">
                                            <i class="fa fa-phone-alt text-success me-2"></i>
                                            Telepon: <?= htmlspecialchars($owner['no_telp']) ?>
                                        </p>
                                        <p class="small mb-2 text-white">
                                            <i class="fa fa-envelope text-danger me-2"></i>
                                            Email: <?= htmlspecialchars($owner['email']) ?>
                                        </p>


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- .row -->
            </div>

            <!-- Search Form -->
            <form method="GET" action="" class="mt-2">
                <input type="hidden" name="id" value="<?= $owner_id ?>">
                <div class="input-group mb-2">
                    <input type="text" name="search" class="form-control bg-dark text-white border-0"
                        placeholder="Search costumes...">
                    <button class="btn btn-primary ms-2" type="submit"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>

            <div class="row g-1">
                <?php if ($costume_result->num_rows > 0): ?>
                    <?php while ($isi = $costume_result->fetch_assoc()): ?>
                        <?php
                        // Deklarasi variabel
                        extract($isi);
                        $gender_class = $id_gender == 999 ? "1 2 999" : "";
                        $badge_class = $status != "Available" ? "bg-danger" : "bg-success";
                        $gender_icon = $id_gender == 1 ? "fa-mars" : ($id_gender == 2 ? "fa-venus" : "fa-genderless");
                        $gender_color = $id_gender == 1 ? "cayn" : ($id_gender == 2 ? "pink" : "purple");
                        ?>
                        <div class="col-6 col-md-3">
                            <div class="product__item h-100 bg-dark rounded p-2 w-100">
                                <div class="product-container w-100 mb-0">
                                    <a href="costume-detail.php?id=<?= $id_cos ?>">
                                        <img class="rounded w-100" src="img/costume/<?= $foto1 ?>"
                                            alt="<?= htmlspecialchars($cos_name) ?>">
                                    </a>
                                    <div class="produc_icon d-flex justify-content-between p-2 small">
                                        <div class="ep badge <?= $badge_class ?> text-light">
                                            <div class="text"><?= $status ?></div>
                                        </div>
                                        <div class="view badge bg-dark">
                                            <i class="fa fa-eye"></i> <?= $views ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="product__item__text">
                                    <ul class="list-unstyled d-flex flex-wrap small mb-0">
                                        <li class="me-1"><i class="fa-solid <?= $gender_icon ?>"
                                                style="color: <?= $gender_color ?>;"></i></li>
                                        <li class="me-1">Size : <?php echo $size; ?></li>
                                        <li class="me-1"><?php echo $brand; ?></li>
                                    </ul>
                                    <ul>

                                        <li class="bg-warning text-dark"><?php echo $series_name; ?></li>
                                    </ul>
                                    <h5 class="mb-2">
                                        <a href="#"><?php echo $cos_name; ?></a>
                                    </h5>
                                    <ul class="mb-0 ">
                                        <li class="text-warning">Rp
                                            <?php echo number_format($price, 0, ',', '.'); ?>
                                        </li>
                                        <li><?php echo $time; ?> day
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <?= !empty($search_query) ? "No costumes found matching your search." : "No costumes available." ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <nav aria-label="Page navigation" class="mt-3">
                    <ul class="pagination justify-content-center">
                        <?php
                        // Previous page link
                        $prev_page = max(1, $page - 1);
                        $next_page = min($total_pages, $page + 1);

                        // Construct base URL
                        $base_url = "?id=" . $owner_id;
                        if (!empty($search_query)) {
                            $base_url .= "&search=" . urlencode($search_query);
                        }
                        ?>

                        <!-- First Page -->
                        <?php if ($page > 2): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= $base_url ?>&page=1">
                                    <i class="fa-solid fa-angles-left"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- Previous Page -->
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= $base_url ?>&page=<?= $prev_page ?>">
                                    <i class="fa-solid fa-angle-left"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);

                        for ($i = $start_page; $i <= $end_page; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="<?= $base_url ?>&page=<?= $i ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next Page -->
                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= $base_url ?>&page=<?= $next_page ?>">
                                    <i class="fa-solid fa-angle-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- Last Page -->
                        <?php if ($page < $total_pages - 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= $base_url ?>&page=<?= $total_pages ?>">
                                    <i class="fa-solid fa-angles-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>


        </main>
    </div>
    <?php include 'function/footer.html'; ?>


</body>

</html>