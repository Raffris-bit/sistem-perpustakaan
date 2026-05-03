<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Anggota Perpustakaan - M. Rafi Risqiyanto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <?php
    // Include functions
    require_once 'functions_anggota.php';
    
    // Data anggota
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

    // Cek fitur Bonus Search & Sort via $_GET
    $keyword = isset($_GET['search']) ? $_GET['search'] : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';

    $data_tampil = $anggota_list;

    // Terapkan Bonus: Search
    if (!empty($keyword)) {
        $data_tampil = search_anggota_by_nama($data_tampil, $keyword);
    }

    // Terapkan Bonus: Sort
    if ($sort == 'az') {
        $data_tampil = sort_anggota_by_nama($data_tampil);
    }
    ?>
    
    <div class="container mt-5 mb-5">
        <!-- Identitas Mahasiswa -->
        <div class="alert alert-dark text-center shadow-sm">
            <strong>M. Rafi Risqiyanto | 60324001</strong> - Tugas 2 (Pertemuan 4)
        </div>

        <h1 class="mb-4"><i class="bi bi-people"></i> Sistem Anggota Perpustakaan</h1>
        
        <!-- Dashboard Statistik -->
        <div class="row mb-4">
            <?php 
                $total = hitung_total_anggota($anggota_list);
                $aktif = hitung_anggota_aktif($anggota_list);
                $nonaktif = $total - $aktif;
                $rata_pinjam = hitung_rata_rata_pinjaman($anggota_list);
                $persen_aktif = ($total > 0) ? round(($aktif/$total)*100, 1) : 0;
                $persen_nonaktif = ($total > 0) ? round(($nonaktif/$total)*100, 1) : 0;
            ?>
            <div class="col-md-3">
                <div class="card border-primary shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Anggota</h6>
                        <h2 class="text-primary mb-0"><?php echo $total; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-success shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Anggota Aktif</h6>
                        <h2 class="text-success mb-0"><?php echo $aktif; ?></h2>
                        <small class="text-muted"><?php echo $persen_aktif; ?>%</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-danger shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Anggota Non-aktif</h6>
                        <h2 class="text-danger mb-0"><?php echo $nonaktif; ?></h2>
                        <small class="text-muted"><?php echo $persen_nonaktif; ?>%</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-info shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Rata-rata Pinjaman</h6>
                        <h2 class="text-info mb-0"><?php echo $rata_pinjam; ?></h2>
                        <small class="text-muted">Buku / Anggota</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Tabel Anggota -->
            <div class="col-md-8">
                <!-- Fitur Search dan Sort -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-body p-2">
                        <form method="GET" class="row g-2 align-items-center">
                            <div class="col-auto">
                                <label class="col-form-label"><strong><i class="bi bi-funnel"></i> Bonus Fitur:</strong></label>
                            </div>
                            <div class="col-auto">
                                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama..." value="<?php echo htmlspecialchars($keyword); ?>">
                            </div>
                            <div class="col-auto">
                                <select name="sort" class="form-select form-select-sm">
                                    <option value="">Default (Urutan ID)</option>
                                    <option value="az" <?php echo ($sort == 'az') ? 'selected' : ''; ?>>Urutkan Nama (A-Z)</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-sm">Terapkan</button>
                                <a href="sistem_anggota.php" class="btn btn-secondary btn-sm">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Anggota</h5>
                        <span class="badge bg-light text-dark"><?php echo count($data_tampil); ?> Data</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Tgl Daftar (Indo)</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($data_tampil) > 0): ?>
                                        <?php foreach ($data_tampil as $agt): ?>
                                        <tr>
                                            <td><code><?php echo $agt['id']; ?></code></td>
                                            <td><strong><?php echo $agt['nama']; ?></strong></td>
                                            <td>
                                                <?php 
                                                    // Menggunakan fungsi validasi_email
                                                    if(validasi_email($agt['email'])) {
                                                        echo $agt['email'];
                                                    } else {
                                                        echo "<span class='text-danger'>Email Invalid</span>";
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo format_tanggal_indo($agt['tanggal_daftar']); ?></td>
                                            <td>
                                                <?php if ($agt['status'] == 'Aktif'): ?>
                                                    <span class="badge bg-success">Aktif</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Non-aktif</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">Pencarian tidak ditemukan.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tampilkan Daftar Anggota Aktif dan Non-Aktif Terpisah -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow-sm border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">Daftar Anggota Aktif</h6>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <?php 
                                    $data_aktif = filter_by_status($anggota_list, "Aktif");
                                    foreach ($data_aktif as $aktif): 
                                    ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?php echo $aktif['nama']; ?>
                                            <span class="badge bg-primary rounded-pill"><?php echo $aktif['total_pinjaman']; ?> Pinjaman</span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm border-danger">
                            <div class="card-header bg-danger text-white">
                                <h6 class="mb-0">Daftar Anggota Non-aktif</h6>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <?php 
                                    $data_nonaktif = filter_by_status($anggota_list, "Non-aktif");
                                    foreach ($data_nonaktif as $naktif): 
                                    ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?php echo $naktif['nama']; ?>
                                            <span class="badge bg-secondary rounded-pill"><?php echo $naktif['total_pinjaman']; ?> Pinjaman</span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            <!-- Anggota Teraktif -->
            <div class="col-md-4">
                <div class="card shadow-sm border-warning sticky-top" style="top: 20px;">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-trophy-fill"></i> Anggota Teraktif</h5>
                    </div>
                    <div class="card-body text-center">
                        <?php $teraktif = cari_anggota_teraktif($anggota_list); ?>
                        <i class="bi bi-person-bounding-box text-primary mb-3" style="font-size: 5rem; display: block;"></i>
                        <h4 class="text-primary fw-bold"><?php echo $teraktif['nama']; ?></h4>
                        <p class="text-muted"><?php echo $teraktif['id']; ?></p>
                        
                        <div class="p-3 bg-light rounded border mb-3">
                            <h5 class="mb-0 text-success">Total Pinjaman</h5>
                            <h2 class="mb-0 text-success fw-bold"><?php echo $teraktif['total_pinjaman']; ?></h2>
                            <small class="text-muted">Buku sepanjang waktu</small>
                        </div>

                        <ul class="list-group list-group-flush text-start">
                            <li class="list-group-item"><i class="bi bi-envelope"></i> <?php echo $teraktif['email']; ?></li>
                            <li class="list-group-item"><i class="bi bi-telephone"></i> <?php echo $teraktif['telepon']; ?></li>
                            <li class="list-group-item"><i class="bi bi-geo-alt"></i> <?php echo $teraktif['alamat']; ?></li>
                            <li class="list-group-item"><i class="bi bi-calendar-check"></i> Bergabung: <br><strong><?php echo format_tanggal_indo($teraktif['tanggal_daftar']); ?></strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>