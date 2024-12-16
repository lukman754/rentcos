<nav class="topnav navbar navbar-light">
    <ul class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <img src="../img/logo.png" style="width: 100px" alt="">
    </ul>
    <ul class="nav">
        <li class="nav-item">
            <!-- Tombol Dashboard -->
            <?php if (isset($_SESSION['admin_logged_in'])): ?>
                <a class="nav-link text-muted my-2" href="dashboard.php">
                    <i class="fas fa-home"></i>
                </a>
            <?php endif; ?>
        </li>
        <li class="nav-item">
            <!-- Tombol Series -->
            <a class="nav-link text-muted my-2" href="series.php">
                <i class="fas fa-photo-video"></i>
            </a>
        </li>
        <li class="nav-item">
            <!-- Tombol Owner Dashboard -->
            <?php if (isset($_SESSION['owner_logged_in'])): ?>
                <a class="nav-link text-info my-2" href="../owner/dashboard.php">
                    <i class="fas fa-home"></i>
                </a>
            <?php endif; ?>
        </li>
        <?php if (isset($_SESSION['admin_logged_in'])): ?>
            <li class="nav-item nav-notif">
                <!-- Tombol Costumes -->
                <a class="nav-link text-muted my-2" href="costumes.php">
                    <i class="fas fa-tshirt"></i>
                </a>
            </li>
            <li class="nav-item nav-notif">
                <a class="nav-link text-muted my-2" href="owners.php">
                    <i class="fas fa-user-group"></i>
                </a>
            </li>
            <li class="nav-item nav-notif">
                <a class="nav-link text-danger my-2" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        <?php endif; ?>


    </ul>
</nav>