<nav aria-label="Page navigation pagination-sm">
                <ul class="pagination pagination-sm">
                    <?php
                    // Hitung total produk
                    $totalProdukQuery = "SELECT COUNT(*) AS total FROM tb_costume";
                    $totalProdukResult = mysqli_query($conn, $totalProdukQuery);
                    $totalProduk = mysqli_fetch_assoc($totalProdukResult)['total'];

                    // Hitung total halaman yang ada
                    $totalPages = ceil($totalProduk / $productsPerPage);

                    // Menampilkan link ke halaman sebelumnya
                    if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>" class="prev">« Prev</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    // Jika total halaman kurang dari atau sama dengan 7, tampilkan semua
                    if ($totalPages <= 7) {
                        for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>#new-product"><?php echo $i; ?></a>
                            </li>
                        <?php endfor;
                    } else {
                        // Tampilkan 1 hingga 2 halaman pertama
                        if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=1#new-product">1</a>
                            </li>
                        <?php endif;

                        // Jika halaman saat ini lebih besar dari 4, tampilkan input manual
                        if ($page > 1): ?>
                            <li class="page-item">
                                <form method="GET" action="">
                                      <input type="number" name="page" class="page-link" placeholder="..." min="1" max="<?php echo $totalPages; ?>" onchange="this.form.submit()" />
                                </form>
                            </li>
                        <?php endif;

                        // Tampilkan halaman 3 sebelum halaman saat ini, halaman saat ini, dan 3 setelahnya
                        for ($i = max(1, $page - 0); $i <= min($page + 2, $totalPages - 1); $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>#new-product"><?php echo $i; ?></a>
                            </li>
                        <?php endfor;


                        // Tampilkan 3 halaman terakhir
                        for ($i = $totalPages - 0; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>#new-product"><?php echo $i; ?></a>
                            </li>
                        <?php endfor;
                    }
                    ?>

                    <!-- Menampilkan link ke halaman berikutnya -->
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>#new-product" class="next">Next »</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>