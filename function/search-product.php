<?php
// Tentukan jumlah produk yang ditampilkan per halaman
$productsPerPage = 12;

// Tentukan halaman saat ini dari parameter URL, jika tidak ada, set default halaman pertama (1)
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// Hitung offset berdasarkan halaman saat ini
$offset = ($page - 1) * $productsPerPage;

// Query untuk menampilkan data produk
$tampilkan = "SELECT c.*, o.*, s.*, st.* 
              FROM tb_costume c 
              INNER JOIN tb_owner o ON c.id_owner = o.id_owner 
              INNER JOIN tb_series s ON c.id_series = s.id_series 
              INNER JOIN tb_status st ON c.id_status = st.id_status
              LIMIT $productsPerPage OFFSET $offset";
$tampilkan_isi = mysqli_query($conn, $tampilkan);

// Menampilkan data produk
while ($isi = mysqli_fetch_array($tampilkan_isi)) {
  $id_cos = $isi['id_cos'];
  $foto1 = $isi['foto1'];
  $cos_name = $isi['cos_name'];
  $size = $isi['size'];
  $status = $isi['status'];
  $series = $isi['series_name'];
  $price = number_format($isi['price'], 0, ',', '.');
  ?>
  <div class="col-12">
    <div class="product__item w-100">
      <div class="product-container w-100 mb-0">
        <a href="costume-detail.php?id=<?php echo $id_cos; ?>">
          <img class="rounded product-image" src="img/images/<?php echo $foto1; ?>" alt="Product Image">
        </a>
        <div class="product_icon d-flex justify-content-between p-2 small">
          <!-- Menampilkan status produk -->
          <div class="ep badge <?php echo $status == 'Available' ? 'bg-success' : 'bg-danger'; ?> text-light">
            <div class="text"><?php echo $status; ?></div>
          </div>
          <div class="view badge badge-dark">
            <i class="fa fa-eye"></i> 9141
          </div>
        </div>
      </div>

      <div class="product__item__text">
        <ul>
          <li>Size : <?php echo $size; ?></li>
        </ul>
        <h5><a href="costume-detail.php?id=<?php echo $id_cos; ?>"><?php echo $cos_name; ?></a></h5>
        <div class="badge badge-dark rounded-pill px-2"><?php echo $series; ?></div>
      </div>
    </div>
  </div>
<?php } ?>