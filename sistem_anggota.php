<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <?php
    // 1. Include functions
    require_once 'functions_anggota.php';
    
    // 2. Data anggota (Minimal 5)
    $anggota_list = [
        ["id" => "AGT-001", "nama" => "Budi Santoso", "email" => "budi@email.com", "telepon" => "081234567890", "alamat" => "Jakarta", "tanggal_daftar" => "2024-01-15", "status" => "Aktif", "total_pinjaman" => 5],
        ["id" => "AGT-002", "nama" => "Siti Aminah", "email" => "siti@email.com", "telepon" => "082345678901", "alamat" => "Pekalongan", "tanggal_daftar" => "2024-02-10", "status" => "Aktif", "total_pinjaman" => 12],
        ["id" => "AGT-003", "nama" => "Andi Nugroho", "email" => "andi@email.com", "telepon" => "083456789012", "alamat" => "Batang", "tanggal_daftar" => "2023-11-05", "status" => "Non-Aktif", "total_pinjaman" => 0],
        ["id" => "AGT-004", "nama" => "Rina Wijaya", "email" => "rina@email.com", "telepon" => "084567890123", "alamat" => "Semarang", "tanggal_daftar" => "2024-03-20", "status" => "Aktif", "total_pinjaman" => 3],
        ["id" => "AGT-005", "nama" => "Dedi Santoso", "email" => "dedi@email.com", "telepon" => "085678901234", "alamat" => "Kajen", "tanggal_daftar" => "2023-08-12", "status" => "Non-Aktif", "total_pinjaman" => 8]
    ];

    // Persiapan Variabel pakai Function
    $total = hitung_total_anggota($anggota_list);
    $aktif = hitung_anggota_aktif($anggota_list);
    $nonaktif = $total - $aktif;
    $rata_rata = hitung_rata_rata_pinjaman($anggota_list);
    $teraktif = cari_anggota_teraktif($anggota_list);
    
    // Sort Anggota (Bonus)
    $anggota_sorted = sort_anggota_by_nama($anggota_list);
    
    // Pecah jadi 2 array untuk ditampilin terpisah
    $list_aktif = filter_by_status($anggota_sorted, "Aktif");
    $list_nonaktif = filter_by_status($anggota_sorted, "Non-Aktif");
    ?>
    
    <nav class="navbar navbar-dark bg-primary shadow-sm mb-4">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1"><i class="bi bi-people"></i> Sistem Anggota UIN Gusdur</span>
            <span class="navbar-text text-white">Admin: M. Rafi Risqiyanto | 60324001</span>
        </div>
    </nav>

    <div class="container">
        
        <div class="row mb-4 text-center">
            <div class="col-md-3 mb-2"><div class="card border-primary shadow-sm"><div class="card-body"><h4 class="text-primary"><?php echo $total; ?></h4><small>Total Anggota</small></div></div></div>
            <div class="col-md-3 mb-2"><div class="card border-success shadow-sm"><div class="card-body"><h4 class="text-success"><?php echo $aktif; ?></h4><small>Anggota Aktif</small></div></div></div>
            <div class="col-md-3 mb-2"><div class="card border-danger shadow-sm"><div class="card-body"><h4 class="text-danger"><?php echo $nonaktif; ?></h4><small>Anggota Non-Aktif</small></div></div></div>
            <div class="col-md-3 mb-2"><div class="card border-info shadow-sm"><div class="card-body"><h4 class="text-info"><?php echo number_format($rata_rata, 1); ?></h4><small>Rata-rata Pinjam</small></div></div></div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-warning text-dark fw-bold">
                        <i class="bi bi-award-fill"></i> Anggota Teraktif
                    </div>
                    <div class="card-body text-center">
                        <i class="bi bi-person-circle text-secondary" style="font-size: 4rem;"></i>
                        <h4 class="mt-2 fw-bold"><?php echo $teraktif["nama"]; ?></h4>
                        <p class="text-muted mb-1"><?php echo $teraktif["id"]; ?></p>
                        <span class="badge bg-success p-2 fs-6 border border-light"><?php echo $teraktif["total_pinjaman"]; ?> Pinjaman</span>
                        <hr>
                        <small class="text-muted">Bergabung: <?php echo format_tanggal_indo($teraktif["tanggal_daftar"]); ?></small>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-dark text-white fw-bold"><i class="bi bi-search"></i> Test Search Bonus (Keyword: 'san')</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <?php 
                            $hasil_cari = search_anggota_by_nama($anggota_list, "san");
                            foreach($hasil_cari as $c): ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <?php echo $c["nama"]; ?> <span class="badge bg-secondary"><?php echo $c["id"]; ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-success text-white fw-bold">
                        <i class="bi bi-person-check-fill"></i> Daftar Anggota AKTIF (A-Z)
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr><th>ID</th><th>Nama Lengkap</th><th>Email (Valid)</th><th>Tgl Daftar</th><th>Pinjam</th></tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list_aktif as $agt): ?>
                                    <tr>
                                        <td><code><?php echo $agt["id"]; ?></code></td>
                                        <td><strong><?php echo $agt["nama"]; ?></strong></td>
                                        <td>
                                            <?php echo $agt["email"]; ?><br>
                                            <?php echo validasi_email($agt["email"]) ? '<small class="text-success"><i class="bi bi-check-circle"></i> Valid</small>' : '<small class="text-danger"><i class="bi bi-x-circle"></i> Invalid</small>'; ?>
                                        </td>
                                        <td><?php echo format_tanggal_indo($agt["tanggal_daftar"]); ?></td>
                                        <td class="text-center fw-bold"><?php echo $agt["total_pinjaman"]; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white fw-bold">
                        <i class="bi bi-person-x-fill"></i> Daftar Anggota NON-AKTIF (A-Z)
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr><th>ID</th><th>Nama Lengkap</th><th>Email (Valid)</th><th>Tgl Daftar</th><th>Pinjam</th></tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list_nonaktif as $agt): ?>
                                    <tr>
                                        <td><code><?php echo $agt["id"]; ?></code></td>
                                        <td><strong><?php echo $agt["nama"]; ?></strong></td>
                                        <td>
                                            <?php echo $agt["email"]; ?><br>
                                            <?php echo validasi_email($agt["email"]) ? '<small class="text-success"><i class="bi bi-check-circle"></i> Valid</small>' : '<small class="text-danger"><i class="bi bi-x-circle"></i> Invalid</small>'; ?>
                                        </td>
                                        <td><?php echo format_tanggal_indo($agt["tanggal_daftar"]); ?></td>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>