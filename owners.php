<?php
include 'db/koneksi.php';

// Initialize search and filter variables
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$kategori_filter = isset($_GET['kategori']) ? mysqli_real_escape_string($conn, $_GET['kategori']) : '';
$gender_filter = isset($_GET['gender']) ? mysqli_real_escape_string($conn, $_GET['gender']) : '';
$media_filter = isset($_GET['media']) ? mysqli_real_escape_string($conn, $_GET['media']) : '';

// Construct the SQL query with dynamic filtering
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
              WHERE o.status = 'aktif'";

// Add search condition if search query is provided
if (!empty($search_query)) {
    $owner_query .= " AND (o.owner_name LIKE '%$search_query%' 
                           OR o.address LIKE '%$search_query%' 
                           OR o.ig LIKE '%$search_query%')";
}

// Add kategori filter condition
if (!empty($kategori_filter)) {
    $owner_query .= " AND k.kat_name = '$kategori_filter'";
}

// Add gender filter condition
if (!empty($gender_filter)) {
    $owner_query .= " AND g.gender = '$gender_filter'";
}

// Add media filter condition
if (!empty($media_filter)) {
    $owner_query .= " AND m.media_name = '$media_filter'";
}

$owner_query .= " GROUP BY o.id_owner";

// Execute the query
$tampil = mysqli_query($conn, $owner_query);

// Fetch filter options for dropdowns
$kategori_options_query = "SELECT DISTINCT kat_name FROM tb_kategori";
$kategori_options_result = mysqli_query($conn, $kategori_options_query);

$gender_options_query = "SELECT DISTINCT gender FROM tb_gender";
$gender_options_result = mysqli_query($conn, $gender_options_query);

$media_options_query = "SELECT DISTINCT media_name FROM tb_media";
$media_options_result = mysqli_query($conn, $media_options_query);


// Query untuk mendapatkan Top 5 Owners berdasarkan jumlah kostum
$top_owners_query = "
    SELECT o.*, COUNT(c.id_cos) AS total_costumes
    FROM tb_owner o
    LEFT JOIN tb_costume c ON o.id_owner = c.id_owner
    WHERE o.status = 'aktif'
    GROUP BY o.id_owner
    ORDER BY total_costumes DESC
    LIMIT 5";
$top_owners_result = mysqli_query($conn, $top_owners_query);

// Query untuk mendapatkan Top 5 Kostum berdasarkan jumlah dilihat
$top_costumes_query = "
    SELECT c.*, c.views AS total_view
    FROM tb_costume c
    WHERE c.status = 'aktif'
    ORDER BY total_view DESC
    LIMIT 5";
$top_costumes_result = mysqli_query($conn, $top_costumes_query);

?>

<!DOCTYPE html>
<html lang="zxx">

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
</head>

<style>
    a {
        text-decoration: none;
    }
