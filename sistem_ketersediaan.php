<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Ketersediaan - Rafi Risqiyanto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .table-hover tbody tr:hover { background-color: #f8f9fa; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-building"></i> Perpustakaan UIN Gusdur
            </a>
            <span class="navbar-text text-white">
                Admin: M. Rafi Risqiyanto (60324001)
            </span>
        </div>
    </nav>
    
    <div class="container mt-4">
        <h2 class="mb-4 fw-bold"><i class="bi bi-search"></i> Dashboard Stok Buku</h2>
        
        <?php
        // INI NAMANYA ARRAY (Keranjang besar isi banyak kotak buku)
        $buku_list = [
            ["kode" => "BK-001", "judul" => "Pemrograman PHP Pemula", "kategori" => "Programming", "pengarang" => "Budi Raharjo", "tahun" => 2023, "harga" => 75000, "stok" => 8],
            ["kode" => "BK-002", "judul" => "Mastering MySQL Database", "kategori" => "Database", "pengarang" => "Andi Nugroho", "tahun" => 2022, "harga" => 95000, "stok" => 0],
            ["kode" => "BK-003", "judul" => "Laravel Framework Advanced", "kategori" => "Programming", "pengarang" => "Siti Aminah", "tahun" => 2024, "harga" => 125000, "stok" => 2],
            ["kode" => "BK-004", "judul" => "Web Design Principles", "kategori" => "Web Design", "pengarang" => "Dedi Santoso", "tahun" => 2023, "harga" => 85000, "stok" => 15],
            ["kode" => "BK-005", "judul" => "Network Security Fund.", "kategori" => "Networking", "pengarang" => "Rina Wijaya", "tahun" => 2023, "harga" => 110000, "stok" => 5]
        ];
        
        // Siapin keranjang kosong buat ngitung (Variabel Awal)
        $total_buku = count($buku_list); // Hitung ada berapa judul
        $total_stok = 0;
        $buku_tersedia = 0;
        $buku_habis = 0;
        
        // FOREACH LOOP: Ngitung semua isi kotak satu-satu
        foreach ($buku_list as $buku) {
            $total_stok += $buku["stok"]; // Tambahin stoknya terus
            
            // IF-ELSE: Ngecek habis apa nggak
            if ($buku["stok"] > 0) {
                $buku_tersedia++;
            } else {
                $buku_habis++;
            }
        }
        ?>
        
        <div class="row mb-4">
            <div class="col-md-3"><div class="card border-primary shadow-sm"><div class="card-body text-center"><h3 class="text-primary"><?php echo $total_buku; ?></h3><p class="mb-0">Total Judul</p></div></div></div>
            <div class="col-md-3"><div class="card border-success shadow-sm"><div class="card-body text-center"><h3 class="text-success"><?php echo $buku_tersedia; ?></h3><p class="mb-0">Judul Tersedia</p></div></div></div>
            <div class="col-md-3"><div class="card border-danger shadow-sm"><div class="card-body text-center"><h3 class="text-danger"><?php echo $buku_habis; ?></h3><p class="mb-0">Judul Habis</p></div></div></div>
            <div class="col-md-3"><div class="card border-info shadow-sm"><div class="card-body text-center"><h3 class="text-info"><?php echo $total_stok; ?></h3><p class="mb-0">Total Buku Fisik</p></div></div></div>
        </div>
        
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Buku Lengkap</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Judul Buku</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            // Panggil FOREACH lagi buat nulis ke tabel
                            foreach ($buku_list as $buku) {
                                
                                // SWITCH: Nentuin warna berdasarkan kategori
                                switch ($buku["kategori"]) {
                                    case "Programming": $warna_kategori = "primary"; $icon = "code-slash"; break;
                                    case "Database": $warna_kategori = "success"; $icon = "database"; break;
                                    case "Web Design": $warna_kategori = "info text-dark"; $icon = "palette"; break;
                                    case "Networking": $warna_kategori = "warning text-dark"; $icon = "wifi"; break;
                                    default: $warna_kategori = "secondary"; $icon = "book";
                                }
                                
                                // IF-ELSEIF-ELSE: Nentuin tulisan status berdasarkan sisa stok
                                if ($buku["stok"] == 0) {
                                    $status = "Habis"; $warna_status = "danger"; $dapat_pinjam = false;
                                } elseif ($buku["stok"] < 3) {
                                    $status = "Menipis"; $warna_status = "warning"; $dapat_pinjam = true;
                                } else {
                                    $status = "Aman"; $warna_status = "success"; $dapat_pinjam = true;
                                }
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><code><?php echo $buku["kode"]; ?></code></td>
                                <td><strong><?php echo $buku["judul"]; ?></strong></td>
                                <td><span class="badge bg-<?php echo $warna_kategori; ?>"><i class="bi bi-<?php echo $icon; ?>"></i> <?php echo $buku["kategori"]; ?></span></td>
                                <td class="fw-bold fs-5"><?php echo $buku["stok"]; ?></td>
                                <td><span class="badge bg-<?php echo $warna_status; ?>"><?php echo $status; ?></span></td>
                                <td>
                                    <?php if ($dapat_pinjam): ?>
                                        <button class="btn btn-sm btn-outline-success"><i class="bi bi-cart-plus"></i> Pinjam</button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-outline-secondary" disabled>Habis</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-warning">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-cart-exclamation"></i> Peringatan Restock (Order Buku Baru)
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php
                    $perlu_restock = false;
                    foreach ($buku_list as $buku) {
                        // Kalo stok di bawah 5, suruh admin beli lagi!
                        if ($buku["stok"] < 5) {
                            $perlu_restock = true;
                            $jumlah_order = 10 - $buku["stok"]; // Biar stoknya balik jadi 10
                    ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?php echo $buku["judul"]; ?></strong> (Sisa: <span class="text-danger"><?php echo $buku["stok"]; ?></span>)
                        </div>
                        <span class="badge bg-warning text-dark rounded-pill">
                            Pesan Tambahan: <?php echo $jumlah_order; ?> Eksemplar
                        </span>
                    </li>
                    <?php
                        }
                    }
                    // Kalo keranjangnya nggak ada yang di bawah 5:
                    if (!$perlu_restock) {
                        echo '<li class="list-group-item text-success fw-bold"><i class="bi bi-check-circle"></i> Semua stok aman, tidak perlu pesan buku baru.</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
