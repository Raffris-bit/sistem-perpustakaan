<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Info Buku - M. Rafi Risqiyanto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="alert alert-dark text-center shadow-sm">
            <strong>M. Rafi Risqiyanto | 60324001</strong> - Tugas 1 (Pertemuan 2)
        </div>

        <h1 class="mb-4">Katalog Buku Lengkap</h1>
        
        <?php
        // Buku 1
        $judul1 = "Pemrograman PHP Modern";
        $kategori1 = "Programming";
        $bahasa1 = "Indonesia";
        $halaman1 = 450;
        $berat1 = 500;
        $pengarang1 = "Budi Raharjo";
        $penerbit1 = "Informatika";
        $tahun_terbit1 = 2023;
        $harga1 = 85000;
        $stok1 = 15;
        $isbn1 = "978-602-1234-56-7";
        
        // Buku 2
        $judul2 = "MySQL Database Administration";
        $kategori2 = "Database";
        $bahasa2 = "Inggris";
        $halaman2 = 320;
        $berat2 = 400;
        $pengarang2 = "Andi Nugroho";
        $penerbit2 = "Graha Ilmu";
        $tahun_terbit2 = 2022;
        $harga2 = 95000;
        $stok2 = 8;
        $isbn2 = "978-602-1234-56-8";

        // Buku 3
        $judul3 = "Web Design Principles";
        $kategori3 = "Web Design";
        $bahasa3 = "Indonesia";
        $halaman3 = 280;
        $berat3 = 350;
        $pengarang3 = "Dedi Santoso";
        $penerbit3 = "Andi Offset";
        $tahun_terbit3 = 2023;
        $harga3 = 75000;
        $stok3 = 20;
        $isbn3 = "978-602-1234-56-9";

        // Buku 4
        $judul4 = "Data Science with Python";
        $kategori4 = "Programming";
        $bahasa4 = "Inggris";
        $halaman4 = 550;
        $berat4 = 650;
        $pengarang4 = "Siti Aminah";
        $penerbit4 = "Erlangga";
        $tahun_terbit4 = 2024;
        $harga4 = 125000;
        $stok4 = 5;
        $isbn4 = "978-602-1234-57-0";
        ?>

        <div class="row">
            <!-- Tampilan Buku 1 -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><?php echo $judul1; ?></h5>
                    </div>
                    <div class="card-body">
                        <p><span class="badge bg-primary"><?php echo $kategori1; ?></span></p>
                        <table class="table table-sm table-borderless">
                            <tr><th width="150">Pengarang</th><td>: <?php echo $pengarang1; ?></td></tr>
                            <tr><th>Penerbit</th><td>: <?php echo $penerbit1; ?> (<?php echo $tahun_terbit1; ?>)</td></tr>
                            <tr><th>ISBN</th><td>: <?php echo $isbn1; ?></td></tr>
                            <tr><th>Bahasa</th><td>: <?php echo $bahasa1; ?></td></tr>
                            <tr><th>Spesifikasi</th><td>: <?php echo $halaman1; ?> Hal | <?php echo $berat1; ?> gr</td></tr>
                            <tr><th>Harga</th><td>: Rp <?php echo number_format($harga1, 0, ',', '.'); ?></td></tr>
                            <tr><th>Stok</th><td>: <?php echo $stok1; ?> buku</td></tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tampilan Buku 2 -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><?php echo $judul2; ?></h5>
                    </div>
                    <div class="card-body">
                        <p><span class="badge bg-success"><?php echo $kategori2; ?></span></p>
                        <table class="table table-sm table-borderless">
                            <tr><th width="150">Pengarang</th><td>: <?php echo $pengarang2; ?></td></tr>
                            <tr><th>Penerbit</th><td>: <?php echo $penerbit2; ?> (<?php echo $tahun_terbit2; ?>)</td></tr>
                            <tr><th>ISBN</th><td>: <?php echo $isbn2; ?></td></tr>
                            <tr><th>Bahasa</th><td>: <?php echo $bahasa2; ?></td></tr>
                            <tr><th>Spesifikasi</th><td>: <?php echo $halaman2; ?> Hal | <?php echo $berat2; ?> gr</td></tr>
                            <tr><th>Harga</th><td>: Rp <?php echo number_format($harga2, 0, ',', '.'); ?></td></tr>
                            <tr><th>Stok</th><td>: <?php echo $stok2; ?> buku</td></tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tampilan Buku 3 -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><?php echo $judul3; ?></h5>
                    </div>
                    <div class="card-body">
                        <p><span class="badge bg-info text-dark"><?php echo $kategori3; ?></span></p>
                        <table class="table table-sm table-borderless">
                            <tr><th width="150">Pengarang</th><td>: <?php echo $pengarang3; ?></td></tr>
                            <tr><th>Penerbit</th><td>: <?php echo $penerbit3; ?> (<?php echo $tahun_terbit3; ?>)</td></tr>
                            <tr><th>ISBN</th><td>: <?php echo $isbn3; ?></td></tr>
                            <tr><th>Bahasa</th><td>: <?php echo $bahasa3; ?></td></tr>
                            <tr><th>Spesifikasi</th><td>: <?php echo $halaman3; ?> Hal | <?php echo $berat3; ?> gr</td></tr>
                            <tr><th>Harga</th><td>: Rp <?php echo number_format($harga3, 0, ',', '.'); ?></td></tr>
                            <tr><th>Stok</th><td>: <?php echo $stok3; ?> buku</td></tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tampilan Buku 4 -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><?php echo $judul4; ?></h5>
                    </div>
                    <div class="card-body">
                        <p><span class="badge bg-primary"><?php echo $kategori4; ?></span></p>
                        <table class="table table-sm table-borderless">
                            <tr><th width="150">Pengarang</th><td>: <?php echo $pengarang4; ?></td></tr>
                            <tr><th>Penerbit</th><td>: <?php echo $penerbit4; ?> (<?php echo $tahun_terbit4; ?>)</td></tr>
                            <tr><th>ISBN</th><td>: <?php echo $isbn4; ?></td></tr>
                            <tr><th>Bahasa</th><td>: <?php echo $bahasa4; ?></td></tr>
                            <tr><th>Spesifikasi</th><td>: <?php echo $halaman4; ?> Hal | <?php echo $berat4; ?> gr</td></tr>
                            <tr><th>Harga</th><td>: Rp <?php echo number_format($harga4, 0, ',', '.'); ?></td></tr>
                            <tr><th>Stok</th><td>: <?php echo $stok4; ?> buku</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>