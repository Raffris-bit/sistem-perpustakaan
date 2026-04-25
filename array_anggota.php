<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Array Anggota - Rafi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="alert alert-dark shadow-sm">
            <strong>M. Rafi Risqiyanto</strong> | NIM: 60324001
        </div>

        <h1 class="mb-4 fw-bold"><i class="bi bi-people-fill"></i> Data Anggota Perpustakaan</h1>
        
        <?php
        // 1. DATA ANGGOTA (Minimal 5)
        $anggota_list = [
            ["id" => "AGT-001", "nama" => "Budi Santoso", "email" => "budi@email.com", "telepon" => "081234567890", "alamat" => "Jakarta", "tanggal_daftar" => "2024-01-15", "status" => "Aktif", "total_pinjaman" => 5],
            ["id" => "AGT-002", "nama" => "Siti Aminah", "email" => "siti@email.com", "telepon" => "082345678901", "alamat" => "Pekalongan", "tanggal_daftar" => "2024-02-10", "status" => "Aktif", "total_pinjaman" => 12],
            ["id" => "AGT-003", "nama" => "Andi Nugroho", "email" => "andi@email.com", "telepon" => "083456789012", "alamat" => "Batang", "tanggal_daftar" => "2023-11-05", "status" => "Non-Aktif", "total_pinjaman" => 0],
            ["id" => "AGT-004", "nama" => "Rina Wijaya", "email" => "rina@email.com", "telepon" => "084567890123", "alamat" => "Semarang", "tanggal_daftar" => "2024-03-20", "status" => "Aktif", "total_pinjaman" => 3],
            ["id" => "AGT-005", "nama" => "Dedi Santoso", "email" => "dedi@email.com", "telepon" => "085678901234", "alamat" => "Kajen", "tanggal_daftar" => "2023-08-12", "status" => "Non-Aktif", "total_pinjaman" => 8]
        ];

        // 2. HITUNG STATISTIK MANUAL
        $total_anggota = count($anggota_list);
        $anggota_aktif = 0;
        $anggota_nonaktif = 0;
        $total_semua_pinjaman = 0;
        
        $teraktif_pinjaman = -1;
        $anggota_teraktif = null;

        foreach ($anggota_list as $anggota) {
            // Hitung aktif / non-aktif
            if ($anggota["status"] == "Aktif") {
                $anggota_aktif++;
            } else {
                $anggota_nonaktif++;
            }
            
            // Hitung total pinjaman untuk rata-rata
            $total_semua_pinjaman += $anggota["total_pinjaman"];

            // Cari yang paling rajin pinjam
            if ($anggota["total_pinjaman"] > $teraktif_pinjaman) {
                $teraktif_pinjaman = $anggota["total_pinjaman"];
                $anggota_teraktif = $anggota;
            }
        }

        // Hitung Persentase dan Rata-rata
        $persen_aktif = ($total_anggota > 0) ? ($anggota_aktif / $total_anggota) * 100 : 0;
        $persen_nonaktif = ($total_anggota > 0) ? ($anggota_nonaktif / $total_anggota) * 100 : 0;
        $rata_rata_pinjaman = ($total_anggota > 0) ? ($total_semua_pinjaman / $total_anggota) : 0;
        ?>

        <div class="row mb-4">
            <div class="col-md-3 mb-3"><div class="card bg-primary text-white shadow-sm"><div class="card-body text-center"><h3 class="fw-bold"><?php echo $total_anggota; ?></h3><small>Total Anggota</small></div></div></div>
            <div class="col-md-3 mb-3"><div class="card bg-success text-white shadow-sm"><div class="card-body text-center"><h3 class="fw-bold"><?php echo $persen_aktif; ?>%</h3><small>Anggota Aktif</small></div></div></div>
            <div class="col-md-3 mb-3"><div class="card bg-danger text-white shadow-sm"><div class="card-body text-center"><h3 class="fw-bold"><?php echo $persen_nonaktif; ?>%</h3><small>Anggota Non-Aktif</small></div></div></div>
            <div class="col-md-3 mb-3"><div class="card bg-info text-dark shadow-sm"><div class="card-body text-center"><h3 class="fw-bold"><?php echo number_format($rata_rata_pinjaman, 1); ?></h3><small>Rata-rata Pinjaman</small></div></div></div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-warning shadow-sm h-100">
                    <div class="card-header bg-warning text-dark fw-bold"><i class="bi bi-star-fill"></i> Anggota Teraktif</div>
                    <div class="card-body text-center">
                        <h4 class="fw-bold text-primary mt-2"><?php echo $anggota_teraktif["nama"]; ?></h4>
                        <p class="text-muted mb-2"><?php echo $anggota_teraktif["id"]; ?></p>
                        <span class="badge bg-success fs-6"><?php echo $anggota_teraktif["total_pinjaman"]; ?> Buku Dipinjam</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-header bg-dark text-white fw-bold"><i class="bi bi-table"></i> Daftar Semua Anggota</div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr><th>ID</th><th>Nama</th><th>Alamat</th><th>Status</th><th>Pinjaman</th></tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($anggota_list as $agt): 
                                        $badge = ($agt["status"] == "Aktif") ? "success" : "danger";
                                    ?>
                                    <tr>
                                        <td><code><?php echo $agt["id"]; ?></code></td>
                                        <td><strong><?php echo $agt["nama"]; ?></strong><br><small class="text-muted"><?php echo $agt["email"]; ?></small></td>
                                        <td><?php echo $agt["alamat"]; ?></td>
                                        <td><span class="badge bg-<?php echo $badge; ?>"><?php echo $agt["status"]; ?></span></td>
                                        <td class="text-center fw-bold"><?php echo $agt["total_pinjaman"]; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>