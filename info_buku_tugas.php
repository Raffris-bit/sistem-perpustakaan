<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas 1 - Koleksi Buku Rafi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; }
        .card { border-radius: 15px; border: none; transition: 0.3s; }
        .card:hover { transform: scale(1.02); }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold">📚 Koleksi Perpustakaan Digital</h1>
            <p class="text-muted">Admin: M. Rafi Risqiyanto (60324001)</p>
        </div>

        <?php
        // --- DATA BUKU 1 ---
        $judul1 = "Pemrograman PHP Modern";
        $kategori1 = "Programming";
        $bahasa1 = "Indonesia";
        $halaman1 = 450;
        $berat1 = 500;
        $harga1 = 95000;
        $stok1 = 12;

        // --- DATA BUKU 2 ---
        $judul2 = "MySQL Database Administration";
        $kategori2 = "Database";
        $bahasa2 = "Inggris";
        $halaman2 = 320;
        $berat2 = 400;
        $harga2 = 120000;
        $stok2 = 5;

        // --- DATA BUKU 3 ---
        $judul3 = "Creative Web Design";
        $kategori3 = "Web Design";
        $bahasa2 = "Indonesia"; // diinstruksi diminta Indonesia/Inggris
        $halaman3 = 280;
        $berat3 = 350;
        $harga3 = 85000;
        $stok3 = 20;
        ?>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-primary mb-2"><?php echo $kategori1; ?></span>
                        <h5 class="card-title fw-bold"><?php echo $judul1; ?></h5>
                        <hr>
                        <p class="small mb-1"><strong>Bahasa:</strong> Indonesia</p>
                        <p class="small mb-1"><strong>Halaman:</strong> <?php echo $halaman1; ?> hlm</p>
                        <p class="small mb-1"><strong>Berat:</strong> <?php echo $berat1; ?> gram</p>
                        <p class="small mb-1"><strong>Harga:</strong> Rp <?php echo number_format($harga1, 0, ',', '.'); ?></p>
                        <p class="small"><strong>Stok:</strong> <span class="text-success"><?php echo $stok1; ?> tersedia</span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-success mb-2"><?php echo $kategori2; ?></span>
                        <h5 class="card-title fw-bold"><?php echo $judul2; ?></h5>
                        <hr>
                        <p class="small mb-1"><strong>Bahasa:</strong> Inggris</p>
                        <p class="small mb-1"><strong>Halaman:</strong> <?php echo $halaman2; ?> hlm</p>
                        <p class="small mb-1"><strong>Berat:</strong> <?php echo $berat2; ?> gram</p>
                        <p class="small mb-1"><strong>Harga:</strong> Rp <?php echo number_format($harga2, 0, ',', '.'); ?></p>
                        <p class="small"><strong>Stok:</strong> <span class="text-danger"><?php echo $stok2; ?> sisa sedikit</span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-info text-dark mb-2"><?php echo $kategori3; ?></span>
                        <h5 class="card-title fw-bold"><?php echo $judul3; ?></h5>
                        <hr>
                        <p class="small mb-1"><strong>Bahasa:</strong> Indonesia</p>
                        <p class="small mb-1"><strong>Halaman:</strong> <?php echo $halaman3; ?> hlm</p>
                        <p class="small mb-1"><strong>Berat:</strong> <?php echo $berat3; ?> gram</p>
                        <p class="small mb-1"><strong>Harga:</strong> Rp <?php echo number_format($harga3, 0, ',', '.'); ?></p>
                        <p class="small"><strong>Stok:</strong> <span class="text-success"><?php echo $stok3; ?> tersedia</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>