<?php
session_start();
include '../db/koneksi.php';

// Cek apakah admin atau owner sudah login
if (!isset($_SESSION['admin_logged_in']) && !isset($_SESSION['owner_logged_in'])) {
    header("Location: index.php");
    exit();
}

// Form submission handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $id_media = filter_input(INPUT_POST, 'id_media', FILTER_VALIDATE_INT);
    $series_name = mysqli_real_escape_string($conn, $_POST['series_name']);
    $s_image = filter_input(INPUT_POST, 's_image', FILTER_VALIDATE_URL);

    // Additional validation for WallpaperFlare URL
    $wallpaperflare_pattern = '/^https:\/\/c[0-9]+\.wallpaperflare\.com\/wallpaper\/.+/';
    if (
        !$id_media || empty($series_name) || !$s_image ||
        !preg_match($wallpaperflare_pattern, $s_image)
    ) {
        header("Location: series.php?error=1");
        exit();
    }

    // Check if series name already exists
    $check_query = "SELECT COUNT(*) as count FROM tb_series 
                    WHERE series_name = '$series_name' AND id_media = '$id_media'";
    $check_result = mysqli_query($conn, $check_query);
    $check_row = mysqli_fetch_assoc($check_result);

    if ($check_row['count'] > 0) {
        // Series already exists for this media
        header("Location: series.php?duplicate=1&series_name=" . urlencode($series_name));
        exit();
    }

    // Prepare SQL statement
    $query = "INSERT INTO tb_series (id_media, series_name, s_image) VALUES ('$id_media', '$series_name', '$s_image')";

    // Execute query
    if (mysqli_query($conn, $query)) {
        // Redirect to success page
        header("Location: series.php?success=1");
        exit();
    } else {
        // Redirect with error
        header("Location: series.php?error=1");
        exit();
    }
} else {
    // If not a POST request, redirect
    header("Location: series.php");
    exit();
}