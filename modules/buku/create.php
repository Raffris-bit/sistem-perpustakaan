<?php
$page_title = "Tambah Buku Baru - Perpustakaan";
require_once '../../config/database.php';
require_once '../../includes/header.php';
 
// Inisialisasi variabel untuk form dan error
$errors = [];
$kode_buku = '';
$judul = '';
$kategori = '';
$pengarang = '';
$penerbit = '';
$tahun = '';
$isbn = '';
$harga = '';
$stok = '';
$deskripsi = '';
 
// Proses eksekusi saat user klik tombol Simpan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Ambil dan sanitasi data (Hindari XSS)
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
    
    // 2. Validasi Server-Side
    if (empty($kode_buku)) {
        $errors[] = "Kode buku wajib diisi (Contoh: BK-001).";
    }
    if (empty($judul)) {
        $errors[] = "Judul buku wajib diisi.";
    } elseif (strlen($judul) < 3) {
        $errors[] = "Judul buku minimal harus 3 karakter.";
    }
    if (empty($kategori)) {
        $errors[] = "Silakan pilih kategori buku terlebih dahulu.";
    }
    if (empty($pengarang)) {
        $errors[] = "Nama pengarang wajib dicantumkan.";
    }
    if (empty($penerbit)) {
        $errors[] = "Nama penerbit wajib dicantumkan.";
    }
    if (empty($tahun) || $tahun < 1900 || $tahun > date('Y')) {
        $errors[] = "Tahun terbit tidak valid. Masukkan tahun antara 1900 hingga " . date('Y');
    }
    if ($harga < 0) {
        $errors[] = "Harga buku tidak boleh bernilai negatif.";
    }
    if ($stok < 0) {
        $errors[] = "Stok buku tidak boleh kurang dari 0.";
    }
    
    // 3. Pengecekan Kode Buku Duplikat di Database
    if (empty($errors)) {
        $stmt_cek = $conn->prepare("SELECT id_buku FROM buku WHERE kode_buku = ?");
        $stmt_cek->bind_param("s", $kode_buku);
        $stmt_cek->execute();
        $result_cek = $stmt_cek->get_result();
        
        if ($result_cek->num_rows > 0) {
            $errors[] = "Kode buku '{$kode_buku}' sudah terdaftar di sistem. Gunakan kode yang unik.";
        }
        $stmt_cek->close();
    }
    
    // 4. Proses Insert ke Database jika Valid
    if (count($errors) == 0) {
        // Gunakan Prepared Statement untuk mencegah SQL Injection
        $query_insert = "INSERT INTO buku (kode_buku, judul, kategori, pengarang, penerbit, tahun_terbit, isbn, harga, stok, deskripsi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query_insert);
        
        // s = string, i = integer, d = double/float
        $stmt->bind_param("sssssissis", 
            $kode_buku, $judul, $kategori, $pengarang, $penerbit, $tahun, $isbn, $harga, $stok, $deskripsi
        );
        
        if ($stmt->execute()) {
            $stmt->close();
            closeConnection();
            // Redirect ke halaman index dengan membawa parameter success
            header("Location: index.php?success=" . urlencode("Sistem sukses merekam buku baru: '$judul'"));
            exit();
        } else {
            $errors[] = "Gagal menyimpan ke database. Error: " . $stmt->error;
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
                <h3 class="mb-0">Form Registrasi Buku</h3>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-plus-circle-fill me-2"></i> Input Data Referensi Buku Baru</h5>
                </div>
                <div class="card-body p-4">
                    
                    <!-- Area Tampilan Error -->
                    <?php if (count($errors) > 0): ?>
                    <div class="alert alert-danger shadow-sm mb-4">
                        <h6 class="alert-heading fw-bold"><i class="bi bi-exclamation-triangle-fill"></i> Data Ditolak! Perhatikan kesalahan berikut:</h6>
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
                                <label for="kode_buku" class="form-label fw-bold">Kode Buku <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kode_buku" name="kode_buku" value="<?php echo htmlspecialchars($kode_buku); ?>" placeholder="Contoh: BK-001" required autofocus>
                            </div>
                            <div class="col-md-8">
                                <label for="judul" class="form-label fw-bold">Judul Buku <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($judul); ?>" placeholder="Tuliskan judul lengkap buku" required>
                            </div>

                            <div class="col-md-6">
                                <label for="kategori" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="kategori" name="kategori" required>
                                    <option value="">-- Tentukan Kategori --</option>
                                    <option value="Programming" <?php echo ($kategori == 'Programming') ? 'selected' : ''; ?>>Programming / Pemrograman</option>
                                    <option value="Database" <?php echo ($kategori == 'Database') ? 'selected' : ''; ?>>Database / Basis Data</option>
                                    <option value="Web Design" <?php echo ($kategori == 'Web Design') ? 'selected' : ''; ?>>Web Design / Desain UI</option>
                                    <option value="Networking" <?php echo ($kategori == 'Networking') ? 'selected' : ''; ?>>Networking / Jaringan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="isbn" class="form-label fw-bold">No. ISBN <small class="text-muted fw-normal">(Opsional)</small></label>
                                <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>" placeholder="Misal: 978-602-xxx">
                            </div>

                            <div class="col-md-6">
                                <label for="pengarang" class="form-label fw-bold">Nama Pengarang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?php echo htmlspecialchars($pengarang); ?>" placeholder="Pengarang utama" required>
                            </div>
                            <div class="col-md-6">
                                <label for="penerbit" class="form-label fw-bold">Penerbit <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo htmlspecialchars($penerbit); ?>" placeholder="Penerbit buku" required>
                            </div>

                            <div class="col-md-4">
                                <label for="tahun" class="form-label fw-bold">Tahun Terbit <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="tahun" name="tahun" value="<?php echo htmlspecialchars($tahun); ?>" min="1900" max="<?php echo date('Y'); ?>" placeholder="YYYY" required>
                            </div>
                            <div class="col-md-4">
                                <label for="harga" class="form-label fw-bold">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="harga" name="harga" value="<?php echo htmlspecialchars($harga); ?>" min="0" step="1000" placeholder="0" required>
                            </div>
                            <div class="col-md-4">
                                <label for="stok" class="form-label fw-bold">Stok Fisik <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="stok" name="stok" value="<?php echo htmlspecialchars($stok); ?>" min="0" placeholder="0" required>
                            </div>

                            <div class="col-12">
                                <label for="deskripsi" class="form-label fw-bold">Sinopsis / Deskripsi <small class="text-muted fw-normal">(Opsional)</small></label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Tuliskan gambaran singkat mengenai isi buku ini..."><?php echo htmlspecialchars($deskripsi); ?></textarea>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light border">Bersihkan Form</button>
                            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan Buku</button>
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