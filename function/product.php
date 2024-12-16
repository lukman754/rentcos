<?php
// Tentukan jumlah produk yang ditampilkan per halaman
$productsPerPage = 12;

// Tentukan halaman saat ini dari parameter URL, jika tidak ada, set default halaman pertama (1)
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// Hitung offset berdasarkan halaman saat ini
$offset = ($page - 1) * $productsPerPage;

// Modifikasi query untuk menggunakan LIMIT dan OFFSET
$tampilkan = "SELECT c.*, o.*, s.*, st.* 
                              FROM tb_costume c 
                              INNER JOIN tb_owner o ON c.id_owner = o.id_owner 
                              INNER JOIN tb_series s ON c.id_series = s.id_series 
                              INNER JOIN tb_status st ON c.id_status = st.id_status WHERE c.status = 'aktif'
                              LIMIT $productsPerPage OFFSET $offset";
$tampilkan_isi = mysqli_query($conn, $tampilkan);


while ($isi = mysqli_fetch_array($tampilkan_isi)) {
  $id_cos = $isi['id_cos'];
  $id_owner = $isi['id_owner'];
  $id_kat = $isi['id_kat'];
  $id_series = $isi['id_series'];
  $id_gender = $isi['id_gender'];
  $id_status = $isi['id_status'];
  $foto1 = $isi['foto1'];
  $foto2 = $isi['foto2'];
  $foto3 = $isi['foto3'];
  $cos_name = $isi['cos_name'];
  $desc = $isi['desc'];
  $brand = $isi['brand'];
  $size = $isi['size'];
  $price = $isi['price'];
  $time = $isi['time'];
  $created_at = $isi['created_at'];
  $updated_at = $isi['updated_at'];
  $views = $isi['views'];


  $foto_owner = $isi['foto'];
  $owner_name = $isi['owner_name'];
  $address = $isi['address'];
  $series = $isi['series_name'];
  $status = $isi['status'];
  $v_status = $isi['validation_status'];

  $format = number_format($price, 0, ',', '.');

  error_reporting(E_ALL && ~E_NOTICE);



  ?>
  <div class="col-6 col-md-4 ">
    <div class="product__item bg-dark rounded w-100 h-100">
      <div class="product-container w-100 mb-0">
        <a href="costume-detail.php?id=<?php echo $id_cos; ?>"><img class="rounded product-image"
            src="img/costume/<?php echo $foto1; ?>" alt="Product Image"></a>
        <div class="produc_icon d-flex justify-content-between p-2 small">
          <?php if ($status != "Available"): ?>
            <div class="ep badge bg-danger text-light">
              <div class="text">
                <?php echo $status; ?>
              </div>
            </div>
          <?php else: ?>
            <div class="ep badge bg-success text-light">
              <div class="text">
                <?php echo $status; ?>
              </div>
            </div>
          <?php endif; ?>



          <div class="view badge bg-dark">
            <i class="fa fa-eye"></i> <?php echo $views; ?>
          </div>
        </div>

      </div>

      <div class="product__item__text p-2">
        <ul>
          <li>
            <?php if ($id_gender == 1): ?>
              <i class="fa-solid fa-mars" style="color: cayn;"></i>
            <?php elseif ($id_gender == 2): ?>
              <i class="fa-solid fa-venus" style="color: pink;"></i>
            <?php else: ?>
              <i class="fa-solid fa-genderless" style="color: white;"></i>
            <?php endif; ?>
          </li>
          <li>Size : <?php echo $size; ?></li>
          <li><?php echo $brand; ?></li><br>

          <li class="bg-warning text-dark"><?php echo $series; ?></li>
        </ul>
        <h5 class="mb-2">
          <a href="#"><?php echo $cos_name; ?></a>
        </h5>
        <ul class="mb-0 ">
          <li class="text-warning">Rp <?php echo number_format($price, 0, ',', '.'); ?></li>
          <li><?php echo $time; ?> day
          </li>
        </ul>

      </div>
    </div>
  </div>
<?php } ?>