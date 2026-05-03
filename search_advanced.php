<?php
session_start();

// ========== DATA BUKU (Minimal 10 Buku) ==========
$buku_list = [
    ["kode" => "BK-001", "judul" => "Pemrograman PHP untuk Pemula", "kategori" => "Programming", "pengarang" => "Budi Raharjo", "penerbit" => "Informatika", "tahun" => 2023, "harga" => 75000, "stok" => 10],
    ["kode" => "BK-002", "judul" => "Mastering MySQL Database", "kategori" => "Database", "pengarang" => "Andi Nugroho", "penerbit" => "Graha Ilmu", "tahun" => 2022, "harga" => 95000, "stok" => 0],
    ["kode" => "BK-003", "judul" => "Laravel Framework Advanced", "kategori" => "Programming", "pengarang" => "Siti Aminah", "penerbit" => "Informatika", "tahun" => 2024, "harga" => 125000, "stok" => 8],
    ["kode" => "BK-004", "judul" => "Web Design Principles", "kategori" => "Web Design", "pengarang" => "Dedi Santoso", "penerbit" => "Andi Offset", "tahun" => 2023, "harga" => 85000, "stok" => 15],
    ["kode" => "BK-005", "judul" => "Network Security Fundamentals", "kategori" => "Networking", "pengarang" => "Rina Wijaya", "penerbit" => "Erlangga", "tahun" => 2020, "harga" => 110000, "stok" => 3],
    ["kode" => "BK-006", "judul" => "Data Science with Python", "kategori" => "Programming", "pengarang" => "Ilham Saputra", "penerbit" => "Elex Media", "tahun" => 2024, "harga" => 150000, "stok" => 5],
    ["kode" => "BK-007", "judul" => "UI/UX for Beginners", "kategori" => "Web Design", "pengarang" => "Dedi Santoso", "penerbit" => "Andi Offset", "tahun" => 2021, "harga" => 90000, "stok" => 12],
    ["kode" => "BK-008", "judul" => "PostgreSQL in Action", "kategori" => "Database", "pengarang" => "Budi Raharjo", "penerbit" => "Informatika", "tahun" => 2022, "harga" => 105000, "stok" => 0],
    ["kode" => "BK-009", "judul" => "Cisco Router Configuration", "kategori" => "Networking", "pengarang" => "Rina Wijaya", "penerbit" => "Erlangga", "tahun" => 2019, "harga" => 135000, "stok" => 7],
    ["kode" => "BK-010", "judul" => "Mastering React JS", "kategori" => "Programming", "pengarang" => "Siti Aminah", "penerbit" => "Informatika", "tahun" => 2023, "harga" => 115000, "stok" => 20]
];

