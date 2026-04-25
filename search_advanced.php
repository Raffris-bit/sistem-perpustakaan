<?php
// Sabuk pengaman biar session nggak error kalau ada spasi tak sengaja
ob_start(); 
session_start();

// ========== 1. DATA BUKU (Minimal 10) ==========
$buku_list = [
    ["kode" => "BK-001", "judul" => "Pemrograman PHP Pemula", "kategori" => "Programming", "pengarang" => "Budi Raharjo", "penerbit" => "Informatika", "tahun" => 2021, "harga" => 75000, "stok" => 10],
    ["kode" => "BK-002", "judul" => "Mastering MySQL", "kategori" => "Database", "pengarang" => "Andi Nugroho", "penerbit" => "Graha Ilmu", "tahun" => 2022, "harga" => 95000, "stok" => 5],
    ["kode" => "BK-003", "judul" => "Laravel Advanced", "kategori" => "Programming", "pengarang" => "Siti Aminah", "penerbit" => "Informatika", "tahun" => 2024, "harga" => 125000, "stok" => 8],
    ["kode" => "BK-004", "judul" => "Web Design UI/UX", "kategori" => "Web Design", "pengarang" => "Dedi Santoso", "penerbit" => "Andi", "tahun" => 2023, "harga" => 85000, "stok" => 15],
    ["kode" => "BK-005", "judul" => "Network Security", "kategori" => "Networking", "pengarang" => "Rina Wijaya", "penerbit" => "Erlangga", "tahun" => 2023, "harga" => 110000, "stok" => 3],
    ["kode" => "BK-006", "judul" => "PHP Frameworks", "kategori" => "Programming", "pengarang" => "Budi Raharjo", "penerbit" => "Informatika", "tahun" => 2024, "harga" => 90000, "stok" => 0],
    ["kode" => "BK-007", "judul" => "PostgreSQL Expert", "kategori" => "Database", "pengarang" => "Ahmad Yani", "penerbit" => "Graha Ilmu", "tahun" => 2024, "harga" => 115000, "stok" => 7],
    ["kode" => "BK-008", "judul" => "JavaScript React", "kategori" => "Programming", "pengarang" => "Siti Aminah", "penerbit" => "Informatika", "tahun" => 2023, "harga" => 80000, "stok" => 0],
    ["kode" => "BK-009", "judul" => "HTML5 & CSS3", "kategori" => "Web Design", "pengarang" => "Dedi Santoso", "penerbit" => "Andi", "tahun" => 2021, "harga" => 65000, "stok" => 20],
    ["kode" => "BK-010", "judul" => "Cisco CCNA Guide", "kategori" => "Networking", "pengarang" => "Rina Wijaya", "penerbit" => "Erlangga", "tahun" => 2022, "harga" => 150000, "stok" => 2],
    ["kode" => "BK-011", "judul" => "Python for Data Science", "kategori" => "Programming", "pengarang" => "Budi Raharjo", "penerbit" => "Informatika", "tahun" => 2023, "harga" => 135000, "stok" => 12],
    ["kode" => "BK-012", "judul" => "MongoDB Admin", "kategori" => "Database", "pengarang" => "Ahmad Yani", "penerbit" => "Graha Ilmu", "tahun" => 2021, "harga" => 95000, "stok" => 4],
    ["kode" => "BK-013", "judul" => "Vue.js Mastery", "kategori" => "Programming", "pengarang" => "Siti Aminah", "penerbit" => "Informatika", "tahun" => 2024, "harga" => 105000, "stok" => 9],
    ["kode" => "BK-014", "judul" => "Figma for Beginners", "kategori" => "Web Design", "pengarang" => "Dedi Santoso", "penerbit" => "Andi", "tahun" => 2022, "harga" => 75000, "stok" => 0],
    ["kode" => "BK-015", "judul" => "Ethical Hacking", "kategori" => "Networking", "pengarang" => "Rina Wijaya", "penerbit" => "Erlangga", "tahun" => 2024, "harga" => 160000, "stok" => 6]
];
 
