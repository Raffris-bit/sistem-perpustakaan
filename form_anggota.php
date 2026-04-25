<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Anggota - Rafi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="alert alert-dark text-center shadow-sm">
            <strong>Mahasiswa:</strong> M. Rafi Risqiyanto | <strong>NIM:</strong> 60324001
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <?php
                // Variabel Error dan Success
                $errors = [];
                $success = false;
                
                // Variabel Keep Value (Biar pas error, isiannya nggak ilang)
                $nama = '';
                $email = '';
                $telepon = '';
                $alamat = '';
                $jk = '';
                $tgl_lahir = '';
                $pekerjaan = '';

                // KETIKA TOMBOL SUBMIT DITEKAN (Metode POST)
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Ambil data dan bersihkan spasi
                    $nama = trim(htmlspecialchars($_POST['nama'] ?? ''));
                    $email = trim(htmlspecialchars($_POST['email'] ?? ''));
                    $telepon = trim(htmlspecialchars($_POST['telepon'] ?? ''));
                    $alamat = trim(htmlspecialchars($_POST['alamat'] ?? ''));
                    $jk = $_POST['jk'] ?? '';
                    $tgl_lahir = $_POST['tgl_lahir'] ?? '';
                    $pekerjaan = $_POST['pekerjaan'] ?? '';

                    // 1. Validasi Nama Lengkap
                    if (empty($nama)) {
                        $errors['nama'] = "Nama Lengkap wajib diisi.";
                    } elseif (strlen($nama) < 3) {
                        $errors['nama'] = "Nama Lengkap minimal 3 karakter.";
                    }

                    // 2. Validasi Email
                    if (empty($email)) {
                        $errors['email'] = "Email wajib diisi.";
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors['email'] = "Format email tidak valid (contoh: budi@gmail.com).";
                    }

                    // 3. Validasi Telepon (Regex: harus 08..., panjang 10-13)
                    if (empty($telepon)) {
                        $errors['telepon'] = "Nomor Telepon wajib diisi.";
                    } elseif (!preg_match('/^08[0-9]{8,11}$/', $telepon)) {
                        $errors['telepon'] = "Telepon harus diawali '08' dan terdiri dari 10-13 angka.";
                    }

                    // 4. Validasi Alamat
                    if (empty($alamat)) {
                        $errors['alamat'] = "Alamat wajib diisi.";
                    } elseif (strlen($alamat) < 10) {
                        $errors['alamat'] = "Alamat terlalu singkat (minimal 10 karakter).";
                    }

                    // 5. Validasi Jenis Kelamin
                    if (empty($jk)) {
                        $errors['jk'] = "Jenis Kelamin wajib dipilih.";
                    }

                    // 6. Validasi Tanggal Lahir (Umur min 10 tahun)
                    if (empty($tgl_lahir)) {
                        $errors['tgl_lahir'] = "Tanggal Lahir wajib diisi.";
                    } else {
                        // Rumus ngitung umur
                        $dob = new DateTime($tgl_lahir);
                        $now = new DateTime();
                        $umur = $now->diff($dob)->y; // Ambil tahunnya saja
                        
                        if ($umur < 10) {
                            $errors['tgl_lahir'] = "Umur minimal untuk mendaftar adalah 10 tahun (Umur Anda: $umur tahun).";
                        }
                    }

                    // 7. Validasi Pekerjaan
                    if (empty($pekerjaan)) {
                        $errors['pekerjaan'] = "Pekerjaan wajib dipilih.";
                    }

                    // JIKA TIDAK ADA ERROR SAMA SEKALI
                    if (count($errors) == 0) {
                        $success = true;
                    }
                }
                ?>

                <?php if ($success): ?>
                <div class="card border-success shadow mb-4">
                    <div class="card-header bg-success text-white text-center">
                        <h4 class="mb-0"><i class="bi bi-check-circle-fill"></i> Pendaftaran Berhasil!</h4>
                    </div>
                    <div class="card-body text-center">
                        <p class="text-muted">Berikut adalah data keanggotaan Anda:</p>
                        <h2 class="text-primary fw-bold"><?php echo $nama; ?></h2>
                        <span class="badge bg-dark mb-3 fs-6"><?php echo $pekerjaan; ?></span>
                        
                        <ul class="list-group list-group-flush text-start mt-3">
                            <li class="list-group-item"><strong>Email:</strong> <?php echo $email; ?></li>
                            <li class="list-group-item"><strong>Telepon:</strong> <?php echo $telepon; ?></li>
                            <li class="list-group-item"><strong>Gender:</strong> <?php echo $jk; ?></li>
                            <li class="list-group-item"><strong>Tgl Lahir:</strong> <?php echo $tgl_lahir; ?> (Umur: <?php echo $umur; ?> thn)</li>
                            <li class="list-group-item"><strong>Alamat:</strong> <?php echo $alamat; ?></li>
                        </ul>
                        
                        <a href="form_anggota.php" class="btn btn-outline-success mt-4 w-100">Daftar Anggota Lain</a>
                    </div>
                </div>
                <?php else: ?>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-person-plus-fill"></i> Registrasi Anggota Perpustakaan</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if (count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <strong>Pendaftaran Gagal!</strong> Silakan perbaiki form yang berwarna merah di bawah.
                        </div>
                        <?php endif; ?>

                        <form method="POST" action="" novalidate>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php echo isset($errors['nama']) ? 'is-invalid' : ''; ?>" name="nama" value="<?php echo $nama; ?>" placeholder="Masukkan nama minimal 3 karakter">
                                <?php if(isset($errors['nama'])): ?>
                                    <div class="invalid-feedback"><?php echo $errors['nama']; ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" name="email" value="<?php echo $email; ?>" placeholder="email@contoh.com">
                                    <?php if(isset($errors['email'])): ?>
                                        <div class="invalid-feedback"><?php echo $errors['email']; ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">No. Telepon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php echo isset($errors['telepon']) ? 'is-invalid' : ''; ?>" name="telepon" value="<?php echo $telepon; ?>" placeholder="08xxxxxxxxxx">
                                    <?php if(isset($errors['telepon'])): ?>
                                        <div class="invalid-feedback"><?php echo $errors['telepon']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold d-block">Jenis Kelamin <span class="text-danger">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input <?php echo isset($errors['jk']) ? 'is-invalid' : ''; ?>" type="radio" name="jk" value="Laki-laki" id="jkL" <?php echo ($jk == 'Laki-laki') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="jkL">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input <?php echo isset($errors['jk']) ? 'is-invalid' : ''; ?>" type="radio" name="jk" value="Perempuan" id="jkP" <?php echo ($jk == 'Perempuan') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="jkP">Perempuan</label>
                                </div>
                                <?php if(isset($errors['jk'])): ?>
                                    <div class="text-danger small mt-1"><?php echo $errors['jk']; ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control <?php echo isset($errors['tgl_lahir']) ? 'is-invalid' : ''; ?>" name="tgl_lahir" value="<?php echo $tgl_lahir; ?>">
                                    <?php if(isset($errors['tgl_lahir'])): ?>
                                        <div class="invalid-feedback"><?php echo $errors['tgl_lahir']; ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Pekerjaan <span class="text-danger">*</span></label>
                                    <select class="form-select <?php echo isset($errors['pekerjaan']) ? 'is-invalid' : ''; ?>" name="pekerjaan">
                                        <option value="">-- Pilih Pekerjaan --</option>
                                        <option value="Pelajar" <?php echo ($pekerjaan == 'Pelajar') ? 'selected' : ''; ?>>Pelajar</option>
                                        <option value="Mahasiswa" <?php echo ($pekerjaan == 'Mahasiswa') ? 'selected' : ''; ?>>Mahasiswa</option>
                                        <option value="Pegawai" <?php echo ($pekerjaan == 'Pegawai') ? 'selected' : ''; ?>>Pegawai</option>
                                        <option value="Lainnya" <?php echo ($pekerjaan == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                                    </select>
                                    <?php if(isset($errors['pekerjaan'])): ?>
                                        <div class="invalid-feedback"><?php echo $errors['pekerjaan']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control <?php echo isset($errors['alamat']) ? 'is-invalid' : ''; ?>" name="alamat" rows="3" placeholder="Masukkan alamat minimal 10 karakter"><?php echo $alamat; ?></textarea>
                                <?php if(isset($errors['alamat'])): ?>
                                    <div class="invalid-feedback"><?php echo $errors['alamat']; ?></div>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold"><i class="bi bi-save"></i> Daftar Sekarang</button>
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