// ========== AMBIL PARAMETER GET ==========
$keyword = $_GET['keyword'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$min_harga = $_GET['min_harga'] ?? '';
$max_harga = $_GET['max_harga'] ?? '';
$tahun = $_GET['tahun'] ?? '';
$status = $_GET['status'] ?? 'semua';
$sort = $_GET['sort'] ?? 'judul';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// ========== VALIDASI INPUT FILTER ==========
$errors = [];
if (!empty($min_harga) && !empty($max_harga)) {
    if ((int)$min_harga > (int)$max_harga) {
        $errors[] = "Harga minimum tidak boleh lebih besar dari harga maksimum.";
    }
}
if (!empty($tahun)) {
    if ($tahun < 1900 || $tahun > date('Y')) {
        $errors[] = "Tahun harus valid antara 1900 hingga " . date('Y');
    }
}

// ========== PROSES FILTER & SORTING ==========
$hasil = [];

// Fitur Bonus: Menyimpan Recent Searches ke Session
if (!empty($_GET) && count($errors) == 0 && empty($_GET['export'])) {
    $search_query = $_SERVER['QUERY_STRING'];
    if (!isset($_SESSION['recent_searches'])) {
        $_SESSION['recent_searches'] = [];
    }
    // Hindari duplikasi URL pencarian
    if (!in_array($search_query, $_SESSION['recent_searches']) && !empty($keyword)) {
        array_unshift($_SESSION['recent_searches'], $search_query); // Taruh di atas
        // Batasi maksimal 5 history
        if (count($_SESSION['recent_searches']) > 5) {
            array_pop($_SESSION['recent_searches']);
        }
    }
}

// Lakukan filtering jika tidak ada error
if (count($errors) == 0) {
    foreach ($buku_list as $buku) {
        $match = true;

        // 1. Filter Keyword (Judul / Pengarang)
        if (!empty($keyword)) {
            if (stripos($buku['judul'], $keyword) === false && stripos($buku['pengarang'], $keyword) === false) {
                $match = false;
            }
        }
        // 2. Filter Kategori
        if (!empty($kategori) && $buku['kategori'] !== $kategori) {
            $match = false;
        }
        // 3. Filter Range Harga
        if (!empty($min_harga) && $buku['harga'] < $min_harga) {
            $match = false;
        }
        if (!empty($max_harga) && $buku['harga'] > $max_harga) {
            $match = false;
        }
        // 4. Filter Tahun
        if (!empty($tahun) && $buku['tahun'] != $tahun) {
            $match = false;
        }
        // 5. Filter Status
        if ($status === 'Tersedia' && $buku['stok'] <= 0) {
            $match = false;
        } elseif ($status === 'Habis' && $buku['stok'] > 0) {
            $match = false;
        }

        if ($match) {
            $hasil[] = $buku;
        }
    }

    // Sorting Hasil
    usort($hasil, function($a, $b) use ($sort) {
        if ($sort === 'judul') {
            return strcmp($a['judul'], $b['judul']); // A-Z
        } elseif ($sort === 'harga_murah') {
            return $a['harga'] <=> $b['harga']; // Murah ke Mahal
        } elseif ($sort === 'harga_mahal') {
            return $b['harga'] <=> $a['harga']; // Mahal ke Murah
        } elseif ($sort === 'tahun_baru') {
            return $b['tahun'] <=> $a['tahun']; // Terbaru ke Terlama
        }
        return 0;
    });
}

// ========== BONUS: EXPORT KE CSV ==========
if (isset($_GET['export']) && $_GET['export'] == '1') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=Laporan_Buku_Rafi.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Kode', 'Judul', 'Kategori', 'Pengarang', 'Penerbit', 'Tahun', 'Harga', 'Stok']);
    foreach ($hasil as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit(); // Hentikan eksekusi HTML agar CSV murni ter-download
}

// ========== PAGINATION SEDERHANA (10 item per page) ==========
$total_hasil = count($hasil);
$limit = 10;
$total_pages = ceil($total_hasil / $limit);
// Amankan nilai page
$page = max($page, 1);
if ($page > $total_pages && $total_pages > 0) $page = $total_pages;

$offset = ($page - 1) * $limit;
$hasil_paginate = array_slice($hasil, $offset, $limit);

// Fungsi Bonus: Highlight Keyword
function highlight_word($text, $word) {
    if (empty($word)) return $text;
    // Menggunakan regex case-insensitive untuk me-replace dengan tag mark Bootstrap
    $pattern = "/(" . preg_quote($word, '/') . ")/i";
    return preg_replace($pattern, "<mark class='bg-warning p-0'>$1</mark>", $text);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Advanced - M. Rafi Risqiyanto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-4 mb-5">
        <!-- Identitas Mahasiswa -->
        <div class="alert alert-dark text-center shadow-sm">
            <strong>M. Rafi Risqiyanto | 60324001</strong> - Tugas 2 (Pertemuan 5) | BONUS APPLIED 🌟
        </div>

        <h2 class="mb-4"><i class="bi bi-search"></i> Advanced Book Search</h2>

        <!-- Tampilkan Error Validasi -->
        <?php if (count($errors) > 0): ?>
            <div class="alert alert-danger shadow-sm">
                <ul class="mb-0">
                    <?php foreach($errors as $err) echo "<li>$err</li>"; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Sidebar Kiri: Form Filter -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-funnel-fill"></i> Filter Pencarian</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="GET">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kata Kunci</label>
                                <input type="text" name="keyword" class="form-control" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Judul atau Pengarang...">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="kategori" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    <option value="Programming" <?php echo $kategori=='Programming'?'selected':''; ?>>Programming</option>
                                    <option value="Database" <?php echo $kategori=='Database'?'selected':''; ?>>Database</option>
                                    <option value="Web Design" <?php echo $kategori=='Web Design'?'selected':''; ?>>Web Design</option>
                                    <option value="Networking" <?php echo $kategori=='Networking'?'selected':''; ?>>Networking</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Range Harga (Rp)</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text">Min</span>
                                    <input type="number" name="min_harga" class="form-control" value="<?php echo htmlspecialchars($min_harga); ?>" min="0">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">Max</span>
                                    <input type="number" name="max_harga" class="form-control" value="<?php echo htmlspecialchars($max_harga); ?>" min="0">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tahun Terbit</label>
                                <input type="number" name="tahun" class="form-control" value="<?php echo htmlspecialchars($tahun); ?>" placeholder="Misal: 2023">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Ketersediaan Stok</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="s_semua" value="semua" <?php echo $status=='semua'?'checked':''; ?>>
                                        <label class="form-check-label" for="s_semua">Semua</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="s_ada" value="Tersedia" <?php echo $status=='Tersedia'?'checked':''; ?>>
                                        <label class="form-check-label" for="s_ada">Tersedia</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="s_habis" value="Habis" <?php echo $status=='Habis'?'checked':''; ?>>
                                        <label class="form-check-label" for="s_habis">Habis</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Urutkan Berdasarkan</label>
                                <select name="sort" class="form-select">
                                    <option value="judul" <?php echo $sort=='judul'?'selected':''; ?>>Judul (A-Z)</option>
                                    <option value="harga_murah" <?php echo $sort=='harga_murah'?'selected':''; ?>>Harga (Termurah)</option>
                                    <option value="harga_mahal" <?php echo $sort=='harga_mahal'?'selected':''; ?>>Harga (Termahal)</option>
                                    <option value="tahun_baru" <?php echo $sort=='tahun_baru'?'selected':''; ?>>Tahun (Terbaru)</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Terapkan Filter</button>
                                <a href="search_advanced.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise"></i> Reset Semua</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Fitur Bonus: Recent Searches -->
                <?php if(!empty($_SESSION['recent_searches'])): ?>
                <div class="card shadow-sm mt-3 border-secondary">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0"><i class="bi bi-clock-history"></i> Pencarian Terakhir (Bonus)</h6>
                    </div>
                    <ul class="list-group list-group-flush small">
                        <?php foreach($_SESSION['recent_searches'] as $history_url): 
                            // Decode query string jadi array untuk diambil keyword-nya
                            parse_str($history_url, $parsed_history);
                        ?>
                            <a href="search_advanced.php?<?php echo $history_url; ?>" class="list-group-item list-group-item-action text-primary">
                                <i class="bi bi-search"></i> "<?php echo htmlspecialchars($parsed_history['keyword'] ?? 'Tanpa Keyword'); ?>"
                            </a>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

            </div>

            <!-- Konten Kanan: Hasil Pencarian -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 text-success"><i class="bi bi-journal-text"></i> Ditemukan: <strong><?php echo $total_hasil; ?></strong> Buku</h5>
                    
                    <!-- Fitur Bonus: Export CSV -->
                    <?php if ($total_hasil > 0): ?>
                        <?php 
                        // Ambil query string saat ini, tambahkan parameter export=1
                        $current_query = $_GET;
                        $current_query['export'] = 1;
                        $export_link = '?' . http_build_query($current_query);
                        ?>
                        <a href="<?php echo $export_link; ?>" class="btn btn-success btn-sm shadow-sm">
                            <i class="bi bi-file-earmark-excel"></i> Export CSV (Bonus)
                        </a>
                    <?php endif; ?>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0 align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Judul & Pengarang</th>
                                        <th>Kategori</th>
                                        <th>Thn</th>
                                        <th>Harga</th>
                                        <th class="text-center">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($total_hasil > 0): ?>
                                        <?php foreach ($hasil_paginate as $buku): ?>
                                        <tr>
                                            <td><small class="text-muted"><?php echo $buku['kode']; ?></small></td>
                                            <td>
                                                <strong class="text-primary"><?php echo highlight_word($buku['judul'], $keyword); ?></strong><br>
                                                <small class="text-muted"><i class="bi bi-person"></i> <?php echo highlight_word($buku['pengarang'], $keyword); ?></small>
                                            </td>
                                            <td><span class="badge bg-secondary"><?php echo $buku['kategori']; ?></span></td>
                                            <td><?php echo $buku['tahun']; ?></td>
                                            <td>Rp <?php echo number_format($buku['harga'], 0, ',', '.'); ?></td>
                                            <td class="text-center">
                                                <?php if($buku['stok'] > 0): ?>
                                                    <span class="badge bg-success rounded-pill"><?php echo $buku['stok']; ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger rounded-pill">Habis</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="bi bi-emoji-frown fs-1"></i><br>
                                                Yahh, tidak ada buku yang cocok dengan filter Anda.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination Sederhana -->
                <?php if ($total_pages > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php 
                        for ($i = 1; $i <= $total_pages; $i++): 
                            $page_query = $_GET;
                            $page_query['page'] = $i;
                            $page_link = '?' . http_build_query($page_query);
                        ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="<?php echo $page_link; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                <?php endif; ?>

            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>