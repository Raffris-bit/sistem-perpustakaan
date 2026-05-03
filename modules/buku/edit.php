<?php
$page_title = "Edit Spesifikasi Buku";
require_once '../../config/database.php';
require_once '../../includes/header.php';
 
// Tangkap Parameter ID dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?error=Akses ditolak. ID buku tidak terdeteksi.");
    exit();
}
 
$id_buku = (int)$_GET['id'];
$errors = [];
 
// 1. TAHAP READ: Ambil data lama untuk disuntikkan ke dalam form
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $conn->prepare("SELECT * FROM buku WHERE id_buku = ?");
    $stmt->bind_param("i", $id_buku);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        $stmt->close();
        closeConnection();
        header("Location: index.php?error=Data buku tidak dapat ditemukan di database.");
        exit();
    }
    
    // Tarik datanya ke variabel
    $buku = $result->fetch_assoc();
    $stmt->close();
    
    $kode_buku = $buku['kode_buku'];
    $judul = $buku['judul'];
    $kategori = $buku['kategori'];
    $pengarang = $buku['pengarang'];
    $penerbit = $buku['penerbit'];
    $tahun = $buku['tahun_terbit'];
    $isbn = $buku['isbn'];
    $harga = $buku['harga'];
    $stok = $buku['stok'];
    $deskripsi = $buku['deskripsi'];
}
 
// 2. TAHAP UPDATE: Proses jika tombol Update ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_buku = sanitize($_POST['kode_buku']);
    $judul = sanitize($_POST['judul']);
    $kategori = sanitize($_POST['kategori']);
    $pengarang = sanitize($_POST['pengarang']);
    $penerbit = sanitize($_POST['penerbit']);
    $tahun = (int)$_POST['tahun'];
    $isbn = sanitize($_POST['isbn']);
    $harga = (float)$_POST['harga'];
    $stok = (int)$_POST['stok'];
    $deskripsi = sanitize($_POST['deskripsi']);
    
    // Validasi
    if (empty($kode_buku)) $errors[] = "Kode buku tidak boleh kosong.";
    if (empty($judul)) $errors[] = "Judul buku tidak boleh kosong.";
    elseif (strlen($judul) < 3) $errors[] = "Judul minimal 3 karakter.";
    if (empty($kategori)) $errors[] = "Kategori harus dipilih.";
    if (empty($pengarang)) $errors[] = "Pengarang wajib diisi.";
    if (empty($penerbit)) $errors[] = "Penerbit wajib diisi.";
    if (empty($tahun) || $tahun < 1900 || $tahun > date('Y')) $errors[] = "Tahun terbit tidak logis.";
    if ($harga < 0) $errors[] = "Harga minimal Rp 0.";
    if ($stok < 0) $errors[] = "Stok tidak boleh minus.";
    
    // Pengecekan Kode Buku Duplikat (Memastikan kodenya tidak menabrak buku lain)
    if (empty($errors)) {
        $stmt_cek = $conn->prepare("SELECT id_buku FROM buku WHERE kode_buku = ? AND id_buku != ?");
        $stmt_cek->bind_param("si", $kode_buku, $id_buku);
        $stmt_cek->execute();
        $res_cek = $stmt_cek->get_result();
        
        if ($res_cek->num_rows > 0) {
            $errors[] = "Kode buku '$kode_buku' telah dipakai oleh buku lain. Mohon gunakan kode lain.";
        }
        $stmt_cek->close();
    }
    
    // Jika aman, lakukan UPDATE SQL
    if (count($errors) == 0) {
        $query_update = "UPDATE buku SET kode_buku = ?, judul = ?, kategori = ?, pengarang = ?, penerbit = ?, tahun_terbit = ?, isbn = ?, harga = ?, stok = ?, deskripsi = ? WHERE id_buku = ?";
        $stmt = $conn->prepare($query_update);
        
        $stmt->bind_param("sssssissisi", 
            $kode_buku, $judul, $kategori, $pengarang, $penerbit, $tahun, $isbn, $harga, $stok, $deskripsi, $id_buku
        );
        
        if ($stmt->execute()) {
            $stmt->close();
            closeConnection();
            header("Location: index.php?success=" . urlencode("Pembaruan spesifikasi buku '$judul' berhasil dilakukan."));
            exit();
        } else {
            $errors[] = "Server Database Gagal Merespon: " . $stmt->error;
        }
        
        if(isset($stmt)) $stmt->close();
    }
}
?>
 
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="index.php" class="btn btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i> Kembali</a>
                <h3 class="mb-0">Revisi Data Buku</h3>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Form Update Data: <strong><?php echo htmlspecialchars($judul); ?></strong></h5>
                </div>
                <div class="card-body p-4">
                    
                    <?php if (count($errors) > 0): ?>
                    <div class="alert alert-danger shadow-sm mb-4">
                        <h6 class="alert-heading fw-bold"><i class="bi bi-exclamation-octagon"></i> Update Digagalkan:</h6>
                        <hr>
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Kode Buku <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="kode_buku" value="<?php echo htmlspecialchars($kode_buku); ?>" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Judul Buku <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="judul" value="<?php echo htmlspecialchars($judul); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" name="kategori" required>
                                    <option value="Programming" <?php echo ($kategori == 'Programming') ? 'selected' : ''; ?>>Programming</option>
                                    <option value="Database" <?php echo ($kategori == 'Database') ? 'selected' : ''; ?>>Database</option>
                                    <option value="Web Design" <?php echo ($kategori == 'Web Design') ? 'selected' : ''; ?>>Web Design</option>
                                    <option value="Networking" <?php echo ($kategori == 'Networking') ? 'selected' : ''; ?>>Networking</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">No. ISBN</label>
                                <input type="text" class="form-control" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Pengarang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="pengarang" value="<?php echo htmlspecialchars($pengarang); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Penerbit <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="penerbit" value="<?php echo htmlspecialchars($penerbit); ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Tahun Terbit <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="tahun" value="<?php echo htmlspecialchars($tahun); ?>" min="1900" max="<?php echo date('Y'); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="harga" value="<?php echo htmlspecialchars($harga); ?>" min="0" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Stok Update <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="stok" value="<?php echo htmlspecialchars($stok); ?>" min="0" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Deskripsi Tambahan</label>
                                <textarea class="form-control" name="deskripsi" rows="3"><?php echo htmlspecialchars($deskripsi); ?></textarea>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning px-4 fw-bold"><i class="bi bi-save2 me-1"></i> Terapkan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 
<?php
closeConnection();
require_once '../../includes/footer.php';
?>