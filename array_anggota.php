<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Array Anggota Perpustakaan - M. Rafi Risqiyanto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <!-- Identitas Mahasiswa -->
        <div class="alert alert-dark text-center shadow-sm">
            <strong>M. Rafi Risqiyanto | 60324001</strong> - Tugas 1 (Pertemuan 4)
        </div>

        <h1 class="mb-4"><i class="bi bi-people-fill"></i> Data Anggota Perpustakaan</h1>
        
        <?php
        // 1. Inisialisasi Data Anggota (Minimal 5)
        $anggota_list = [
            [
                "id" => "AGT-001",
                "nama" => "Budi Santoso",
                "email" => "budi@email.com",
                "telepon" => "081234567890",
                "alamat" => "Jakarta",
                "tanggal_daftar" => "2024-01-15",
                "status" => "Aktif",
                "total_pinjaman" => 5
            ],
            [
                "id" => "AGT-002",
                "nama" => "Siti Aminah",
                "email" => "siti.aminah@email.com",
                "telepon" => "085678901234",
                "alamat" => "Bojong, Pekalongan",
                "tanggal_daftar" => "2024-02-10",
                "status" => "Aktif",
                "total_pinjaman" => 12
            ],
            [
                "id" => "AGT-003",
                "nama" => "Andi Nugroho",
                "email" => "andi.nugroho@email.com",
                "telepon" => "081122334455",
                "alamat" => "Semarang",
                "tanggal_daftar" => "2023-11-20",
                "status" => "Non-aktif",
                "total_pinjaman" => 0
            ],
            [
                "id" => "AGT-004",
                "nama" => "Dewi Lestari",
                "email" => "dewi.l@email.com",
                "telepon" => "087766554433",
                "alamat" => "Bandung",
                "tanggal_daftar" => "2024-03-05",
                "status" => "Aktif",
                "total_pinjaman" => 3
            ],
            [
                "id" => "AGT-005",
                "nama" => "Rina Wijaya",
                "email" => "rina.wijaya@email.com",
                "telepon" => "089988776655",
                "alamat" => "Surabaya",
                "tanggal_daftar" => "2023-12-01",
                "status" => "Non-aktif",
                "total_pinjaman" => 8
            ]
        ];

        // 2. Proses Perhitungan Statistik
        $total_anggota = count($anggota_list);
        $anggota_aktif = 0;
        $anggota_nonaktif = 0;
        $total_semua_pinjaman = 0;
        
        $anggota_teraktif = $anggota_list[0]; // Asumsi awal index 0 teraktif

        foreach ($anggota_list as $anggota) {
            // Hitung aktif vs non-aktif
            if ($anggota["status"] == "Aktif") {
                $anggota_aktif++;
            } else {
                $anggota_nonaktif++;
            }

            // Hitung total pinjaman untuk rata-rata
            $total_semua_pinjaman += $anggota["total_pinjaman"];

            // Cari anggota teraktif
            if ($anggota["total_pinjaman"] > $anggota_teraktif["total_pinjaman"]) {
                $anggota_teraktif = $anggota;
            }
        }

        // Hitung Persentase dan Rata-rata
        $persen_aktif = ($total_anggota > 0) ? round(($anggota_aktif / $total_anggota) * 100, 1) : 0;
        $persen_nonaktif = ($total_anggota > 0) ? round(($anggota_nonaktif / $total_anggota) * 100, 1) : 0;
        $rata_rata_pinjaman = ($total_anggota > 0) ? round($total_semua_pinjaman / $total_anggota, 1) : 0;
        ?>

        <!-- 3. Tampilkan Statistik dalam Cards Bootstrap -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-primary shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Anggota</h6>
                        <h2 class="text-primary mb-0"><?php echo $total_anggota; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-success shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Anggota Aktif</h6>
                        <h2 class="text-success mb-0"><?php echo $anggota_aktif; ?></h2>
                        <small class="text-muted"><?php echo $persen_aktif; ?>%</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-danger shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Anggota Non-Aktif</h6>
                        <h2 class="text-danger mb-0"><?php echo $anggota_nonaktif; ?></h2>
                        <small class="text-muted"><?php echo $persen_nonaktif; ?>%</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-info shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Rata-rata Pinjaman</h6>
                        <h2 class="text-info mb-0"><?php echo $rata_rata_pinjaman; ?></h2>
                        <small class="text-muted">Buku / Anggota</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- 4. Tabel Semua Anggota -->
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Daftar Semua Anggota</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Total Pinjam</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($anggota_list as $agt): ?>
                                    <tr>
                                        <td><code><?php echo $agt['id']; ?></code></td>
                                        <td><?php echo $agt['nama']; ?></td>
                                        <td><?php echo $agt['email']; ?></td>
                                        <td class="text-center"><?php echo $agt['total_pinjaman']; ?></td>
                                        <td>
                                            <?php if ($agt['status'] == 'Aktif'): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Non-aktif</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Card Anggota Teraktif -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-star-fill"></i> Anggota Teraktif</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="bi bi-person-circle text-warning" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="text-center text-primary"><?php echo $anggota_teraktif['nama']; ?></h4>
                        <p class="text-center text-muted mb-4"><?php echo $anggota_teraktif['id']; ?></p>
                        
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Pinjaman
                                <span class="badge bg-primary rounded-pill fs-6"><?php echo $anggota_teraktif['total_pinjaman']; ?> Buku</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Status
                                <span class="badge bg-success">Aktif</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tanggal Daftar
                                <span><?php echo $anggota_teraktif['tanggal_daftar']; ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>