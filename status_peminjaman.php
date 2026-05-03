<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman - M. Rafi Risqiyanto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <!-- Identitas Mahasiswa -->
        <div class="alert alert-dark text-center shadow-sm">
            <strong>M. Rafi Risqiyanto | 60324001</strong> - Tugas 1 (Pertemuan 3)
        </div>

        <h1 class="mb-4 text-center"><i class="bi bi-person-badge"></i> Status Peminjaman Anggota</h1>
        
        <?php
        // Data Anggota sesuai modul
        $nama_anggota = "Budi Santoso";
        $total_pinjaman = 2;
        $buku_terlambat = 1;
        $hari_keterlambatan = 5; // hari

        // 1. Menggunakan IF-ELSEIF-ELSE: Hitung Denda
        $denda = 0;
        if ($buku_terlambat > 0) {
            $denda = $buku_terlambat * $hari_keterlambatan * 1000;
            // Maksimal denda Rp 50.000
            if ($denda > 50000) {
                $denda = 50000;
            }
        }

        // 2. Menggunakan IF-ELSEIF-ELSE: Cek Status Boleh Pinjam
        if ($buku_terlambat > 0) {
            $status_pinjam = "Tidak bisa pinjam";
            $alasan = "Anda memiliki buku yang terlambat dikembalikan. Harap lunasi denda terlebih dahulu.";
            $alert_class = "danger";
            $icon = "x-circle";
        } elseif ($total_pinjaman >= 3) {
            $status_pinjam = "Tidak bisa pinjam";
            $alasan = "Kuota peminjaman Anda sudah penuh (Maksimal 3 buku).";
            $alert_class = "warning";
            $icon = "exclamation-triangle";
        } else {
            $sisa_kuota = 3 - $total_pinjaman;
            $status_pinjam = "Boleh pinjam";
            $alasan = "Anda masih memiliki sisa kuota pinjam sebanyak $sisa_kuota buku.";
            $alert_class = "success";
            $icon = "check-circle";
        }

        // 3. Menggunakan SWITCH: Tentukan Level Member
        // Trik PHP: Menggunakan switch(true) untuk mengecek kondisi range nilai
        switch (true) {
            case ($total_pinjaman >= 0 && $total_pinjaman <= 5):
                $level = "Bronze";
                $badge_color = "secondary"; // Warna perunggu/abu-abu
                break;
            case ($total_pinjaman >= 6 && $total_pinjaman <= 15):
                $level = "Silver";
                $badge_color = "info"; // Warna perak/biru muda
                break;
            case ($total_pinjaman > 15):
                $level = "Gold";
                $badge_color = "warning text-dark"; // Warna emas
                break;
            default:
                $level = "Unknown";
                $badge_color = "dark";
        }
        ?>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Profil Member</h5>
                        <span class="badge bg-<?php echo $badge_color; ?> fs-6">Member <?php echo $level; ?></span>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $nama_anggota; ?></h4>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <p class="mb-1 text-muted">Total Buku Sedang Dipinjam</p>
                                <h5><?php echo $total_pinjaman; ?> Buku</h5>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-1 text-muted">Buku Terlambat</p>
                                <h5><?php echo $buku_terlambat; ?> Buku (<?php echo $hari_keterlambatan; ?> Hari)</h5>
                            </div>
                        </div>

                        <!-- Peringatan Keterlambatan dan Denda -->
                        <?php if ($buku_terlambat > 0): ?>
                        <div class="alert alert-danger">
                            <h6 class="alert-heading"><i class="bi bi-exclamation-octagon-fill"></i> Peringatan Keterlambatan!</h6>
                            <p class="mb-0">Anda memiliki denda keterlambatan sebesar <strong>Rp <?php echo number_format($denda, 0, ',', '.'); ?></strong>.</p>
                        </div>
                        <?php endif; ?>

                        <!-- Status Peminjaman Saat Ini -->
                        <div class="alert alert-<?php echo $alert_class; ?> mt-3">
                            <h5 class="alert-heading"><i class="bi bi-<?php echo $icon; ?>-fill"></i> Status: <?php echo $status_pinjam; ?></h5>
                            <p class="mb-0"><?php echo $alasan; ?></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>