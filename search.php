<?php
// Database Connection
include 'db/koneksi.php';

// Pagination and Filtering Variables
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 12; // Items per page
$offset = ($page - 1) * $limit;

// Filter and Search Parameters
$filter_category = isset($_GET['category']) ? intval($_GET['category']) : null;
$filter_media = isset($_GET['media']) ? intval($_GET['media']) : null;
$filter_series = isset($_GET['series']) ? intval($_GET['series']) : null;
$filter_gender = isset($_GET['gender']) ? intval($_GET['gender']) : null;
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : null;

// Base Query
$base_query = "
    SELECT c.*, s.series_name, st.status as st_status, m.media_name, k.kat_name, g.gender, o.* 
    FROM tb_costume c
    JOIN tb_series s ON c.id_series = s.id_series
    JOIN tb_status st ON c.id_status = st.id_status
    JOIN tb_media m ON s.id_media = m.id_media
    JOIN tb_kategori k ON c.id_kat = k.id_kat
    JOIN tb_owner o ON c.id_owner = o.id_owner
    JOIN tb_gender g ON c.id_gender = g.id_gender
    WHERE c.validation_status = 'approved'
";

// Apply Filters
$filter_conditions = [];

if ($filter_category) {
    $filter_conditions[] = "c.id_kat = $filter_category";
}
if ($filter_media) {
    $filter_conditions[] = "m.id_media = $filter_media";
}
if ($filter_series) {
    $filter_conditions[] = "c.id_series = $filter_series";
}
if ($filter_gender) {
    $filter_conditions[] = "c.id_gender = $filter_gender";
}
if ($search_query) {
    $filter_conditions[] = "(c.cos_name LIKE '%$search_query%' OR s.series_name LIKE '%$search_query%')";
}

// Combine conditions
if (!empty($filter_conditions)) {
    $base_query .= " AND " . implode(" AND ", $filter_conditions);
}

// Count total results for pagination
$count_query = str_replace(
    "SELECT c.*, s.series_name, st.status as st_status, m.media_name, k.kat_name, g.gender",
    "SELECT COUNT(*) as total",
    $base_query
);
$count_result = mysqli_query($conn, $count_query);
$total_results = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_results / $limit);

// Add pagination to main query
$paginated_query = $base_query . " LIMIT $limit OFFSET $offset";
$costume_result = mysqli_query($conn, $paginated_query);

// Fetch dropdown options for filters
$categories_query = mysqli_query($conn, "SELECT * FROM tb_kategori");
$media_query = mysqli_query($conn, "SELECT * FROM tb_media");
$series_query = mysqli_query($conn, "SELECT * FROM tb_series");
$gender_query = mysqli_query($conn, "SELECT * FROM tb_gender");

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
<html lang="en">

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
</style>

