<?php
// Pastikan Anda sudah terkoneksi dengan database
include('../db/koneksi.php');

// Ambil data dari form
if (isset($_POST['id_status'], $_POST['id_cos'])) {
    $id_status = mysqli_real_escape_string($conn, $_POST['id_status']);
    $id_cos = mysqli_real_escape_string($conn, $_POST['id_cos']);

    // Periksa apakah status yang dipilih ada dalam tabel tb_status
    $status_query = "SELECT * FROM tb_status WHERE status = '$id_status'";
    $status_result = mysqli_query($conn, $status_query);

    if (mysqli_num_rows($status_result) > 0) {
        // Dapatkan ID status
        $status_data = mysqli_fetch_assoc($status_result);
        $id_status = $status_data['id_status'];

        // Update status kostum
        $update_query = "UPDATE tb_costume SET id_status = '$id_status' WHERE id_cos = '$id_cos'";
        if (mysqli_query($conn, $update_query)) {
            // Redirect ke halaman edit costume dengan status berhasil diperbarui
            header("Location: dashboard.php?#daftarKostum");
            exit;
        } else {
            echo "Gagal memperbarui status.";
        }
    } else {
        echo "Status tidak ditemukan.";
    }
} else {
    echo "Data tidak lengkap.";
}
?>