<?php
// ========== FITUR BONUS: EXPORT EXCEL (Harus paling atas) ==========
if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    require_once '../../config/database.php';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=Data_Anggota.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['No', 'Kode Anggota', 'Nama', 'Email', 'Telepon', 'Alamat', 'Jenis Kelamin', 'Umur', 'Pekerjaan', 'Tanggal Daftar', 'Status']);
    
    $query_export = "SELECT * FROM anggota ORDER BY nama ASC";
    $res_export = $conn->query($query_export);
    $no_exp = 1;
    while ($row = $res_export->fetch_assoc()) {
        $umur = date_diff(date_create($row['tanggal_lahir']), date_create('today'))->y;
        fputcsv($output, [
            $no_exp++, $row['kode_anggota'], $row['nama'], $row['email'], $row['telepon'], 
            $row['alamat'], $row['jenis_kelamin'], $umur . ' Tahun', $row['pekerjaan'], 
            date('d-m-Y', strtotime($row['tanggal_daftar'])), $row['status']
        ]);
    }
    fclose($output);
    exit();
}

$page_title = "Data Anggota Perpustakaan";
require_once '../../config/database.php';
require_once '../../includes/header.php';

// ========== SETUP PAGINATION & FILTER ==========
$limit = 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';
$f_status = isset($_GET['f_status']) ? sanitize($_GET['f_status']) : '';
$f_jk = isset($_GET['f_jk']) ? sanitize($_GET['f_jk']) : '';

$where_clauses = [];
$params = [];
$types = "";

if (!empty($search)) {
    $where_clauses[] = "(nama LIKE ? OR email LIKE ? OR telepon LIKE ?)";
    $search_param = "%$search%";
    array_push($params, $search_param, $search_param, $search_param);
    $types .= "sss";
}
if (!empty($f_status)) {
    $where_clauses[] = "status = ?";
    $params[] = $f_status;
    $types .= "s";
}
if (!empty($f_jk)) {
    $where_clauses[] = "jenis_kelamin = ?";
    $params[] = $f_jk;
    $types .= "s";
}

$where_sql = count($where_clauses) > 0 ? "WHERE " . implode(" AND ", $where_clauses) : "";

$count_query = "SELECT COUNT(*) as total FROM anggota $where_sql";
$stmt_count = $conn->prepare($count_query);
if (!empty($params)) { $stmt_count->bind_param($types, ...$params); }
$stmt_count->execute();
$total_rows = $stmt_count->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

$query = "SELECT * FROM anggota $where_sql ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($query);
$params[] = $limit; $params[] = $offset; $types .= "ii";
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Statistik Dashboard
$stat_total = $conn->query("SELECT COUNT(*) as c FROM anggota")->fetch_assoc()['c'];
$stat_aktif = $conn->query("SELECT COUNT(*) as c FROM anggota WHERE status='Aktif'")->fetch_assoc()['c'];
$stat_nonaktif = $conn->query("SELECT COUNT(*) as c FROM anggota WHERE status='Nonaktif'")->fetch_assoc()['c'];
?>

<div class="container mb-5">
    <div class="alert alert-dark text-center shadow-sm mb-4">
        <strong>M. Rafi Risqiyanto | 60324001</strong> - Tugas CRUD Anggota (Full Bonus)
    </div>

    <!-- Dashboard Statistik -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-primary shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted"><i class="bi bi-people"></i> Total Anggota</h6>
                    <h2 class="text-primary mb-0"><?php echo $stat_total; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted"><i class="bi bi-person-check"></i> Aktif</h6>
                    <h2 class="text-success mb-0"><?php echo $stat_aktif; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted"><i class="bi bi-person-dash"></i> Non-Aktif</h6>
                    <h2 class="text-danger mb-0"><?php echo $stat_nonaktif; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0"><i class="bi bi-person-vcard"></i> Kelola Data Anggota</h3>
        <div>
            <a href="?export=excel" class="btn btn-success shadow-sm me-2"><i class="bi bi-file-earmark-excel"></i> Export Excel</a>
            <a href="create.php" class="btn btn-primary shadow-sm"><i class="bi bi-plus-circle-fill"></i> Tambah Anggota</a>
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="bi bi-check-circle-fill"></i> <?php echo htmlspecialchars($_GET['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Filter & Pencarian -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body bg-white rounded">
            <form method="GET" action="" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Cari nama, email, telepon...">
                </div>
                <div class="col-md-3">
                    <select name="f_status" class="form-select">
                        <option value="">-- Filter Status --</option>
                        <option value="Aktif" <?php echo ($f_status == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                        <option value="Nonaktif" <?php echo ($f_status == 'Nonaktif') ? 'selected' : ''; ?>>Non-Aktif</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="f_jk" class="form-select">
                        <option value="">-- Filter Kelamin --</option>
                        <option value="Laki-laki" <?php echo ($f_jk == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="Perempuan" <?php echo ($f_jk == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Cari</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data Anggota -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Foto</th>
                            <th>Kode</th>
                            <th>Info Anggota</th>
                            <th>Kontak</th>
                            <th class="text-center">Gender</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php $no = $offset + 1; while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td>
                                    <?php if(!empty($row['foto']) && file_exists('uploads/'.$row['foto'])): ?>
                                        <img src="uploads/<?php echo $row['foto']; ?>" alt="Foto" class="rounded-circle object-fit-cover" width="50" height="50">
                                    <?php else: ?>
                                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="bi bi-person-fill fs-4"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><code><?php echo htmlspecialchars($row['kode_anggota']); ?></code></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($row['nama']); ?></strong><br>
                                    <small class="text-muted"><i class="bi bi-briefcase"></i> <?php echo htmlspecialchars($row['pekerjaan']); ?></small>
                                </td>
                                <td>
                                    <small><i class="bi bi-envelope"></i> <?php echo htmlspecialchars($row['email']); ?><br>
                                    <i class="bi bi-telephone"></i> <?php echo htmlspecialchars($row['telepon']); ?></small>
                                </td>
                                <td class="text-center">
                                    <?php if($row['jenis_kelamin'] == 'Laki-laki'): ?>
                                        <span class="badge bg-info text-dark">L</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">P</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['status'] == 'Aktif'): ?>
                                        <span class="badge bg-success rounded-pill px-3">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary rounded-pill px-3">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?php echo $row['id_anggota']; ?>" class="btn btn-sm btn-warning shadow-sm"><i class="bi bi-pencil-square"></i></a>
                                    <a href="delete.php?id=<?php echo $row['id_anggota']; ?>" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('Hapus anggota ini permanen?')"><i class="bi bi-trash3-fill"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada data.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <div class="card-footer bg-white pt-3 pb-0 border-top">
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php 
                        $query_string = "";
                        if(!empty($search)) $query_string .= "&search=".urlencode($search);
                        if(!empty($f_status)) $query_string .= "&f_status=".urlencode($f_status);
                        if(!empty($f_jk)) $query_string .= "&f_jk=".urlencode($f_jk);
                        ?>
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo ($page - 1) . $query_string; ?>">Sebelumnya</a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i . $query_string; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo ($page + 1) . $query_string; ?>">Berikutnya</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
if(isset($stmt)) $stmt->close();
if(isset($stmt_count)) $stmt_count->close();
closeConnection();
require_once '../../includes/footer.php';
?>