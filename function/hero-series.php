<?php
$series = "SELECT COUNT(c.id_cos) AS jumlah_costume, 
                                        s.*, 
                                        m.* 
                                FROM tb_costume c 
                                INNER JOIN tb_series s ON c.id_series = s.id_series 
                                INNER JOIN tb_media m ON s.id_media = m.id_media 
                                GROUP BY s.series_name, m.id_media 
                                ORDER BY jumlah_costume DESC 
                                ";


$tampil = mysqli_query($conn, $series);
while ($isi = mysqli_fetch_array($tampil)) {
    $jumlah = $isi['jumlah_costume'];
    $series = $isi['series_name'];
    $id_series = $isi['id_series'];
    $s_image = $isi['s_image'];
    $media = $isi['media_name'];
    $id_media = $isi['id_media'];
    ?>
    <div class="hero__items set-bg" data-setbg="<?php echo $s_image ?>">
        <div class="row">
            <div class="col-lg-6">
                <div class="hero__text">
                    <div class="label"><?php echo $media ?></div>
                    <h2><?php echo $series ?></h2>
                    <p><?php echo $jumlah ?> Costumes</p>
                    <a href="search.php?series=<?php echo $id_series; ?>"><span>Mulai</span> <i
                            class="fa fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

<?php } ?>