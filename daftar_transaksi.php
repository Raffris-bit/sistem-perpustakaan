<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi - M. Rafi Risqiyanto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <!-- Identitas Mahasiswa -->
        <div class="alert alert-dark text-center shadow-sm">
            <strong>M. Rafi Risqiyanto | 60324001</strong> - Tugas 2 (Pertemuan 3)
        </div>

        <h1 class="mb-4"><i class="bi bi-list-columns-reverse"></i> Daftar Transaksi Peminjaman</h1>
        
        <?php
        // TODO: Hitung statistik dengan loop
        $total_transaksi = 0;
        $total_dipinjam = 0;
        $total_dikembalikan = 0;
        
        // TODO: Loop pertama untuk hitung statistik
        for ($i = 1; $i <= 10; $i++) {
            // Sesuai instruksi: Stop di transaksi ke-8
            if ($i == 8) {
                break;
            }
            
            // Sesuai instruksi: Skip transaksi genap
            if ($i % 2 == 0) {
                continue;
            }

            $total_transaksi++;
            $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";
            
            if ($status == "Dipinjam") {
                $total_dipinjam++;
            } else {
                $total_dikembalikan++;
            }
        }
        ?>
        
        <!-- TODO: Tampilkan statistik dalam cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-primary shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Data Ditampilkan</h6>
                        <h2 class="text-primary mb-0"><?php echo $total_transaksi; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-warning shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Status: Dipinjam</h6>
                        <h2 class="text-warning mb-0"><?php echo $total_dipinjam; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-success shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Status: Dikembalikan</h6>
                        <h2 class="text-success mb-0"><?php echo $total_dikembalikan; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- TODO: Tampilkan tabel transaksi -->
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Riwayat Transaksi</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-secondary">
                            <tr>
                                <th>No</th>
                                <th>ID Transaksi</th>
                                <th>Peminjam</th>
                                <th>Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Hari Peminjaman</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // TODO: Loop untuk tampilkan data
                            $no_urut = 1;
                            for ($i = 1; $i <= 10; $i++) {
                                
                                // Gunakan break untuk stop di transaksi 8
                                if ($i == 8) {
                                    break; 
                                }

                                // Gunakan continue untuk skip genap
                                if ($i % 2 == 0) {
                                    continue; 
                                }

                                // Generate data transaksi
                                $id_transaksi = "TRX-" . str_pad($i, 4, "0", STR_PAD_LEFT);
                                $nama_peminjam = "Anggota " . $i;
                                $judul_buku = "Buku Teknologi Vol. " . $i;
                                $tanggal_pinjam = date('Y-m-d', strtotime("-$i days"));
                                $tanggal_kembali = date('Y-m-d', strtotime("+7 days", strtotime($tanggal_pinjam)));
                                $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";
                                
                                // Hitung jumlah hari sejak pinjam
                                // Tanggal sekarang dikurangi tanggal pinjam dalam satuan hari
                                $hari_ini = time();
                                $waktu_pinjam = strtotime($tanggal_pinjam);
                                $selisih_hari = floor(($hari_ini - $waktu_pinjam) / (60 * 60 * 24));

                                // Gunakan warna berbeda untuk status
                                $badge_class = ($status == "Dikembalikan") ? "success" : "warning text-dark";
                            ?>
                            <tr>
                                <td><?php echo $no_urut++; ?></td>
                                <td><code><?php echo $id_transaksi; ?></code></td>
                                <td><strong><?php echo $nama_peminjam; ?></strong></td>
                                <td><?php echo $judul_buku; ?></td>
                                <td><?php echo date('d M Y', strtotime($tanggal_pinjam)); ?></td>
                                <td><?php echo date('d M Y', strtotime($tanggal_kembali)); ?></td>
                                <td><?php echo $selisih_hari; ?> Hari</td>
                                <td><span class="badge bg-<?php echo $badge_class; ?>"><?php echo $status; ?></span></td>
                            </tr>
                            <?php 
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light text-muted small">
                <i class="bi bi-info-circle"></i> Menampilkan data ganjil saja. Berhenti pada iterasi ke-8.
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>