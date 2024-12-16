<?php
include 'db/koneksi.php';
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="UTF-8" />
  <meta name="description" content="Anime Template" />
  <meta name="keywords" content="Anime, unica, creative, html" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Rentcos</title>


  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <script src="https://kit.fontawesome.com/8c8ccf764d.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


  <!--===============================================================================================-->


  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet" />


  <!-- Css Styles -->
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="css/elegant-icons.css" type="text/css" />
  <link rel="stylesheet" href="css/plyr.css" type="text/css" />
  <link rel="stylesheet" href="css/nice-select.css" type="text/css" />
  <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css" />
  <link rel="stylesheet" href="css/slicknav.min.css" type="text/css" />
  <link rel="stylesheet" href="css/style.css" type="text/css" />
</head>

<style>
  a {
    text-decoration: none;
  }
</style>

<body>
  <!-- Page Preloder -->
  <div id="preloder">
    <div class="loader"></div>
  </div>

  <!-- Header Section Begin -->
  <?php include 'function/header.php'; ?>
  <!-- Header End -->

  <!-- Hero Section Begin -->
  <section class="hero">
    <div class="container">
      <div class="hero__slider owl-carousel">
        <?php include 'function/hero-series.php'; ?>
      </div>
    </div>
  </section>
  <!-- Hero Section End -->


  <!-- Product Section Begin -->
  <section id="new-product" class="product spad">
    <div class="container mt-4">
      <div class="row">
        <div class="col-lg-8">
          <div class="trending__product">
            <div class="row">
              <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="section-title">
                  <h4>New Costume</h4>

                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="btn__all">
                  <a href="search.php" class="primary-btn">View All <span class="arrow_right"></span></a>
                </div>
              </div>
            </div>
            <div id="product-list" class="row g-2">
              <!--PRODUCT-->
              <?php include 'function/product.php'; ?>
              <!--PRODUCT-->
            </div>
            <!-- Pagination -->
            <?php include 'function/pagination.php' ?>
            <!-- Pagination -->
          </div>
        </div>
        <div class="col-12 col-lg-4">
          <div class="product__sidebar">
            <div class="product__sidebar__view">
              <div class="section-title">
                <h5>Series</h5>
              </div>
              <?php include 'function/filter-media.php'; ?>
              <div class="filter__gallery overflow-auto isotope-grid" style="max-height: 750px;">
                <?php include 'function/series.php'; ?>
              </div>

            </div>
            <div class="product__sidebar__comment">
              <?php include 'function/owner.php'; ?>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
  <!-- Product Section End -->

  <?php include 'function/footer.html'; ?>

  <!-- Js Plugins -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/player.js"></script>
  <script src="js/jquery.nice-select.min.js"></script>
  <script src="js/mixitup.min.js"></script>
  <script src="js/jquery.slicknav.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/main.js"></script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://unpkg.com/isotope-layout@3.0.6/dist/isotope.pkgd.min.js"></script>
  <script>
    $(document).ready(function () {
      // Inisialisasi Isotope
      var $grid = $('.isotope-grid').isotope({
        itemSelector: '.isotope-item',
        layoutMode: 'fitRows'
      });

      // Tombol kategori untuk filter
      $('.filter__controls').on('click', 'li', function () {
        var filterValue = $(this).attr('data-filter');
        $grid.isotope({
          filter: filterValue
        });

        // Ubah kelas aktif
        $('.filter__controls li').removeClass('active');
        $(this).addClass('active');
      });
    });
  </script>


</body>

</html>