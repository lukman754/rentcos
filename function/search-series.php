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
                    $s_image = $isi['s_image'];
                    $media = $isi['media_name'];
                    $id_media = $isi['id_media'];
                  ?>
                  <div class="w-100 mb-2 rounded isotope-item <?php echo $id_media; ?>">
                     <h5 class="bg-dark p-2 rounded border-0 text-white small">
                        <a href="#"><?php echo $series; ?></a>
                    </h5>

                  </div>

                  <?php } ?>