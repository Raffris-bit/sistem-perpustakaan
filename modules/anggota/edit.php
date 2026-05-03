<?php
$page_title = "Edit Anggota - Perpustakaan";
require_once '../../config/database.php';
require_once '../../includes/header.php';

if (!isset($_GET['id'])) { header("Location: index.php"); exit(); }
$id_anggota = (int)$_GET['id'];

// Ambil data lama
$stmt = $conn->prepare("SELECT * FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id_anggota);
$stmt->execute();
$res = $stmt->get_result();
if($res->num_rows == 0) { header("Location: index.php"); exit(); }
$agt = $res->fetch_assoc();
$stmt->close();

$errors = [];
$kode = $agt['kode_anggota']; $nama = $agt['nama']; $email = $agt['email']; 
$telepon = $agt['telepon']; $alamat = $agt['alamat']; $jk = $agt['jenis_kelamin']; 
$tgl_lahir = $agt['tanggal_lahir']; $pekerjaan = $agt['pekerjaan']; $status = $agt['status'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = sanitize($_POST['kode_anggota']);
    $nama = sanitize($_POST['nama']);
    $email = sanitize($_POST['email']);
    $telepon = sanitize($_POST['telepon']);
    $alamat = sanitize($_POST['alamat']);
    $jk = sanitize($_POST['jenis_kelamin']);
    $tgl_lahir = sanitize($_POST['tanggal_lahir']);
    $pekerjaan = sanitize($_POST['pekerjaan']);
    $status = sanitize($_POST['status']);
    
    // Validasi
    if(empty($kode)) $errors['kode'] = "Kode anggota wajib diisi.";
    if(empty($nama)) $errors['nama'] = "Nama wajib diisi.";
    if(empty($jk)) $errors['jk'] = "Pilih jenis kelamin.";
    if(empty($pekerjaan)) $errors['pekerjaan'] = "Pilih pekerjaan.";
    if(empty($alamat) || strlen($alamat) < 10) $errors['alamat'] = "Alamat min 10 karakter.";
    
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Email tidak valid.";
    if(empty($telepon) || !preg_match('/^08\d{8,11}$/', $telepon)) $errors['telepon'] = "Format telp: 08xxxxxxxxxx.";
    
    if(empty($tgl_lahir)) {
        $errors['tgl_lahir'] = "Tanggal lahir wajib diisi.";
    } else {
        $umur = date_diff(date_create($tgl_lahir), date_create('today'))->y;
        if($umur < 10) $errors['tgl_lahir'] = "Umur minimal 10 tahun.";
    }
    
    // Validasi Unique (Kecuali ID sendiri)
    if(empty($errors)) {
        $q_cek = $conn->prepare("SELECT id_anggota FROM anggota WHERE (kode_anggota = ? OR email = ?) AND id_anggota != ?");
        $q_cek->bind_param("ssi", $kode, $email, $id_anggota);
        $q_cek->execute();
        if($q_cek->get_result()->num_rows > 0) $errors['general'] = "Kode Anggota/Email sudah digunakan.";
        $q_cek->close();
    }
    
    // Upload Foto Baru
    $nama_foto = $agt['foto'];
    if(empty($errors) && isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])) {
            if(!empty($agt['foto']) && file_exists('uploads/' . $agt['foto'])) {
                unlink('uploads/' . $agt['foto']);
            }
            $nama_foto = time() . '_' . rand(100,999) . '.' . $ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/' . $nama_foto);
        } else {
            $errors['foto'] = "Format foto harus JPG/PNG.";
        }
    }
    
    // Update Database
    if(empty($errors)) {
        $stmt = $conn->prepare("UPDATE anggota SET kode_anggota=?, nama=?, email=?, telepon=?, alamat=?, tanggal_lahir=?, jenis_kelamin=?, pekerjaan=?, status=?, foto=? WHERE id_anggota=?");
        $stmt->bind_param("ssssssssssi", $kode, $nama, $email, $telepon, $alamat, $tgl_lahir, $jk, $pekerjaan, $status, $nama_foto, $id_anggota);
        
        if($stmt->execute()) {
            header("Location: index.php?success=" . urlencode("Profil anggota berhasil diperbarui."));
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
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Update Profil Anggota</h5>
                </div>
                <div class="card-body p-4">
                    <?php if(isset($errors['general'])): ?>
                        <div class="alert alert-danger shadow-sm"><?php echo $errors['general']; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Kode Anggota</label>
                                <input type="text" name="kode_anggota" class="form-control" value="<?php echo htmlspecialchars($kode); ?>">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($nama); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="telepon" class="form-control" value="<?php echo htmlspecialchars($telepon); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" value="<?php echo htmlspecialchars($tgl_lahir); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="Laki-laki" <?php echo ($jk=='Laki-laki')?'selected':''; ?>>Laki-laki</option>
                                    <option value="Perempuan" <?php echo ($jk=='Perempuan')?'selected':''; ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="alamat" rows="2" class="form-control"><?php echo htmlspecialchars($alamat); ?></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pekerjaan</label>
                                <select name="pekerjaan" class="form-select">
                                    <option value="Pelajar" <?php echo ($pekerjaan=='Pelajar')?'selected':''; ?>>Pelajar</option>
                                    <option value="Mahasiswa" <?php echo ($pekerjaan=='Mahasiswa')?'selected':''; ?>>Mahasiswa</option>
                                    <option value="Pegawai" <?php echo ($pekerjaan=='Pegawai')?'selected':''; ?>>Pegawai</option>
                                    <option value="Lainnya" <?php echo ($pekerjaan=='Lainnya')?'selected':''; ?>>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status Keanggotaan</label>
                                <select name="status" class="form-select">
                                    <option value="Aktif" <?php echo ($status=='Aktif')?'selected':''; ?>>Aktif</option>
                                    <option value="Nonaktif" <?php echo ($status=='Nonaktif')?'selected':''; ?>>Nonaktif</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Ganti Foto Baru</label>
                                <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png">
                                <small class="text-muted">Biarkan kosong jika tidak diganti</small>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-warning fw-bold"><i class="bi bi-save2"></i> Update Data</button>
                        <a href="index.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php closeConnection(); require_once '../../includes/footer.php'; ?>