// ========== 2. AMBIL PARAMETER DARI URL (GET) ==========
$keyword = $_GET['keyword'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$min_harga = $_GET['min_harga'] ?? '';
$max_harga = $_GET['max_harga'] ?? '';
$tahun = $_GET['tahun'] ?? '';
$status = $_GET['status'] ?? 'semua';
$sort = $_GET['sort'] ?? 'judul';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Paksa jadi angka biar aman

// Bonus: Simpan Recent Searches
if (!empty(trim($keyword))) {
    if (!isset($_SESSION['recent_searches'])) { $_SESSION['recent_searches'] = []; }
    if (!in_array(trim($keyword), $_SESSION['recent_searches'])) {
        array_unshift($_SESSION['recent_searches'], trim($keyword));
        if (count($_SESSION['recent_searches']) > 5) { array_pop($_SESSION['recent_searches']); }
    }
}
 
// ========== 3. VALIDASI INPUT ==========
$errors = [];
if (!empty($min_harga) && !empty($max_harga)) {
    if ($min_harga > $max_harga) {
        $errors[] = "Harga minimum tidak boleh lebih besar dari harga maksimum.";
    }
}
if (!empty($tahun)) {
    if ($tahun < 1900 || $tahun > date('Y')) {
        $errors[] = "Tahun harus di antara 1900 - " . date('Y');
    }
}

// ========== 4. MESIN FILTERING ==========
$hasil = [];
if (count($errors) == 0) {
    foreach ($buku_list as $buku) {
        $match = true;

        if (!empty($keyword)) {
            if (stripos($buku['judul'], $keyword) === false && stripos($buku['pengarang'], $keyword) === false) {
                $match = false;
            }
        }
        if (!empty($kategori) && $buku['kategori'] != $kategori) { $match = false; }
        if (!empty($tahun) && $buku['tahun'] != $tahun) { $match = false; }
        if (!empty($min_harga) && $buku['harga'] < $min_harga) { $match = false; }
        if (!empty($max_harga) && $buku['harga'] > $max_harga) { $match = false; }
        if ($status == 'tersedia' && $buku['stok'] <= 0) { $match = false; }
        if ($status == 'habis' && $buku['stok'] > 0) { $match = false; }

        if ($match) { $hasil[] = $buku; }
    }
}

// ========== 5. MESIN SORTING (Versi Aman) ==========
usort($hasil, function($a, $b) use ($sort) {
    if ($sort == 'harga_rendah') return $a['harga'] - $b['harga'];
    if ($sort == 'harga_tinggi') return $b['harga'] - $a['harga'];
    if ($sort == 'tahun_baru') return $b['tahun'] - $a['tahun'];
    if ($sort == 'tahun_lama') return $a['tahun'] - $b['tahun'];
    return strcmp($a['judul'], $b['judul']);
});

// ========== 6. BONUS: MESIN EXPORT KE CSV ==========
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=laporan_pencarian_buku.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Kode', 'Judul', 'Kategori', 'Pengarang', 'Penerbit', 'Tahun', 'Harga', 'Stok']);
    foreach ($hasil as $row) {
        fputcsv($output, [$row['kode'], $row['judul'], $row['kategori'], $row['pengarang'], $row['penerbit'], $row['tahun'], $row['harga'], $row['stok']]);
    }
    fclose($output);
    exit;
}

// ========== 7. MESIN PAGINATION (Pembagian Halaman Aman) ==========
$per_page = 10;
$total_data = count($hasil);
$total_page = ($total_data > 0) ? ceil($total_data / $per_page) : 1; 
$page = max(1, min($page, $total_page)); 
$offset = ($page - 1) * $per_page;
$hasil_page = array_slice($hasil, $offset, $per_page);

