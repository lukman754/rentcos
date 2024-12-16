<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rentcos</title>

    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/8c8ccf764d.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--===============================================================================================-->


    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/plyr.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<style>
    a {
        text-decoration: none;
    }

    .carousel-indicators li {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        margin: 0 5px;
        color: rgba(0, 0, 0, 0);

    }

    .carousel-indicators li.active {
        background-color: white;
    }
</style>

<body>
    <?php

    include "db/koneksi.php";

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']); // Pastikan nilai id aman
    
        // Cek apakah cookie untuk id ini sudah ada
        if (!isset($_COOKIE["viewed_costume_$id"])) {
            // Tambahkan kunjungan ke database
            $update_query = "UPDATE tb_costume SET views = views + 1 WHERE id_cos = $id";
            mysqli_query($conn, $update_query);

            // Set cookie untuk id ini dengan durasi 1 hari (86400 detik)
            setcookie("viewed_costume_$id", "true", time() + 86400, "/");
        }
    }



    $tampilkan = "SELECT c.*, o.*, s.*, st.*, g.*, k.*, m.* FROM tb_costume c 
                INNER JOIN tb_owner o ON c.id_owner = o.id_owner 
                INNER JOIN tb_series s ON c.id_series = s.id_series 
                INNER JOIN tb_status st ON c.id_status = st.id_status
                INNER JOIN tb_gender g ON c.id_gender = g.id_gender
                INNER JOIN tb_media m ON s.id_media = m.id_media
                INNER JOIN tb_kategori k ON c.id_kat = k.id_kat WHERE id_cos = '$id'";
    $tampilkan_isi = mysqli_query($conn, $tampilkan);
    $isi = mysqli_fetch_assoc($tampilkan_isi);
    $id_cos = $isi['id_cos'];
    $id_owner = $isi['id_owner'];
    $id_kat = $isi['id_kat'];
    $id_series = $isi['id_series'];
    $id_gender = $isi['id_gender'];
    $id_status = $isi['id_status'];
    $id_media = $isi['id_media'];
    $foto1 = $isi['foto1'];
    $foto2 = $isi['foto2'];
    $foto3 = $isi['foto3'];
    $cos_name = $isi['cos_name'];
    $desc = $isi['desc'];
    $c_desc = $isi['c_desc'];
    $brand = $isi['brand'];
    $size = $isi['size'];
    $price = $isi['price'];
    $link = $isi['link'];
    $time = $isi['time'];
    $created_at = $isi['created_at'];
    $updated_at = $isi['updated_at'];


    $foto_owner = $isi['foto'];
    $owner_name = $isi['owner_name'];
    $ig = $isi['ig'];
    $address = $isi['address'];
    $gender = $isi['gender'];
    $series = $isi['series_name'];
    $status = $isi['status'];
    $kategori = $isi['kat_name'];
    $media_name = $isi['media_name'];

    $format = number_format($price, 0, ',', '.');

    error_reporting(E_ALL && ~E_NOTICE);

    $tampilkan_kostum_series = "SELECT c.*, o.*, s.*, st.*, g.*, k.*, m.* FROM tb_costume c 
                                INNER JOIN tb_owner o ON c.id_owner = o.id_owner 
                                INNER JOIN tb_series s ON c.id_series = s.id_series 
                                INNER JOIN tb_status st ON c.id_status = st.id_status
                                INNER JOIN tb_gender g ON c.id_gender = g.id_gender
                                INNER JOIN tb_media m ON s.id_media = m.id_media
                                INNER JOIN tb_kategori k ON c.id_kat = k.id_kat
                             WHERE s.id_media = '$id_media' AND c.id_cos != '$id'"; // Menghindari kostum yang sama
    $tampilkan_kostum = mysqli_query($conn, $tampilkan_kostum_series);



    ?>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <?php include 'function/header.php'; ?>
    <!-- Header End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">

            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                        <a href="search.php">Product</a>
                        <span><?php echo $kategori; ?></span>
                        <span><?php echo $cos_name; ?></span>
                    </div>
                </div>
            </div>
            <div class="section-title">
                <h4>Detail Costume</h4>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->
    <section class="mt-4 spad">
        <div class="container">
            <div class="anime__details__content">
                <div class="owner d-flex mb-3">
                    <div class="img">
                        <div class="image">
                            <img src="img/owner/<?php echo $foto_owner; ?>" class="img rounded-circle"
                                style="width: 60px;" alt="">
                        </div>
                    </div>
                    <div class="item mx-3">
                        <a href="toko-owner.php?id=<?php echo $id_owner ?>">
                            <h5 class="text text-white"><?php echo $owner_name; ?></h5>
                        </a>
                        <a href="https://www.instagram.com/<?php echo $ig ?>" class="text-secondary small"><i
                                class="fab fa-instagram"></i> <?php echo $ig ?></a>
                        <div class="text-secondary small"><i class="fas fa-map-marker-alt"></i> <?php echo $address ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div id="carouselExampleControls" class="carousel slide mb-3" data-ride="carousel">

                            <!-- Add carousel indicators with circular style -->
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleControls" data-slide-to="0"
                                    class="active rounded-circle"></li>
                                <?php if (!empty($foto2)) { ?>
                                    <li data-target="#carouselExampleControls" data-slide-to="1" class="rounded-circle">
                                    </li>
                                <?php } ?>
                                <?php if (!empty($foto3)) { ?>
                                    <li data-target="#carouselExampleControls" data-slide-to="2" class="rounded-circle">
                                    </li>
                                <?php } ?>
                            </ol>

                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100 rounded" src="img/costume/<?php echo $foto1; ?>"
                                        alt="First slide">
                                </div>

                                <?php if (!empty($foto2)) { ?>
                                    <div class="carousel-item">
                                        <img class="d-block w-100 rounded" src="img/costume/<?php echo $foto2; ?>"
                                            alt="Second slide">
                                    </div>
                                <?php } ?>

                                <?php if (!empty($foto3)) { ?>
                                    <div class="carousel-item">
                                        <img class="d-block w-100 rounded" src="img/costume/<?php echo $foto3; ?>"
                                            alt="Third slide">
                                    </div>
                                <?php } ?>
                            </div>

                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="anime__details__text">
                            <div class="anime__details__title">
                                <h3><?php echo $cos_name; ?></h3>
                                <h4 class="text-success"><?php echo 'Rp ' . number_format($price, 0, ',', '.'); ?></h4>
                            </div>
                            <div class="anime__details__rating">

                            </div>
                            <p style="font-size: small; line-height: 1.5;"><?php echo nl2br($c_desc); ?></p>
                            <div class="anime__details__widget">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Duration:</span> <?php echo $time; ?> day</li>
                                            <li><span>Status:</span> <?php if ($status != "Available"): ?>
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
                                            </li>
                                            <li><span>Brand:</span> <?php echo $brand; ?></li>
                                            <li><span>Size:</span> <?php echo $size; ?></li>
                                            <li><span>Gender:</span> <?php echo $gender; ?>
                                                <?php if ($id_gender == 1): ?>
                                                    <i class="fa-solid fa-mars" style="color: cayn;"></i>
                                                <?php elseif ($id_gender == 2): ?>
                                                    <i class="fa-solid fa-venus" style="color: pink;"></i>
                                                <?php else: ?>
                                                    <i class="fa-solid fa-genderless" style="color: purple;"></i>
                                                <?php endif; ?>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Series:</span> <?php echo $series; ?></li>
                                            <li><span>Media:</span> <?php echo $media_name; ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="anime__details__btn d-flex justify-content-between">

                                <a href="<?php echo $link; ?>" class="watch-btn"><span>Lihat di Instagram</span> <i
                                        class="fa fa-angle-right"></i></a>

                                <!-- HTML for Share Button -->
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="btn text-white btn-dark follow-btn"
                                        id="shareButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span><i class="fas fa-share"></i></span>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="shareButton">
                                        <li><a class="dropdown-item" href="#" id="shareWhatsApp"><i
                                                    class="fab fa-whatsapp me-2"></i>WhatsApp</a></li>
                                        <li><a class="dropdown-item" href="#" id="shareFacebook"><i
                                                    class="fab fa-facebook me-2"></i>Facebook</a></li>
                                        <li><a class="dropdown-item" href="#" id="shareTwitter"><i
                                                    class="fab fa-twitter me-2"></i>Twitter</a></li>
                                        <li><a class="dropdown-item" href="#" id="shareTelegram"><i
                                                    class="fab fa-telegram me-2"></i>Telegram</a></li>
                                        <li><a class="dropdown-item" href="#" id="shareInstagram"><i
                                                    class="fab fa-instagram me-2"></i>Instagram</a></li>
                                        <li>
                                            <a class="dropdown-item" href="#" id="copyLinkBtn">
                                                <i class="fas fa-copy me-2"></i>Copy Link
                                            </a>
                                        </li>
                                    </ul>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="anime__details__sidebar">
                        <div class="section-title">
                            <h5>you might like...</h5>
                        </div>
                        <div id="product-list" class="row g-2 isotope-container">
                            <?php include 'function/costume-detail-product.php'; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Anime Section End -->
    <?php include 'function/footer.html'; ?>

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/player.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get current page URL
            const pageUrl = window.location.href;
            const pageTitle = document.title;

            // WhatsApp Share
            document.getElementById('shareWhatsApp').addEventListener('click', function (e) {
                e.preventDefault();
                const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(pageTitle + ' - ' + pageUrl)}`;
                window.open(whatsappUrl, '_blank');
            });

            // Facebook Share
            document.getElementById('shareFacebook').addEventListener('click', function (e) {
                e.preventDefault();
                const fbShareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(pageUrl)}`;
                window.open(fbShareUrl, '_blank');
            });

            // Twitter Share
            document.getElementById('shareTwitter').addEventListener('click', function (e) {
                e.preventDefault();
                const twitterUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(pageTitle)}&url=${encodeURIComponent(pageUrl)}`;
                window.open(twitterUrl, '_blank');
            });

            // Telegram Share
            document.getElementById('shareTelegram').addEventListener('click', function (e) {
                e.preventDefault();
                const telegramUrl = `https://telegram.me/share/url?url=${encodeURIComponent(pageUrl)}&text=${encodeURIComponent(pageTitle)}`;
                window.open(telegramUrl, '_blank');
            });

            // Instagram Share (Note: Instagram doesn't have a direct share API)
            document.getElementById('shareInstagram').addEventListener('click', function (e) {
                e.preventDefault();
                // Use Stories share link (requires manual copy-paste on mobile)
                const instagramUrl = `https://www.instagram.com/create/story?checkin_link=${encodeURIComponent(pageUrl)}`;
                window.open(instagramUrl, '_blank');
            });

            // Copy Link - Improved for better cross-browser and mobile support
            document.getElementById('copyLinkBtn').addEventListener('click', function (e) {
                e.preventDefault();

                // Fallback methods for copying
                if (navigator.clipboard) {
                    // Modern browsers
                    navigator.clipboard.writeText(pageUrl).then(function () {
                        alert('Link copied to clipboard!');
                    }, function (err) {
                        fallbackCopyTextToClipboard(pageUrl);
                    });
                } else {
                    // Fallback for older browsers and some mobile devices
                    fallbackCopyTextToClipboard(pageUrl);
                }
            });

            // Fallback copy method
            function fallbackCopyTextToClipboard(text) {
                const textArea = document.createElement("textarea");
                textArea.value = text;

                // Avoid scrolling to bottom
                textArea.style.top = "0";
                textArea.style.left = "0";
                textArea.style.position = "fixed";

                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();

                try {
                    const successful = document.execCommand('copy');
                    const msg = successful ? 'successful' : 'unsuccessful';
                    alert('Link copied to clipboard!');
                } catch (err) {
                    alert('Unable to copy link');
                }

                document.body.removeChild(textArea);
            }
        });
    </script>


</body>

</html>