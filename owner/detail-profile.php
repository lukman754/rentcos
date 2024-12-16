<?php

// Query database untuk mendapatkan data owner beserta media_list
$query = "SELECT 
              o.*, 
              GROUP_CONCAT(DISTINCT m.media_name SEPARATOR ', ') AS media_list 
          FROM 
              tb_owner o
          LEFT JOIN 
              tb_costume c ON o.id_owner = c.id_owner
          LEFT JOIN 
              tb_series s ON c.id_series = s.id_series
          LEFT JOIN 
              tb_media m ON s.id_media = m.id_media
          WHERE 
              o.id_owner = ?
          GROUP BY 
              o.id_owner";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah data ditemukan
if ($result->num_rows > 0) {
    $owner = $result->fetch_assoc();
} else {
    echo "Data owner tidak ditemukan.";
    exit();
}
?>

<div class="container-fluid rounded bg-white">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row mt-5 align-items-center">
                <div class="col-md-6 col-lg-3 text-center mb-5">
                    <div class="avatar avatar-xl">
                        <img src="../img/owner/<?= htmlspecialchars($owner['foto'] ?? './assets/avatars/default.jpg') ?>"
                            alt="Foto Profil" class="avatar-img rounded-circle" width="150px">
                        <p class="small btn-instagram-gradient  mb-2 mx-2 mt-3 text-muted d-flex align-items-center">
                            <a href="https://instagram.com/<?= htmlspecialchars($owner['ig']) ?>" target="_blank"
                                class="ms-3">
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
                                    class="badge badge-warning"><?= htmlspecialchars($owner['media_list'] ?? 'Tidak ada media') ?></span>
                            </p>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-7">
                            <p class="text-muted"><?= nl2br(htmlspecialchars($owner['desc'])) ?></p>
                        </div>
                        <div class="col">
                            <p class="small mb-2 text-muted">
                                <i class="fa fa-map-marker-alt text-primary me-2"></i>
                                Alamat: <?= htmlspecialchars($owner['address']) ?>
                            </p>
                            <p class="small mb-2 text-muted">
                                <i class="fa fa-phone-alt text-success me-2"></i>
                                Telepon: <?= htmlspecialchars($owner['no_telp']) ?>
                            </p>
                            <p class="small mb-2 text-muted">
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


<style>
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