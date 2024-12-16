<ul class="filter__controls">
    <li class="active  btn-sm btn btn-success rounded-pill" data-filter="*">All</li>
    <?php 
                        $qry = "SELECT * FROM tb_media";
                        $tampil = mysqli_query($conn, $qry);
                        while ($isi = mysqli_fetch_array($tampil)) {
                            $media = $isi['media_name'];
                            $id_media = $isi['id_media'];
                      ?>
    <li data-filter=".<?php echo $id_media; ?>" class="btn-sm btn btn-dark rounded-pill"><?php echo $media; ?></li>
    <?php }?>
</ul>