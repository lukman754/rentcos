<?php
// Include database connection
include('../db/koneksi.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_series = $_POST['id_series'];
    $id_media = $_POST['id_media'];
    $series_name = $_POST['series_name'];
    $s_image = $_POST['s_image'];

    // Prepare an update query
    $query = "UPDATE tb_series SET id_media = ?, series_name = ?, s_image = ? WHERE id_series = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "issi", $id_media, $series_name, $s_image, $id_series);

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to a success page or back to the series list
            header("Location: series.php?message=update_success");
            exit();
        } else {
            // Handle query failure
            echo "Error updating series: " . mysqli_error($conn);
        }
    } else {
        // Handle statement preparation error
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // If not POST, redirect to the add series page
    header("Location: series.php");
    exit();
}
?>