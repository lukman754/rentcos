<?php
$series = "SELECT COUNT(c.id_cos) AS jumlah_costume, 
                                        s.*, 
                                        m.* 
                                FROM tb_costume c 
                                INNER JOIN tb_series s ON c.id_series = s.id_series 
                                INNER JOIN tb_media m ON s.id_media = m.id_media 
                                GROUP BY s.series_name, m.id_media  
                                ORDER BY jumlah_costume DESC"; // Batasi jumlah hasil menjadi 10

$tampil = mysqli_query($conn, $series);
while ($isi = mysqli_fetch_array($tampil)) {
  $jumlah = $isi['jumlah_costume'];
  $series = $isi['series_name'];
  $s_image = $isi['s_image'];
  $media = $isi['media_name'];
  $id_media = $isi['id_media'];
  $id_series = $isi['id_series'];
  ?>
  <a href="search.php?series=<?php echo $id_series; ?>" class="text-dark">
    <div class="card w-100 p-2 mb-2 rounded isotope-item <?php echo $id_media; ?>"
      style="background-image: url('<?php echo $s_image; ?>'); background-size: cover; background-position: center; height: 120px; position: relative;">
      <div class="top p-2 d-flex justify-content-between">
        <div class="badge bg-white p-2 text-dark rounded-pill"><?php echo $jumlah; ?>&nbsp;&nbsp;<i
            class="fas fa-tshirt"></i></div>
        <div class="view badge bg-white text-dark rounded-pill p-2"><?php echo $media; ?></div>
      </div>
      <h5 class="title p-1 m-1 rounded-pill px-2 text-white bg-dark"
        style="position: absolute; bottom: 10px; left: 10px; z-index: 2; margin: 0; font-weight: bold;">
        <?php echo $series; ?>
      </h5>
    </div>
  </a>
<?php } ?>