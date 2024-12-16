<?php
session_start();
include '../db/koneksi.php';

// Cek apakah admin atau owner sudah login
if (!isset($_SESSION['admin_logged_in']) && !isset($_SESSION['owner_logged_in'])) {
    header("Location: index.php");
    exit();
}


// Fetch media options
$media_query = "SELECT id_media, media_name FROM tb_media ORDER BY media_name";
$media_result = mysqli_query($conn, $media_query);

// Handle edit action (hanya admin yang bisa)
if (isset($_GET['edit'])) {
    if (isset($_SESSION['admin_logged_in'])) {
        $id_series = $_GET['edit'];
        $edit_query = "SELECT * FROM tb_series WHERE id_series = '$id_series'";
        $edit_result = mysqli_query($conn, $edit_query);
        $edit_data = mysqli_fetch_assoc($edit_result);
    } else {
        header("Location: no_access.php"); // Redirect jika bukan admin
        exit();
    }
}

// Handle delete action (hanya admin yang bisa)
if (isset($_GET['delete'])) {
    if (isset($_SESSION['admin_logged_in'])) {
        $id_series = $_GET['delete'];
        $delete_query = "DELETE FROM tb_series WHERE id_series = '$id_series'";
        mysqli_query($conn, $delete_query);
        header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page after delete
        exit();
    } else {
        header("Location: no_access.php"); // Redirect jika bukan admin
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Series - Rentcos</title>

    <script src="https://kit.fontawesome.com/8c8ccf764d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles/css/simplebar.css">
    <link rel="stylesheet" href="../styles/css/feather.css">
    <link rel="stylesheet" href="../styles/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../styles/css/daterangepicker.css">
    <link rel="stylesheet" href="../styles/css/app-light.css" id="lightTheme" disabled>
    <link rel="stylesheet" href="../styles/css/app-dark.css" id="darkTheme">
</head>

<body>
    <div class="container">
        <?php include 'nav.php'; ?>
        <div class="row">
            <div class="col-12 col-md-8">
                <!-- Filter Form -->
                <form method="GET" class="mb-3">
                    <div class="row">
                        <!-- Search Input -->
                        <div class="col-md-4 mb-2">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search series or media..."
                                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        </div>

                        <!-- Media Filter -->
                        <div class="col-md-3 mb-2">
                            <select name="media" class="form-control">
                                <option value="">All Media</option>
                                <?php
                                // Fetch distinct media types
                                $media_query = "SELECT DISTINCT id_media, media_name FROM tb_media ORDER BY media_name";
                                $tampil_media = mysqli_query($conn, $media_query);
                                while ($media_row = mysqli_fetch_assoc($tampil_media)) {
                                    $selected = (isset($_GET['media']) && $_GET['media'] == $media_row['id_media']) ? 'selected' : '';
                                    echo "<option value='{$media_row['id_media']}' $selected>{$media_row['media_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Costume Count Filter -->
                        <div class="col-md-3 mb-2">
                            <select name="costume_count" class="form-control">
                                <option value="">All Costume Counts</option>
                                <option value="0-5" <?php echo (isset($_GET['costume_count']) && $_GET['costume_count'] == '0-5') ? 'selected' : ''; ?>>0-5 Costumes</option>
                                <option value="6-10" <?php echo (isset($_GET['costume_count']) && $_GET['costume_count'] == '6-10') ? 'selected' : ''; ?>>6-10 Costumes</option>
                                <option value="11-20" <?php echo (isset($_GET['costume_count']) && $_GET['costume_count'] == '11-20') ? 'selected' : ''; ?>>11-20 Costumes</option>
                                <option value="21+" <?php echo (isset($_GET['costume_count']) && $_GET['costume_count'] == '21+') ? 'selected' : ''; ?>>21+ Costumes</option>
                            </select>
                        </div>

                        <!-- Submit and Clear Buttons -->
                        <div class="col-md-2 mb-2">
                            <div class="btn-group">
                                <button class="btn btn-primary" type="submit">Filter</button>
                                <?php if (isset($_GET['search']) || isset($_GET['media']) || isset($_GET['costume_count'])): ?>
                                    <a href="?" class="btn btn-secondary">Clear</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="container">
                    <div class="row">
                        <?php
                        // Pagination setup
                        $resultsPerPage = 6; // Number of series per page
                        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                        $offset = ($page - 1) * $resultsPerPage;

                        // Build filter conditions
                        $conditions = [];
                        $having_conditions = [];

                        // Search condition
                        if (isset($_GET['search']) && !empty($_GET['search'])) {
                            $search = mysqli_real_escape_string($conn, $_GET['search']);
                            $conditions[] = "(s.series_name LIKE '%$search%' OR m.media_name LIKE '%$search%')";
                        }

                        // Media filter
                        if (isset($_GET['media']) && !empty($_GET['media'])) {
                            $media = mysqli_real_escape_string($conn, $_GET['media']);
                            $conditions[] = "s.id_media = '$media'";
                        }

                        // Costume count filter
                        if (isset($_GET['costume_count']) && !empty($_GET['costume_count'])) {
                            $costume_count = $_GET['costume_count'];
                            switch ($costume_count) {
                                case '0-5':
                                    $having_conditions[] = "jumlah_costume BETWEEN 0 AND 5";
                                    break;
                                case '6-10':
                                    $having_conditions[] = "jumlah_costume BETWEEN 6 AND 10";
                                    break;
                                case '11-20':
                                    $having_conditions[] = "jumlah_costume BETWEEN 11 AND 20";
                                    break;
                                case '21+':
                                    $having_conditions[] = "jumlah_costume >= 21";
                                    break;
                            }
                        }

                        // Construct WHERE and HAVING clauses
                        $where_clause = $conditions ? "WHERE " . implode(" AND ", $conditions) : "";
                        $having_clause = $having_conditions ? "HAVING " . implode(" AND ", $having_conditions) : "";

                        // Count total results for pagination
                        $count_query = "SELECT COUNT(DISTINCT s.id_series) AS total 
                        FROM tb_series s
                        LEFT JOIN tb_costume c ON c.id_series = s.id_series
                        LEFT JOIN tb_media m ON s.id_media = m.id_media
                        $where_clause";
                        $count_result = mysqli_query($conn, $count_query);
                        $total_rows = mysqli_fetch_assoc($count_result)['total'];
                        $total_pages = ceil($total_rows / $resultsPerPage);

                        // Modified query with pagination, search, and filters
                        $series_query = "SELECT COUNT(c.id_cos) AS jumlah_costume, s.*, m.* 
                         FROM tb_series s
                         LEFT JOIN tb_costume c ON c.id_series = s.id_series
                         LEFT JOIN tb_media m ON s.id_media = m.id_media
                         $where_clause
                         GROUP BY s.series_name, m.id_media
                         $having_clause
                         ORDER BY jumlah_costume DESC
                         LIMIT $offset, $resultsPerPage";
                        $series_result = mysqli_query($conn, $series_query);

                        if (mysqli_num_rows($series_result) > 0) {
                            while ($series_data = mysqli_fetch_array($series_result)) {
                                $jumlah = $series_data['jumlah_costume'];
                                $series = $series_data['series_name'];
                                $s_image = $series_data['s_image'];
                                $media = $series_data['media_name'];
                                $id_media = $series_data['id_media'];
                                ?>
                                <div class="col-12 col-md-6 p-1">
                                    <div class="card w-100 p-2 mb-2 rounded isotope-item <?php echo $id_media; ?>"
                                        style="background-image: url('<?php echo $s_image; ?>'); background-size: cover; background-position: center; height: 120px; position: relative;">
                                        <div class="top p-2 d-flex justify-content-between">
                                            <div class="badge bg-white p-2 rounded-pill"><?php echo $jumlah; ?>&nbsp;&nbsp;<i
                                                    class="fas fa-tshirt"></i></div>
                                            <div class="view badge bg-white rounded-pill p-2"><?php echo $media; ?></div>
                                        </div>
                                        <h5 class="title p-1 m-1 rounded-pill px-2 text-white bg-dark"
                                            style="position: absolute; bottom: 10px; left: 10px; z-index: 2; margin: 0; font-weight: bold;">
                                            <a class="text-white"><?php echo $series; ?></a>
                                        </h5>
                                        <div style="position: absolute; bottom: 10px; right: 10px; z-index: 2;">
                                            <?php if (isset($_SESSION['admin_logged_in'])): ?>
                                                <a href="?edit=<?php echo $series_data['id_series']; ?>"
                                                    class="btn btn-warning btn-sm" style="margin-right: 5px;">Edit</a>
                                                <a href="?delete=<?php echo $series_data['id_series']; ?>"
                                                    class="btn btn-danger btn-sm">Delete</a>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div class="col-12"><p class="alert alert-info">No results found.</p></div>';
                        }
                        ?>
                    </div>

                </div>
                <!-- Pagination Navigation -->
                <nav aria-label="Page navigation" class="mt-3">
                    <ul class="pagination justify-content-center">
                        <?php
                        // Previous page link
                        if ($page > 1) {
                            $prev_params = http_build_query(array_merge($_GET, ['page' => $page - 1]));
                            echo "<li class='page-item'><a class='page-link' href='?$prev_params'>Previous</a></li>";
                        }

                        // Determine the range of page numbers to display
                        $start_page = max(1, $page - 3); // Start from 3 pages before the current page
                        $end_page = min($total_pages, $page + 2); // End at 3 pages after the current page
                        
                        // Always display page 1
                        if ($start_page > 2) {
                            echo "<li class='page-item'><a class='page-link' href='?page=1'>1</a></li>";
                            echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                        }

                        // Page numbers
                        for ($i = $start_page; $i <= $end_page; $i++) {
                            $active = ($i == $page) ? 'active' : '';
                            $page_params = http_build_query(array_merge($_GET, ['page' => $i]));
                            echo "<li class='page-item $active'><a class='page-link' href='?$page_params'>$i</a></li>";
                        }

                        // Always display the last page number
                        if ($end_page < $total_pages) {
                            echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                            echo "<li class='page-item'><a class='page-link' href='?page=$total_pages'>$total_pages</a></li>";
                        }

                        // Next page link
                        if ($page < $total_pages) {
                            $next_params = http_build_query(array_merge($_GET, ['page' => $page + 1]));
                            echo "<li class='page-item'><a class='page-link' href='?$next_params'>Next</a></li>";
                        }
                        ?>
                    </ul>
                </nav>

            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h2><?php echo isset($edit_data) ? 'Edit Series' : 'Add New Series'; ?></h2>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_GET['success'])) {
                            echo '<div class="alert alert-success">Series added successfully!</div>';
                        }
                        if (isset($_GET['error'])) {
                            echo '<div class="alert alert-danger">Error adding series. Please try again.</div>';
                        }
                        if (isset($_GET['duplicate'])) {
                            $duplicate_series = urldecode($_GET['series_name']);
                            echo '<div class="alert alert-warning">Series "' . htmlspecialchars($duplicate_series) . '" already exists for the selected media. Please choose a different name.</div>';
                        }
                        ?>
                        <form action="<?php echo isset($edit_data) ? 'update_series.php' : 'process_series.php'; ?>"
                            method="POST">
                            <div class="form-group mb-3">
                                <label for="id_media" class="form-label">Select Media:</label>
                                <select name="id_media" id="id_media" class="form-control" required>
                                    <option value="">Choose Media</option>
                                    <?php
                                    while ($media = mysqli_fetch_assoc($media_result)) {
                                        echo "<option value='" . htmlspecialchars($media['id_media']) . "'"
                                            . (isset($edit_data) && $edit_data['id_media'] == $media['id_media'] ? ' selected' : '') . ">"
                                            . htmlspecialchars($media['media_name']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="series_name" class="form-label">Series Name:</label>
                                <input type="text" name="series_name" id="series_name" class="form-control"
                                    value="<?php echo isset($edit_data) ? htmlspecialchars($edit_data['series_name']) : ''; ?>"
                                    required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="s_image" class="form-label">Series Image URL (from <a
                                        href="https://wallpaperflare.com">wallpaperflare.com</a>):</label>
                                <input type="url" name="s_image" id="s_image" class="form-control"
                                    value="<?php echo isset($edit_data) ? htmlspecialchars($edit_data['s_image']) : ''; ?>"
                                    pattern="https://c[0-9]+\.wallpaperflare\.com/wallpaper/.*" required
                                    onchange="previewImage()">
                            </div>

                            <div class="form-group mb-3">
                                <img id="imagePreview"
                                    src="<?php echo isset($edit_data) ? htmlspecialchars($edit_data['s_image']) : ''; ?>"
                                    alt="Image Preview" class="img-fluid rounded">
                            </div>

                            <input type="hidden" name="id_series"
                                value="<?php echo isset($edit_data) ? htmlspecialchars($edit_data['id_series']) : ''; ?>">

                            <button type="submit" class="btn btn-primary">
                                <?php echo isset($edit_data) ? 'Update Series' : 'Add Series'; ?>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage() {
            const imageUrl = document.getElementById('s_image').value;
            const previewImg = document.getElementById('imagePreview');

            // Validate WallpaperFlare URL
            if (!imageUrl.includes('c4.wallpaperflare.com')) {
                alert('Image must be from wallpaperflare.com');
                previewImg.src = '';
                return;
            }

            previewImg.src = imageUrl;
        }
    </script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>