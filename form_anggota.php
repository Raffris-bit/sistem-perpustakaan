<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Anggota - M. Rafi Risqiyanto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <!-- Identitas Mahasiswa -->
        <div class="alert alert-dark text-center shadow-sm">
            <strong>M. Rafi Risqiyanto | 60324001</strong> - Tugas 1 (Pertemuan 5)
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php
                // Function sanitasi
                function sanitize_input($data) {
                    return htmlspecialchars(stripslashes(trim($data)));
                }

                $errors = [];
                $success = false;

                // Variabel untuk keep value
                $nama = '';
                $email = '';
                $telepon = '';
                $alamat = '';
                $jk = '';
                $tgl_lahir = '';
                $pekerjaan = '';

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $nama = sanitize_input($_POST['nama'] ?? '');
                    $email = sanitize_input($_POST['email'] ?? '');
                    $telepon = sanitize_input($_POST['telepon'] ?? '');
                    $alamat = sanitize_input($_POST['alamat'] ?? '');
                    $jk = sanitize_input($_POST['jk'] ?? '');
                    $tgl_lahir = sanitize_input($_POST['tgl_lahir'] ?? '');
                    $pekerjaan = sanitize_input($_POST['pekerjaan'] ?? '');

                    // Validasi Nama
                    if (empty($nama)) {
                        $errors['nama'] = "Nama lengkap wajib diisi.";
                    } elseif (strlen($nama) < 3) {
                        $errors['nama'] = "Nama lengkap minimal 3 karakter.";
                    }

                    // Validasi Email
                    if (empty($email)) {
                        $errors['email'] = "Email wajib diisi.";
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors['email'] = "Format email tidak valid.";
                    }

                    // Validasi Telepon
                    if (empty($telepon)) {
                        $errors['telepon'] = "Nomor telepon wajib diisi.";
                    } elseif (!preg_match('/^08\d{8,11}$/', $telepon)) {
                        $errors['telepon'] = "Format telepon tidak valid (contoh: 081234567890, 10-13 digit).";
                    }

                    // Validasi Alamat
                    if (empty($alamat)) {
                        $errors['alamat'] = "Alamat wajib diisi.";
                    } elseif (strlen($alamat) < 10) {
                        $errors['alamat'] = "Alamat minimal 10 karakter.";
                    }

                    // Validasi Jenis Kelamin
                    if (empty($jk)) {
                        $errors['jk'] = "Jenis kelamin wajib dipilih.";
                    }

                    // Validasi Tanggal Lahir (Umur min 10 tahun)
                    if (empty($tgl_lahir)) {
                        $errors['tgl_lahir'] = "Tanggal lahir wajib diisi.";
                    } else {
                        $lahir = new DateTime($tgl_lahir);
                        $sekarang = new DateTime();
                        $umur = $sekarang->diff($lahir)->y;
                        if ($umur < 10) {
                            $errors['tgl_lahir'] = "Umur minimal harus 10 tahun. (Umur Anda saat ini: $umur tahun)";
                        }
                    }

                    // Validasi Pekerjaan
                    if (empty($pekerjaan)) {
                        $errors['pekerjaan'] = "Pekerjaan wajib dipilih.";
                    }

                    // Jika tidak ada error
                    if (count($errors) === 0) {
                        $success = true;
                    }
                }
                ?>

                <!-- Tampilan Pesan Sukses -->
                <?php if ($success): ?>
                <div class="card shadow-sm border-success mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-check-circle"></i> Registrasi Berhasil!</h5>
                    </div>
                    <div class="card-body">
                        <p>Selamat, data anggota berikut telah berhasil didaftarkan:</p>
                        <table class="table table-bordered">
                            <tr><th width="150">Nama Lengkap</th><td><?php echo $nama; ?></td></tr>
                            <tr><th>Email</th><td><?php echo $email; ?></td></tr>
                            <tr><th>Telepon</th><td><?php echo $telepon; ?></td></tr>
                            <tr><th>Alamat</th><td><?php echo $alamat; ?></td></tr>
                            <tr><th>Jenis Kelamin</th><td><?php echo $jk; ?></td></tr>
                            <tr><th>Tanggal Lahir</th><td><?php echo date('d F Y', strtotime($tgl_lahir)); ?></td></tr>
                            <tr><th>Pekerjaan</th><td><?php echo $pekerjaan; ?></td></tr>
                        </table>
                        <a href="form_anggota.php" class="btn btn-primary mt-2">Daftarkan Anggota Lain</a>
                    </div>
                </div>
                <?php else: ?>

                <!-- Form Input -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-person-plus-fill"></i> Form Registrasi Anggota</h4>
                    </div>
                    <div class="card-body">
                        <?php if (count($errors) > 0): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle-fill"></i> Terdapat kesalahan pada form. Silakan perbaiki field yang berwarna merah.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <form method="POST" action="" novalidate>
                            
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php echo isset($errors['nama']) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?php echo $nama; ?>" placeholder="Masukkan nama minimal 3 karakter">
                                <?php if(isset($errors['nama'])): ?><div class="invalid-feedback"><?php echo $errors['nama']; ?></div><?php endif; ?>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo $email; ?>" placeholder="contoh@email.com">
                                    <?php if(isset($errors['email'])): ?><div class="invalid-feedback"><?php echo $errors['email']; ?></div><?php endif; ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telepon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php echo isset($errors['telepon']) ? 'is-invalid' : ''; ?>" id="telepon" name="telepon" value="<?php echo $telepon; ?>" placeholder="08xxxxxxxxxx">
                                    <?php if(isset($errors['telepon'])): ?><div class="invalid-feedback"><?php echo $errors['telepon']; ?></div><?php endif; ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control <?php echo isset($errors['alamat']) ? 'is-invalid' : ''; ?>" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat minimal 10 karakter"><?php echo $alamat; ?></textarea>
                                <?php if(isset($errors['alamat'])): ?><div class="invalid-feedback"><?php echo $errors['alamat']; ?></div><?php endif; ?>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input <?php echo isset($errors['jk']) ? 'is-invalid' : ''; ?>" type="radio" name="jk" id="jk_l" value="Laki-laki" <?php echo ($jk == 'Laki-laki') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="jk_l">Laki-laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input <?php echo isset($errors['jk']) ? 'is-invalid' : ''; ?>" type="radio" name="jk" id="jk_p" value="Perempuan" <?php echo ($jk == 'Perempuan') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="jk_p">Perempuan</label>
                                    </div>
                                    <?php if(isset($errors['jk'])): ?><div class="text-danger small mt-1"><?php echo $errors['jk']; ?></div><?php endif; ?>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="tgl_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control <?php echo isset($errors['tgl_lahir']) ? 'is-invalid' : ''; ?>" id="tgl_lahir" name="tgl_lahir" value="<?php echo $tgl_lahir; ?>" max="<?php echo date('Y-m-d'); ?>">
                                    <?php if(isset($errors['tgl_lahir'])): ?><div class="invalid-feedback"><?php echo $errors['tgl_lahir']; ?></div><?php endif; ?>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                                    <select class="form-select <?php echo isset($errors['pekerjaan']) ? 'is-invalid' : ''; ?>" id="pekerjaan" name="pekerjaan">
                                        <option value="">-- Pilih Pekerjaan --</option>
                                        <option value="Pelajar" <?php echo ($pekerjaan == 'Pelajar') ? 'selected' : ''; ?>>Pelajar</option>
                                        <option value="Mahasiswa" <?php echo ($pekerjaan == 'Mahasiswa') ? 'selected' : ''; ?>>Mahasiswa</option>
                                        <option value="Pegawai" <?php echo ($pekerjaan == 'Pegawai') ? 'selected' : ''; ?>>Pegawai</option>
                                        <option value="Lainnya" <?php echo ($pekerjaan == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                                    </select>
                                    <?php if(isset($errors['pekerjaan'])): ?><div class="invalid-feedback"><?php echo $errors['pekerjaan']; ?></div><?php endif; ?>
                                </div>
                            </div>

                            <hr>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-person-check-fill"></i> Daftarkan Anggota</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>