<body>
    <!-- Header Section Begin -->
    <?php include 'function/header.php'; ?>
    <!-- Header End -->

    <div class="container mb-3">

        <!-- Breadcrumb Begin -->
        <div class="breadcrumb-option mb-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                        <a href="./search.html">Product</a>
                    </div>
                </div>

            </div>
        </div>
        <!-- Breadcrumb End -->



        <div class="row g-1">
            <div class="col-12">

                <!-- Grid Items -->
                <div class="row">
                    <!-- Filters -->
                    <div class="col-12 ">
                        <div class="mb-3">
                            <div class="row align-items-center p-1">
                                <!-- Form Search (30%) -->
                                <div class="col-9">
                                    <form method="GET" class="d-flex btn-group">

                                        <button type="submit" class="btn btn-dark"> <i
                                                class="fas fa-search"></i></button>
                                        <input type="text" name="search"
                                            class="form-control rounded-start-0 bg-dark text-light border-0"
                                            placeholder="Search costumes..."
                                            value="<?= htmlspecialchars($search_query ?? '') ?>">
                                    </form>
                                </div>

                                <!-- Toggle Button (70%) -->
                                <div class="col-3 text-end">
                                    <button class="btn btn-secondary w-100 w-md-auto small" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#filterForm" aria-expanded="false"
                                        aria-controls="filterForm">
                                        Filter <span class="small"> <i class="fas fa-filter"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Form Filter dengan Collapse -->
                        <div class="collapse" id="filterForm">
                            <form method="GET" class="p-2 text-light rounded">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <select name="category" class="form-control bg-dark border-0 text-light">
                                            <option value="">All Categories</option>
                                            <?php while ($cat = mysqli_fetch_assoc($categories_query)): ?>
                                                <option value="<?= $cat['id_kat'] ?>" <?= $filter_category == $cat['id_kat'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($cat['kat_name']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>


                                    <div class="col-6 mb-3">
                                        <select name="gender" class="form-control bg-dark border-0 text-light ">
                                            <option value="">All Genders</option>
                                            <?php while ($gender = mysqli_fetch_assoc($gender_query)): ?>
                                                <option value="<?= $gender['id_gender'] ?>"
                                                    <?= $filter_gender == $gender['id_gender'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($gender['gender']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <select name="media" class="form-control bg-dark border-0 text-light ">
                                            <option value="">All Media</option>
                                            <?php while ($media = mysqli_fetch_assoc($media_query)): ?>
                                                <option value="<?= $media['id_media'] ?>"
                                                    <?= $filter_media == $media['id_media'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($media['media_name']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <!-- HTML dengan Dropdown Series -->
                                    <div class="col-12 mb-3 position-relative">
                                        <div class="input-group">
                                            <input type="text" id="seriesSearch"
                                                class="form-control bg-dark border-0 text-light"
                                                placeholder="Cari Series...">
                                            <select name="series" id="seriesSelect"
                                                class="form-control bg-secondary border-0 text-light ">
                                                <option value="">All Series</option>
                                                <?php while ($series = mysqli_fetch_assoc($series_query)): ?>
                                                    <option value="<?= $series['id_series'] ?>"
                                                        <?= $filter_series == $series['id_series'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($series['series_name']) ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-primary w-100 rounded py-2 mb-2">Apply
                                    Filters</button>
                                <a href="?" class="btn btn-secondary w-100 rounded py-2">Reset</a>
                            </form>
                        </div>


                    </div>

                    <!-- Costume Grid -->
                    <div class="col-12 ">
                        <div class="container">
                            <div class="row grid">
                                <?php while ($isi = mysqli_fetch_array($costume_result)): ?>
                                    <?php
                                    // Deklarasi variabel
                                    extract($isi);
                                    $gender_class = $id_gender == 999 ? "1 2 999" : "";
                                    $badge_class = $st_status != "Available" ? "bg-danger" : "bg-success";
                                    $gender_icon = $id_gender == 1 ? "fa-mars" : ($id_gender == 2 ? "fa-venus" : "fa-genderless");
                                    $gender_color = $id_gender == 1 ? "cyan" : ($id_gender == 2 ? "pink" : "purple");
                                    ?>
                                    <div class="col-6 col-md-6 col-lg-3 p-1 grid-item">
                                        <div class="product__item h-100 bg-dark rounded w-100">
                                            <div class="product-container w-100 mb-0">

                                                <a href="costume-detail.php?id=<?= $id_cos ?>">
                                                    <img class="rounded w-100" src="img/costume/<?= $foto1 ?>"
                                                        alt="<?= htmlspecialchars($cos_name) ?>">
                                                </a>
                                                <div class="produc_icon d-flex justify-content-between p-2 small">
                                                    <div class="ep badge <?= $badge_class ?> text-light">
                                                        <div class="text"><?= $st_status ?></div>
                                                    </div>
                                                    <div class="view badge bg-dark">
                                                        <i class="fa fa-eye"></i> <?= $views ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product__item__text p-2">

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
                            </div>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Costume pagination">
                            <ul class="pagination justify-content-center">
                                <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                                    <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                                        <a class="page-link"
                                            href="?page=<?= $p ?>&category=<?= $filter_category ?>&media=<?= $filter_media ?>&series=<?= $filter_series ?>&gender=<?= $filter_gender ?>&search=<?= urlencode($search_query ?? '') ?>">
                                            <?= $p ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- Grid Items -->

            </div>
            <div class="col-12">

                <div class="row mb-3">
                    <div class="col-md-6 mb-4">
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
                    <div class="col-md-6">
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

    <?php include 'function/footer.html'; ?>




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
                        // Always keep "All Series" option visible
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
            max-width: 60%;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        #seriesSelect {
            max-width: 40%;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
    </style>

</body>

</html>