</style>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <?php include 'function/header.php'; ?>
    <!-- Header End -->
    <section class="container">

        <!-- Breadcrumb Begin -->
        <div class="breadcrumb-option">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb__links">
                            <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                            <a href="./owners.html">Owners</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <div class="container">
            <div class="row height mt-3 d-flex justify-content-center align-items-center mb-4">
                <div class="col-12">

                    <form method="GET" action="">
                        <div class="btn-group w-100">

                            <button type="submit" class="btn btn-dark">
                                <rch class="fas fa-search"></rch>
                            </button>
                            <input type="text" name="search" class="form-control btn btn-dark text-white"
                                placeholder="Search Owner">

                        </div>
                    </form>
                </div>
                <div class="col-12">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="" class="mb-4 mt-2">
                        <div class="row g-1">
                            <div class="col-4">
                                <div class="dropdown">
                                    <button class="btn btn-dark dropdown-toggle w-100" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo !empty($kategori_filter) ? $kategori_filter : 'All Categories'; ?>
                                    </button>
                                    <ul class="dropdown-menu w-100">
                                        <li><a class="dropdown-item"
                                                href="?<?php echo http_build_query(array_merge($_GET, ['kategori' => ''])); ?>">All
                                                Categories</a></li>
                                        <?php while ($row = mysqli_fetch_assoc($kategori_options_result)): ?>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="?<?php
                                                    echo http_build_query(array_merge($_GET, ['kategori' => $row['kat_name']])); ?>">
                                                    <?php echo $row['kat_name']; ?>
                                                </a>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="dropdown">
                                    <button class="btn btn-dark dropdown-toggle w-100" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo !empty($gender_filter) ? $gender_filter : 'All Genders'; ?>
                                    </button>
                                    <ul class="dropdown-menu w-100">
                                        <li><a class="dropdown-item"
                                                href="?<?php echo http_build_query(array_merge($_GET, ['gender' => ''])); ?>">All
                                                Genders</a></li>
                                        <?php while ($row = mysqli_fetch_assoc($gender_options_result)): ?>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="?<?php
                                                    echo http_build_query(array_merge($_GET, ['gender' => $row['gender']])); ?>">
                                                    <?php echo $row['gender']; ?>
                                                </a>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="dropdown">
                                    <button class="btn btn-dark dropdown-toggle w-100" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo !empty($media_filter) ? $media_filter : 'All Media'; ?>
                                    </button>
                                    <ul class="dropdown-menu w-100">
                                        <li><a class="dropdown-item"
                                                href="?<?php echo http_build_query(array_merge($_GET, ['media' => ''])); ?>">All
                                                Media</a>
                                        </li>
                                        <?php while ($row = mysqli_fetch_assoc($media_options_result)): ?>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="?<?php
                                                    echo http_build_query(array_merge($_GET, ['media' => $row['media_name']])); ?>">
                                                    <?php echo $row['media_name']; ?>
                                                </a>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>



            </div>

            <!-- Owners Grid -->
            <div class="section-title mt-3">
                <h4>Owners</h4>
            </div>
            <div class="row">

                <div class="col-12 col-md-12 col-lg-8">
                    <!-- Owners Container (Existing HTML with slight modifications) -->
                    <div id="owners-container" class="row isotope-container">
                        <?php
                        // Check if any results found
                        if (mysqli_num_rows($tampil) > 0) {
                            mysqli_data_seek($tampil, 0); // Reset the result pointer
                            while ($isi = mysqli_fetch_array($tampil)) {
                                $owner_name = $isi['owner_name'];
                                $id_owner = $isi['id_owner'];
                                $address = $isi['address'];
                                $foto = $isi['foto'];
                                $ig = $isi['ig'];
                                $media_list = $isi['media_list'];
                                $gender_list = $isi['gender_list'];
                                $kategori_list = $isi['kategori_list'];
                                ?>
                                <div class="col-12 col-md-6 owner-item">
                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <a href="toko-owner.php?id=<?php echo $id_owner ?>">
                                                <img src="img/owner/<?php echo $foto ?>" class="img rounded" alt=""
                                                    width="150px" />
                                            </a>
                                        </div>
                                        <div class="col-8 pt-2">
                                            <h5>
                                                <a class="text-white fw-bold" href="toko-owner.php?id=<?php echo $id_owner ?>">
                                                    <?php echo $owner_name ?>
                                                </a>
                                            </h5>
                                            <div>
                                                <div class="text-secondary small">
                                                    <i class="fab fa-instagram"></i> <?php echo $ig ?>
                                                </div>
                                                <div class="text-secondary small">
                                                    <i class="fas fa-map-marker-alt"></i> <?php echo $address ?>
                                                </div>
                                            </div>
                                            <div class="overflow-auto mt-2">
                                                <ul class="d-flex flex-nowrap list-unstyled">
                                                    <li class="badge bg-dark rounded-pill text-white"
                                                        style="margin-right: 5px;">
                                                        <?php echo $kategori_list; ?>
                                                    </li>
                                                    <li class="badge bg-dark rounded-pill text-white"
                                                        style="margin-right: 5px;">
                                                        <?php echo $media_list; ?>
                                                    </li>
                                                    <li class="badge bg-dark rounded-pill text-white border border-secondary"
                                                        style="margin-right: 5px;">
                                                        <?php echo $gender_list; ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-4">

                    <div class="row mb-3">
                        <div class="col-12 mb-4">
                            <h6 class="bg-warning text-dark rounded p-2 mb-1 text-center">Top 5 Owners</h6>
                            <div class="row">
                                <?php if ($top_owners_result && mysqli_num_rows($top_owners_result) > 0) {
                                    $rank = 1;
                                    while ($row = mysqli_fetch_assoc($top_owners_result)) { ?>
                                        <div class="col-12 mb-1">
                                            <a href="toko-owner.php?id=<?php echo $row['id_owner'] ?>">
                                                <div class="card top-owner bg-dark text-white shadow-sm h-100">
                                                    <div class="d-flex align-items-center p-3">
                                                        <img src="img/owner/<?php echo $row['foto']; ?>" alt="Owner Image"
                                                            class="rounded-circle me-3"
                                                            style="width: 60px; height: 60px; object-fit: cover;">
                                                        <div class="ml-2">
                                                            <h6 class="mb-1">#<?php echo $rank++; ?>
                                                                <?php echo htmlspecialchars($row['owner_name']); ?>
                                                            </h6>
                                                            <p class="mb-0 text-secondary">🎭 Kostum:
                                                                <strong
                                                                    class="text-warning"><?php echo $row['total_costumes']; ?></strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <p class="text-center">No data available</p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <h6 class="bg-warning text-dark rounded p-2 mb-1 text-center">Top 5 Kostum</h6>
                            <div class="row">
                                <?php if ($top_costumes_result && mysqli_num_rows($top_costumes_result) > 0) {
                                    $rank = 1;
                                    while ($row = mysqli_fetch_assoc($top_costumes_result)) { ?>
                                        <div class="col-12 mb-1">
                                            <a href="costume-detail.php?id=<?php echo $row['id_cos'] ?>">
                                                <div class="card top-owner bg-dark text-white shadow-sm h-100">
                                                    <div class="d-flex align-items-center p-2">
                                                        <img src="img/costume/<?php echo $row['foto1']; ?>" alt="Costume Image"
                                                            class="rounded me-3"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                        <div class="ml-2">
                                                            <h6 class="mb-1">#<?php echo $rank++; ?>
                                                                <?php echo htmlspecialchars($row['cos_name']); ?>
                                                            </h6>
                                                            <p class="mb-0 text-secondary">👁️ Dilihat:
                                                                <strong
                                                                    class="text-warning"><?php echo $row['total_view']; ?></strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <p class="text-center">No data available</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    </section>
    <!-- Product Section End -->

    <?php include 'function/footer.html'; ?>

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
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/player.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/isotope-layout@3.0.6/dist/isotope.pkgd.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize Isotope
            var $container = $('#owners-container').isotope({
                itemSelector: '.owner-item',
                layoutMode: 'fitRows'
            });

            // Store filter for each group
            var filters = {};

            // Filter buttons
            $('.filter-btn').on('click', function () {
                var $this = $(this);
                var $buttonGroup = $this.parents('.btn-group');
                var filterGroup = $buttonGroup.attr('aria-label');
                var filterValue = $this.attr('data-filter');
                var group = $this.attr('data-group');

                // Set filter for group
                filters[group] = filterValue;

                // Combine filters
                var combinedFilter = concatValues(filters);

                $container.isotope({ filter: combinedFilter });

                // Update active state of filter buttons in this group
                $buttonGroup.find('.filter-btn').removeClass('active');
                $this.addClass('active');
            });

            // Quicksearch
            $('#quicksearch').on('keyup', function () {
                var searchValue = $(this).val().toLowerCase();

                $container.isotope({
                    filter: function () {
                        var name = $(this).attr('data-name');
                        return name.indexOf(searchValue) > -1;
                    }
                });
            });

            // Flatten object by concatenating values
            function concatValues(obj) {
                var value = '';
                for (var prop in obj) {
                    value += obj[prop];
                }
                return value;
            }
        });
    </script>


</body>

</html>