// BONUS: Function Highlight Kuning (Dilindungi agar tidak error bentrok)
if (!function_exists('highlight_keyword')) {
    function highlight_keyword($text, $word) {
        if (empty($word)) return $text;
        return preg_replace('/(' . preg_quote($word, '/') . ')/i', '<mark class="bg-warning p-0">$1</mark>', $text);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Advanced - Rafi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="alert alert-dark shadow-sm">
            <strong>Mahasiswa:</strong> M. Rafi Risqiyanto | <strong>NIM:</strong> 60324001
        </div>

        <h2 class="mb-4 fw-bold"><i class="bi bi-search"></i> Pencarian Buku Lanjutan (Advanced)</h2>

        <?php if(count($errors) > 0): ?>
            <div class="alert alert-danger">
                <?php foreach($errors as $e) echo "<li>$e</li>"; ?>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white fw-bold"><i class="bi bi-funnel-fill"></i> Panel Filter</div>
            <div class="card-body">
                <form method="GET" action="">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Kata Kunci</label>
                            <input type="text" name="keyword" class="form-control" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Judul/Pengarang">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="">Semua Kategori</option>
                                <option value="Programming" <?php if($kategori=='Programming') echo 'selected'; ?>>Programming</option>
                                <option value="Database" <?php if($kategori=='Database') echo 'selected'; ?>>Database</option>
                                <option value="Web Design" <?php if($kategori=='Web Design') echo 'selected'; ?>>Web Design</option>
                                <option value="Networking" <?php if($kategori=='Networking') echo 'selected'; ?>>Networking</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Tahun Terbit</label>
                            <input type="number" name="tahun" class="form-control" value="<?php echo htmlspecialchars($tahun); ?>" placeholder="Contoh: 2023">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Harga Minimum</label>
                            <input type="number" name="min_harga" class="form-control" value="<?php echo htmlspecialchars($min_harga); ?>" placeholder="0">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Harga Maksimum</label>
                            <input type="number" name="max_harga" class="form-control" value="<?php echo htmlspecialchars($max_harga); ?>" placeholder="Tanpa batas">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Urutkan (Sort)</label>
                            <select name="sort" class="form-select">
                                <option value="judul" <?php if($sort=='judul') echo 'selected'; ?>>Judul (A - Z)</option>
                                <option value="harga_rendah" <?php if($sort=='harga_rendah') echo 'selected'; ?>>Harga (Termurah)</option>
                                <option value="harga_tinggi" <?php if($sort=='harga_tinggi') echo 'selected'; ?>>Harga (Termahal)</option>
                                <option value="tahun_baru" <?php if($sort=='tahun_baru') echo 'selected'; ?>>Tahun (Terbaru)</option>
                                <option value="tahun_lama" <?php if($sort=='tahun_lama') echo 'selected'; ?>>Tahun (Terlama)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row align-items-center mt-2">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold d-block">Status Stok</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="semua" id="stat1" <?php if($status=='semua') echo 'checked'; ?>>
                                <label class="form-check-label" for="stat1">Semua</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="tersedia" id="stat2" <?php if($status=='tersedia') echo 'checked'; ?>>
                                <label class="form-check-label" for="stat2">Tersedia (>0)</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="habis" id="stat3" <?php if($status=='habis') echo 'checked'; ?>>
                                <label class="form-check-label" for="stat3">Habis (0)</label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3 text-end">
                            <a href="search_advanced.php" class="btn btn-outline-secondary me-2"><i class="bi bi-arrow-clockwise"></i> Reset</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold"><i class="bi bi-search"></i> Cari</button>
                            
                            <?php 
                                $query_string = $_SERVER['QUERY_STRING']; 
                                // Bersihkan parameter export=csv jika sudah ada agar tidak numpuk
                                $query_string = preg_replace('/&?export=csv/i', '', $query_string);
                                $csv_link = $query_string ? "?$query_string&export=csv" : "?export=csv";
                            ?>
                            <a href="<?php echo $csv_link; ?>" class="btn btn-success ms-2"><i class="bi bi-file-earmark-excel"></i> Export CSV</a>
                        </div>
                    </div>
                </form>

                <?php if(isset($_SESSION['recent_searches']) && count($_SESSION['recent_searches']) > 0): ?>
                    <hr>
                    <small class="text-muted"><i class="bi bi-clock-history"></i> Pencarian terakhir: 
                        <?php foreach($_SESSION['recent_searches'] as $rs): ?>
                            <a href="?keyword=<?php echo urlencode($rs); ?>" class="badge bg-light text-dark text-decoration-none border border-secondary"><?php echo htmlspecialchars($rs); ?></a>
                        <?php endforeach; ?>
                    </small>
                <?php endif; ?>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <span class="fw-bold"><i class="bi bi-list-task"></i> Hasil Pencarian</span>
                <span class="badge bg-light text-dark fs-6"><?php echo $total_data; ?> Buku Ditemukan</span>
            </div>
            <div class="card-body p-0">
                <?php if($total_data > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-secondary">
                            <tr><th>Kode</th><th>Judul Buku</th><th>Kategori</th><th>Pengarang</th><th>Tahun</th><th>Harga</th><th>Stok</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach($hasil_page as $row): 
                                $badge_stok = ($row['stok'] > 0) ? "success" : "danger";
                                $teks_stok = ($row['stok'] > 0) ? "Tersedia" : "Habis";
                            ?>
                            <tr>
                                <td><code><?php echo $row['kode']; ?></code></td>
                                <td><strong><?php echo highlight_keyword($row['judul'], $keyword); ?></strong><br><small class="text-muted"><?php echo $row['penerbit']; ?></small></td>
                                <td><span class="badge bg-secondary"><?php echo $row['kategori']; ?></span></td>
                                <td><?php echo highlight_keyword($row['pengarang'], $keyword); ?></td>
                                <td><?php echo $row['tahun']; ?></td>
                                <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                <td class="text-center fw-bold"><?php echo $row['stok']; ?></td>
                                <td><span class="badge bg-<?php echo $badge_stok; ?>"><?php echo $teks_stok; ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if($total_page > 1): ?>
                <div class="d-flex justify-content-center mt-4 mb-3">
                    <nav>
                        <ul class="pagination">
                            <?php 
                            $base_url = 'search_advanced.php?';
                            $get_params = $_GET;
                            unset($get_params['page']); 
                            $query = http_build_query($get_params);
                            $query = $query ? $query . '&' : '';

                            for($i=1; $i<=$total_page; $i++): 
                                $active = ($page == $i) ? 'active' : '';
                            ?>
                            <li class="page-item <?php echo $active; ?>">
                                <a class="page-link" href="<?php echo $base_url . $query . 'page=' . $i; ?>"><?php echo $i; ?></a>
                            </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>

                <?php else: ?>
                <div class="p-5 text-center">
                    <i class="bi bi-emoji-frown text-muted" style="font-size: 3rem;"></i>
                    <h5 class="text-muted mt-3">Maaf, buku tidak ditemukan!</h5>
                    <p class="text-muted mb-0">Coba ubah kata kunci atau longgarkan filter pencarian.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>