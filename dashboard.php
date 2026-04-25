<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan - Rafi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { border: none; border-radius: 15px; transition: 0.3s; }
        .card:hover { transform: translateY(-5px); }
    </style>
</head>
<body>
    <?php
    // 1. KOTAK INFO PERPUSTAKAAN
    $nama_perpus = "Perpustakaan Digital UIN Gusdur";
    $alamat = "Jl. Pahlawan, Kajen, Pekalongan";
    
    // 2. KOTAK HITUNG-HITUNGAN (Statistik)
    $total_buku = 1500;
    $buku_dipinjam = 234;
    $buku_tersedia = $total_buku - $buku_dipinjam;
    $persen_tersedia = round(($buku_tersedia / $total_buku) * 100, 1);
    
    // 3. MANTRA WAKTU OTOMATIS
    $hari_ini = date('l, d F Y');
    $jam = date('H'); // Ngambil jam sekarang (00-23)
    
    // Siapa yang nyapa? (Logika Salam)
    if ($jam >= 5 && $jam < 12) {
        $salam = "Selamat Pagi";
        $icon = "bi-sunrise-fill text-warning";
    } elseif ($jam >= 12 && $jam < 15) {
        $salam = "Selamat Siang";
        $icon = "bi-sun-fill text-danger";
    } elseif ($jam >= 15 && $jam < 18) {
        $salam = "Selamat Sore";
        $icon = "bi-cloud-sun-fill text-info";
    } else {
        $salam = "Selamat Malam";
        $icon = "bi-moon-stars-fill text-primary";
    }
    ?>
    
    <nav class="navbar navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-book-half"></i> <?php echo $nama_perpus; ?>
            </a>
            <span class="navbar-text text-white">
                Admin: **M. Rafi Risqiyanto (60324001)**
            </span>
        </div>
    </nav>
    
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold"><i class="<?php echo $icon; ?>"></i> <?php echo $salam; ?>, Rafi!</h2>
                <p class="text-muted"><i class="bi bi-calendar3"></i> <?php echo $hari_ini; ?></p>
            </div>
        </div>
        
        <div class="row text-center">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm p-3">
                    <h6 class="text-muted">Total Koleksi</h6>
                    <h2 class="fw-bold text-primary"><?php echo number_format($total_buku); ?></h2>
                    <small>Buku Terdaftar</small>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm p-3 border-start border-warning border-5">
                    <h6 class="text-muted">Sedang Dipinjam</h6>
                    <h2 class="fw-bold text-warning"><?php echo $buku_dipinjam; ?></h2>
                    <small>Buku di Luar</small>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm p-3 border-start border-success border-5">
                    <h6 class="text-muted">Tersedia</h6>
                    <h2 class="fw-bold text-success"><?php echo $buku_tersedia; ?></h2>
                    <small>Siap Dibaca</small>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Persentase Stok Tersedia</h5>
                <div class="progress" style="height: 30px;">
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                         role="progressbar" style="width: <?php echo $persen_tersedia; ?>%">
                         <?php echo $persen_tersedia; ?>% Aman
                    </div>
                </div>
                <p class="mt-3 mb-0 small text-muted">
                    <i class="bi bi-info-circle"></i> Alamat: <?php echo $alamat; ?>
                </p>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 mt-5 text-muted">
        <small>&copy; 2026 - Dibuat dengan ❤️ oleh Rafi Risqiyanto</small>
    </div>
</body>
</html>