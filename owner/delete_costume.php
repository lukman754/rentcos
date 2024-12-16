<?php
session_start();
include '../db/koneksi.php';

// Redirect if not logged in
if (!isset($_SESSION['owner_logged_in']) && !isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

// Check if costume ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$costume_id = mysqli_real_escape_string($conn, $_GET['id']);

// If owner is logged in, verify costume ownership
if (isset($_SESSION['owner_logged_in'])) {
    $owner_id = $_SESSION['owner_id'];
    $ownership_check_query = "SELECT id_owner FROM tb_costume WHERE id_cos = '$costume_id'";
    $ownership_result = mysqli_query($conn, $ownership_check_query);
    $ownership_row = mysqli_fetch_assoc($ownership_result);

    // If the costume does not belong to the logged-in owner, deny deletion
    if ($ownership_row['id_owner'] != $owner_id) {
        // Optional: Add error message to session
        $_SESSION['error_message'] = "You are not authorized to delete this costume.";
        header("Location: dashboard.php");
        exit();
    }
}

// Delete associated images first
$images_query = "SELECT foto1, foto2, foto3 FROM tb_costume WHERE id_cos = '$costume_id'";
$images_result = mysqli_query($conn, $images_query);
$images_row = mysqli_fetch_assoc($images_result);

$upload_dir = '../img/costume/';
$images_to_delete = array_filter([$images_row['foto1'], $images_row['foto2'], $images_row['foto3']]);

foreach ($images_to_delete as $image) {
    $image_path = $upload_dir . $image;
    if (file_exists($image_path)) {
        unlink($image_path);
    }
}

// Delete costume record
$delete_query = "DELETE FROM tb_costume WHERE id_cos = '$costume_id'";
mysqli_query($conn, $delete_query);

// Optional: Add success message
$_SESSION['success_message'] = "Costume successfully deleted.";

header("Location: dashboard.php");
exit();
?>