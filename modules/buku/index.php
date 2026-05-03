<?php
$page_title = "Data Buku Perpustakaan";
// Arahkan ke config dan includes dengan path relatif ../../
require_once '../../config/database.php';
require_once '../../includes/header.php';
 
// ========== SETUP PAGINATION ==========
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
 
// ========== SETUP SEARCH ==========
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';
 
// ========== BUILD QUERY BUKU ==========
if (!empty($search)) {
    // Jika user melakukan pencarian (Menggunakan Prepared Statement Mencegah SQL Injection)
    $query = "SELECT * FROM buku 
              WHERE judul LIKE ? OR pengarang LIKE ? OR kategori LIKE ?
              ORDER BY created_at DESC 
              LIMIT ? OFFSET ?";
    
    $search_param = "%$search%";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssii", $search_param, $search_param, $search_param, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Count total hasil pencarian untuk pagination
    $count_query = "SELECT COUNT(*) as total FROM buku 
                    WHERE judul LIKE ? OR pengarang LIKE ? OR kategori LIKE ?";
    $stmt_count = $conn->prepare($count_query);
    $stmt_count->bind_param("sss", $search_param, $search_param, $search_param);
    $stmt_count->execute();
    $total_rows = $stmt_count->get_result()->fetch_assoc()['total'];
    
} else {
    // Jika tidak ada pencarian (Tampilkan semua dengan limit)
    $query = "SELECT * FROM buku ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Count total semua buku di database
    $total_rows = $conn->query("SELECT COUNT(*) as total FROM buku")->fetch_assoc()['total'];
}
 
// Hitung total halaman (Dibulatkan ke atas)
$total_pages = ceil($total_rows / $limit);
?>
 
<div class="container">
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <h2 class="mb-0"><i class="bi bi-journals"></i> Data Koleksi Buku</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="create.php" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle-fill"></i> Tambah Buku Baru
            </a>
        </div>
    </div>
    
    <!-- Tampilkan Notifikasi Alert Jika Ada -->
    <?php
    if (isset($_GET['success'])) {
        echo '<div class="alert alert-success alert-dismissible fade show shadow-sm">';
        echo '<i class="bi bi-check-circle-fill"></i> <strong>Berhasil!</strong> ' . htmlspecialchars($_GET['success']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        echo '</div>';
    }
    
    if (isset($_GET['error'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show shadow-sm">';
        echo '<i class="bi bi-exclamation-triangle-fill"></i> <strong>Gagal!</strong> ' . htmlspecialchars($_GET['error']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        echo '</div>';
    }
    ?>
    
    <!-- Kotak Pencarian -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body bg-white rounded">
            <form method="GET" action="">
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white border-primary"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control border-primary" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Cari berdasarkan judul, pengarang, atau kategori...">
                    <button class="btn btn-primary px-4" type="submit">Cari Data</button>
                    <?php if (!empty($search)): ?>
                    <a href="index.php" class="btn btn-outline-secondary px-3">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Tabel Data Buku -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">
                <i class="bi bi-table"></i> Daftar Buku
            </h5>
            <?php if (!empty($search)): ?>
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                    Menampilkan pencarian: "<?php echo htmlspecialchars($search); ?>"
                </span>
            <?php endif; ?>
        </div>
        <div class="card-body p-0">
            <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th width="100">Kode</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th width="80" class="text-center">Thn</th>
                            <th width="120">Harga</th>
                            <th width="60" class="text-center">Stok</th>
                            <th width="150" class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = $offset + 1;
                        while ($row = $result->fetch_assoc()): 
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no++; ?></td>
                            <td><code><?php echo htmlspecialchars($row['kode_buku']); ?></code></td>
                            <td><strong><?php echo htmlspecialchars($row['judul']); ?></strong></td>
                            <td>
                                <span class="badge bg-primary rounded-pill px-3">
                                    <?php echo htmlspecialchars($row['kategori']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($row['pengarang']); ?></td>
                            <td><small class="text-muted"><?php echo htmlspecialchars($row['penerbit']); ?></small></td>
                            <td class="text-center"><?php echo $row['tahun_terbit']; ?></td>
                            <td class="text-success fw-bold">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <?php if ($row['stok'] > 0): ?>
                                    <span class="badge bg-success rounded-circle p-2"><?php echo $row['stok']; ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Habis</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="edit.php?id=<?php echo $row['id_buku']; ?>" class="btn btn-sm btn-warning shadow-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="delete.php?id=<?php echo $row['id_buku']; ?>" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('Peringatan: Anda yakin ingin menghapus buku \'<?php echo addslashes($row['judul']); ?>\' dari database secara permanen?')">
                                    <i class="bi bi-trash3-fill"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white border-top py-3">
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <nav aria-label="Navigasi Halaman">
                    <ul class="pagination justify-content-center mb-3">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo ($page - 1); ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">Sebelumnya</a>
                        </li>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo ($page + 1); ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">Berikutnya</a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
                
                <div class="text-center text-muted small">
                    <i class="bi bi-database"></i> 
                    Total Data: <strong><?php echo $total_rows; ?></strong> buku terdaftar 
                    | Halaman <strong><?php echo $page; ?></strong> dari <strong><?php echo max(1, $total_pages); ?></strong>
                </div>
            </div>
            
            <?php else: ?>
            <!-- Jika Data Kosong -->
            <div class="text-center py-5">
                <i class="bi bi-journal-x text-muted mb-3" style="font-size: 4rem; display: block;"></i>
                <h5 class="text-muted">Oops! Tidak Ditemukan Data</h5>
                <p class="text-muted mb-4">
                    <?php if (!empty($search)): ?>
                        Buku dengan kata kunci "<strong><?php echo htmlspecialchars($search); ?></strong>" tidak ada di sistem.
                    <?php else: ?>
                        Database perpustakaan masih kosong. Silakan tambahkan koleksi pertama Anda!
                    <?php endif; ?>
                </p>
                <?php if (empty($search)): ?>
                    <a href="create.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Buku Sekarang</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
 
<?php
// Bersihkan memory dan tutup koneksi
if (isset($stmt)) $stmt->close();
if (isset($stmt_count)) $stmt_count->close();
closeConnection();
require_once '../../includes/footer.php';
?>