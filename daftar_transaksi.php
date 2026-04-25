<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi - Rafi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4 fw-bold">Riwayat Transaksi Peminjaman</h2>
        
        <?php
        // 1. SIAPIN KERANJANG KOSONG BUAT STATISTIK
        $total_transaksi = 0;
        $total_dipinjam = 0;
        $total_dikembalikan = 0;
        
        // 2. MESIN PENGHITUNG STATISTIK (Dihitung sebelum tabel dibuat)
        for ($i = 1; $i <= 10; $i++) {
            // Aturan 1: Lewati angka genap (CONTINUE)
            if ($i % 2 == 0) {
                continue;
            }
            // Aturan 2: Berhenti kalau udah sampai angka 8 (BREAK)
            if ($i >= 8) {
                break;
            }

            // Kalau lolos syarat di atas, hitung statistiknya
            $total_transaksi++;
            $status_cek = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";
            
            if ($status_cek == "Dipinjam") {
                $total_dipinjam++;
            } else {
                $total_dikembalikan++;
            }
        }
        ?>
        
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white text-center p-3 shadow-sm">
                    <h4><?php echo $total_transaksi; ?></h4>
                    <small>Total Transaksi Ditampilkan</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-dark text-center p-3 shadow-sm">
                    <h4><?php echo $total_dipinjam; ?></h4>
                    <small>Masih Dipinjam</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white text-center p-3 shadow-sm">
                    <h4><?php echo $total_dikembalikan; ?></h4>
                    <small>Sudah Dikembalikan</small>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Lama Pinjam</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // MESIN PENCETAK BARIS TABEL
                        for ($i = 1; $i <= 10; $i++) {
                            
                            // Aturan 1: Skip genap
                            if ($i % 2 == 0) { continue; }
                            
                            // Aturan 2: Stop di 8
                            if ($i >= 8) { break; }

                            // Generate data palsu secara otomatis
                            $id_transaksi = "TRX-" . str_pad($i, 4, "0", STR_PAD_LEFT);
                            $nama_peminjam = "Anggota " . $i;
                            $judul_buku = "Buku Teknologi Vol. " . $i;
                            
                            // Bikin tanggal mundur (misal $i = 3, berarti 3 hari lalu)
                            $tanggal_pinjam = date('Y-m-d', strtotime("-$i days"));
                            $tanggal_kembali = date('Y-m-d', strtotime("+7 days", strtotime($tanggal_pinjam)));
                            
                            // Status: Kalo angkanya bisa dibagi 3, berarti dikembalikan
                            $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";
                            $warna_status = ($status == "Dikembalikan") ? "success" : "warning text-dark";
                            
                            // Lama Pinjam (karena pinjamnya -$i hari yang lalu, berarti lamanya adalah $i hari)
                            $lama_pinjam = $i . " Hari";
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><span class="badge bg-secondary"><?php echo $id_transaksi; ?></span></td>
                            <td><strong><?php echo $nama_peminjam; ?></strong></td>
                            <td><?php echo $judul_buku; ?></td>
                            <td><?php echo $tanggal_pinjam; ?></td>
                            <td><?php echo $tanggal_kembali; ?></td>
                            <td><?php echo $lama_pinjam; ?></td>
                            <td><span class="badge bg-<?php echo $warna_status; ?>"><?php echo $status; ?></span></td>
                        </tr>
                        <?php 
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-muted small text-end">
                Dicetak oleh: M. Rafi Risqiyanto | Universitas UIN Gusdur
            </div>
        </div>
    </div>
</body>
</html>
