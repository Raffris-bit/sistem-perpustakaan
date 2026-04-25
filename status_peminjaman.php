<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman - Rafi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0"><i class="bi bi-person-badge"></i> Kartu Status Anggota</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php
                        // 1. DATA ANGGOTA (Kotak Bekal)
                        $nama_anggota = "Budi Santoso";
                        $total_pinjaman = 2;       // Jumlah buku yang dipinjam sekarang
                        $buku_terlambat = 1;       // Ada 1 buku yang telat
                        $hari_keterlambatan = 5;   // Telat 5 hari

                        // 2. HITUNG DENDA (Maksimal 50.000)
                        $denda = $buku_terlambat * $hari_keterlambatan * 1000;
                        if ($denda > 50000) {
                            $denda = 50000; // Kalau denda lebih dari 50rb, mentok di 50rb aja
                        }

                        // 3. LOGIKA SATPAM (Boleh pinjam lagi nggak?)
                        if ($buku_terlambat > 0) {
                            $pesan_status = "TIDAK BISA PINJAM: Anda memiliki buku terlambat!";
                            $alert_warna = "danger";
                            $icon = "x-octagon-fill";
                        } elseif ($total_pinjaman >= 3) {
                            $pesan_status = "TIDAK BISA PINJAM: Batas pinjaman terpenuhi (Maks 3).";
                            $alert_warna = "warning";
                            $icon = "exclamation-triangle-fill";
                        } else {
                            $pesan_status = "BISA PINJAM: Silakan pilih buku baru.";
                            $alert_warna = "success";
                            $icon = "check-circle-fill";
                        }

                        // 4. LEVEL MEMBER (Pake SWITCH)
                        // Karena kita ngecek rentang angka (0-5, 6-15), kita pakai switch(true)
                        switch (true) {
                            case ($total_pinjaman > 15):
                                $level = "Gold";
                                $badge_warna = "warning text-dark"; // Warna emas
                                break;
                            case ($total_pinjaman >= 6):
                                $level = "Silver";
                                $badge_warna = "secondary"; // Warna perak
                                break;
                            default:
                                $level = "Bronze";
                                $badge_warna = "dark"; // Warna perunggu
                                break;
                        }
                        ?>

                        <div class="text-center mb-4">
                            <h3 class="fw-bold"><?php echo $nama_anggota; ?></h3>
                            <span class="badge bg-<?php echo $badge_warna; ?> fs-6">Member <?php echo $level; ?></span>
                        </div>

                        <ul class="list-group mb-4">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Peminjaman Aktif
                                <span class="badge bg-primary rounded-pill"><?php echo $total_pinjaman; ?> Buku</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Buku Terlambat
                                <span class="badge bg-danger rounded-pill"><?php echo $buku_terlambat; ?> Buku</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-danger fw-bold">
                                Total Tagihan Denda
                                <span>Rp <?php echo number_format($denda, 0, ',', '.'); ?></span>
                            </li>
                        </ul>

                        <div class="alert alert-<?php echo $alert_warna; ?> fw-bold text-center">
                            <i class="bi bi-<?php echo $icon; ?> fs-5"></i><br>
                            <?php echo $pesan_status; ?>
                        </div>

                    </div>
                    <div class="card-footer text-muted text-center small">
                        Petugas: M. Rafi Risqiyanto | NIM: 60324001
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>