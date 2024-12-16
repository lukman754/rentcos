<div class="section-title">
  <h5>Owner</h5>
</div>
<?php
$owner = "SELECT 
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
                                  tb_kategori k ON c.id_kat = k.id_kat WHERE o.status = 'aktif'
                              GROUP BY 
                                  o.id_owner
                              LIMIT 10;
                              ";

$tampil = mysqli_query($conn, $owner);
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
  <div class="row mb-3">

    <div class="col-4">
      <img src="img/owner/<?php echo $foto ?>" class="img rounded" width="150px" alt="" />
    </div>
    <div class="col-8 pt-2">
      <h5>
        <a class="text-white fw-bold" href="toko-owner.php?id=<?php echo $id_owner ?>"><?php echo $owner_name ?></a>
      </h5>
      <div>
        <div class="text-secondary small"><i class="fab fa-instagram"></i> <?php echo $ig ?></div>
        <div class="text-secondary small"><i class="fas fa-map-marker-alt"></i> <?php echo $address ?></div>
      </div>
      <div class="overflow-auto mt-2">
        <ul class="d-flex flex-nowrap list-unstyled">
          <li class="badge bg-dark rounded-pill text-white" style="margin-right: 5px;"><?php echo $kategori_list; ?>
          </li>
          <li class="badge bg-dark rounded-pill text-white" style="margin-right: 5px;"><?php echo $media_list; ?></li>
          <li class="badge bg-dark rounded-pill text-white" style="margin-right: 5px;"><?php echo $gender_list; ?></li>
          <!-- Anda bisa menambahkan lebih banyak badge di sini jika diperlukan -->
        </ul>
      </div>
    </div>

  </div>
<?php } ?>