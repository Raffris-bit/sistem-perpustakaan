<?php
$page_title = "Tambah Anggota - Perpustakaan";
require_once '../../config/database.php';
require_once '../../includes/header.php';

$errors = [];
$kode = ''; $nama = ''; $email = ''; $telepon = ''; $alamat = '';
$jk = ''; $tgl_lahir = ''; $pekerjaan = '';
$tgl_daftar = date('Y-m-d'); // Default hari ini

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = sanitize($_POST['kode_anggota']);
    $nama = sanitize($_POST['nama']);
    $email = sanitize($_POST['email']);
    $telepon = sanitize($_POST['telepon']);
    $alamat = sanitize($_POST['alamat']);
    $jk = sanitize($_POST['jenis_kelamin']);
    $tgl_lahir = sanitize($_POST['tanggal_lahir']);
    $pekerjaan = sanitize($_POST['pekerjaan']);
    
    // Validasi Required
    if(empty($kode)) $errors['kode'] = "Kode anggota wajib diisi.";
    if(empty($nama)) $errors['nama'] = "Nama wajib diisi.";
    if(empty($jk)) $errors['jk'] = "Pilih jenis kelamin.";
    if(empty($pekerjaan)) $errors['pekerjaan'] = "Pilih pekerjaan.";
    if(empty($alamat) || strlen($alamat) < 10) $errors['alamat'] = "Alamat minimal 10 karakter.";
    
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Format email tidak valid.";
    }
    
    if(empty($telepon) || !preg_match('/^08\d{8,11}$/', $telepon)) {
        $errors['telepon'] = "Format telp: 08xxxxxxxxxx (10-13 digit).";
    }
    
    if(empty($tgl_lahir)) {
        $errors['tgl_lahir'] = "Tanggal lahir wajib diisi.";
    } else {
        $umur = date_diff(date_create($tgl_lahir), date_create('today'))->y;
        if($umur < 10) $errors['tgl_lahir'] = "Umur minimal 10 tahun.";
    }
    
    if(empty($errors)) {
        $q_cek = $conn->prepare("SELECT id_anggota FROM anggota WHERE kode_anggota = ? OR email = ?");
        $q_cek->bind_param("ss", $kode, $email);
        $q_cek->execute();
        if($q_cek->get_result()->num_rows > 0) $errors['general'] = "Kode Anggota atau Email sudah terdaftar.";
        $q_cek->close();
    }
    
    // Upload Foto
    $nama_foto = null;
    if(empty($errors) && isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])) {
            $nama_foto = time() . '_' . rand(100,999) . '.' . $ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/' . $nama_foto);
        } else {
            $errors['foto'] = "Format foto harus JPG/PNG.";
        }
    }
    
    // Insert ke Database
    if(empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO anggota (kode_anggota, nama, email, telepon, alamat, tanggal_lahir, jenis_kelamin, pekerjaan, tanggal_daftar, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $kode, $nama, $email, $telepon, $alamat, $tgl_lahir, $jk, $pekerjaan, $tgl_daftar, $nama_foto);
        
        if($stmt->execute()) {
            header("Location: index.php?success=" . urlencode("Anggota berhasil ditambahkan!"));
            exit();
        } else {
            $errors['general'] = "Error DB: " . $stmt->error;
        }
    }
}
?>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-person-plus-fill"></i> Tambah Anggota</h5>
                </div>
                <div class="card-body p-4">
                    <?php if(isset($errors['general'])): ?>
                        <div class="alert alert-danger shadow-sm"><?php echo $errors['general']; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Kode Anggota</label>
                                <input type="text" name="kode_anggota" class="form-control <?php echo isset($errors['kode'])?'is-invalid':''; ?>" value="<?php echo htmlspecialchars($kode); ?>">
                                <?php if(isset($errors['kode'])) echo "<div class='invalid-feedback'>{$errors['kode']}</div>"; ?>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control <?php echo isset($errors['nama'])?'is-invalid':''; ?>" value="<?php echo htmlspecialchars($nama); ?>">
                                <?php if(isset($errors['nama'])) echo "<div class='invalid-feedback'>{$errors['nama']}</div>"; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control <?php echo isset($errors['email'])?'is-invalid':''; ?>" value="<?php echo htmlspecialchars($email); ?>">
                                <?php if(isset($errors['email'])) echo "<div class='invalid-feedback'>{$errors['email']}</div>"; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="telepon" class="form-control <?php echo isset($errors['telepon'])?'is-invalid':''; ?>" value="<?php echo htmlspecialchars($telepon); ?>" placeholder="08xxxxxxxxxx">
                                <?php if(isset($errors['telepon'])) echo "<div class='invalid-feedback'>{$errors['telepon']}</div>"; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control <?php echo isset($errors['tgl_lahir'])?'is-invalid':''; ?>" value="<?php echo htmlspecialchars($tgl_lahir); ?>">
                                <?php if(isset($errors['tgl_lahir'])) echo "<div class='invalid-feedback'>{$errors['tgl_lahir']}</div>"; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select <?php echo isset($errors['jk'])?'is-invalid':''; ?>">
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki" <?php echo ($jk=='Laki-laki')?'selected':''; ?>>Laki-laki</option>
                                    <option value="Perempuan" <?php echo ($jk=='Perempuan')?'selected':''; ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="alamat" rows="2" class="form-control <?php echo isset($errors['alamat'])?'is-invalid':''; ?>"><?php echo htmlspecialchars($alamat); ?></textarea>
                                <?php if(isset($errors['alamat'])) echo "<div class='invalid-feedback'>{$errors['alamat']}</div>"; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pekerjaan</label>
                                <select name="pekerjaan" class="form-select <?php echo isset($errors['pekerjaan'])?'is-invalid':''; ?>">
                                    <option value="">-- Pilih --</option>
                                    <option value="Pelajar" <?php echo ($pekerjaan=='Pelajar')?'selected':''; ?>>Pelajar</option>
                                    <option value="Mahasiswa" <?php echo ($pekerjaan=='Mahasiswa')?'selected':''; ?>>Mahasiswa</option>
                                    <option value="Pegawai" <?php echo ($pekerjaan=='Pegawai')?'selected':''; ?>>Pegawai</option>
                                    <option value="Lainnya" <?php echo ($pekerjaan=='Lainnya')?'selected':''; ?>>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Upload Foto (Opsional)</label>
                                <input type="file" name="foto" class="form-control <?php echo isset($errors['foto'])?'is-invalid':''; ?>" accept=".jpg,.jpeg,.png">
                                <?php if(isset($errors['foto'])) echo "<div class='invalid-feedback'>{$errors['foto']}</div>"; ?>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Data</button>
                        <a href="index.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php closeConnection(); require_once '../../includes/footer.php'; ?>