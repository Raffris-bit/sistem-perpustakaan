<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perhitungan Diskon - M. Rafi Risqiyanto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="alert alert-dark text-center shadow-sm">
            <strong>M. Rafi Risqiyanto | 60324001</strong> - Tugas 2 (Pertemuan 2)
        </div>

        <h1 class="mb-4 text-center">Sistem Perhitungan Diskon Bertingkat</h1>
        
        <?php
        // TODO: Isi data pembeli dan buku di sini
        $nama_pembeli = "Budi Santoso";
        $judul_buku = "Laravel Advanced";
        $harga_satuan = 150000;
        $jumlah_beli = 4;
        $is_member = true; // true atau false
        
        // TODO: Hitung subtotal
        $subtotal = $harga_satuan * $jumlah_beli; 
        
        // TODO: Tentukan persentase diskon berdasarkan jumlah
        if ($jumlah_beli > 10) {
            $persentase_diskon = 20;
        } elseif ($jumlah_beli >= 6 && $jumlah_beli <= 10) {
            $persentase_diskon = 15;
        } elseif ($jumlah_beli >= 3 && $jumlah_beli <= 5) {
            $persentase_diskon = 10;
        } else {
            $persentase_diskon = 0;
        }
        
        // TODO: Hitung diskon
        $diskon = $subtotal * ($persentase_diskon / 100); 
        
        // TODO: Total setelah diskon pertama
        $total_setelah_diskon1 = $subtotal - $diskon; 
        
        // TODO: Hitung diskon member jika member (5% dari total setelah diskon pertama)
        $diskon_member = 0;
        if ($is_member) {
            $diskon_member = $total_setelah_diskon1 * (5 / 100);
        }
        
        // TODO: Total setelah semua diskon
        $total_setelah_diskon = $total_setelah_diskon1 - $diskon_member; 
        
        // TODO: Hitung PPN
        $ppn = $total_setelah_diskon * 0.11; 
        
        // TODO: Total akhir
        $total_akhir = $total_setelah_diskon + $ppn; 
        
        // TODO: Total penghematan
        $total_hemat = $diskon + $diskon_member; 
        ?>
        
        <!-- TODO: Tampilkan hasil perhitungan dengan Bootstrap -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Struk Pembelian Buku</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <strong>Nama Pembeli:</strong> <?php echo $nama_pembeli; ?><br>
                                <strong>Status:</strong> <?php echo $is_member ? '<span class="badge bg-success">Member</span>' : '<span class="badge bg-secondary">Non-Member</span>'; ?>
                            </div>
                            <div class="col-6 text-end">
                                <strong>Buku:</strong> <?php echo $judul_buku; ?><br>
                                <strong>Jumlah:</strong> <?php echo $jumlah_beli; ?> buku
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Harga Satuan</td>
                                    <td class="text-end">Rp <?php echo number_format($harga_satuan, 0, ',', '.'); ?></td>
                                </tr>
                                <tr class="table-light">
                                    <td><strong>Subtotal</strong></td>
                                    <td class="text-end"><strong>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></strong></td>
                                </tr>
                                <tr class="text-success">
                                    <td>Diskon Jumlah (<?php echo $persentase_diskon; ?>%)</td>
                                    <td class="text-end">- Rp <?php echo number_format($diskon, 0, ',', '.'); ?></td>
                                </tr>
                                <?php if ($is_member): ?>
                                <tr class="text-success">
                                    <td>Diskon Member (5%) <br><small class="text-muted">(Dari Rp <?php echo number_format($total_setelah_diskon1, 0, ',', '.'); ?>)</small></td>
                                    <td class="text-end">- Rp <?php echo number_format($diskon_member, 0, ',', '.'); ?></td>
                                </tr>
                                <?php endif; ?>
                                <tr class="table-light">
                                    <td><strong>Total Setelah Diskon</strong></td>
                                    <td class="text-end"><strong>Rp <?php echo number_format($total_setelah_diskon, 0, ',', '.'); ?></strong></td>
                                </tr>
                                <tr class="text-danger">
                                    <td>PPN (11%)</td>
                                    <td class="text-end">+ Rp <?php echo number_format($ppn, 0, ',', '.'); ?></td>
                                </tr>
                                <tr class="table-primary fs-5">
                                    <th>TOTAL AKHIR</th>
                                    <th class="text-end">Rp <?php echo number_format($total_akhir, 0, ',', '.'); ?></th>
                                </tr>
                            </tbody>
                        </table>

                        <div class="alert alert-success text-center mt-3 mb-0">
                            Total Penghematan Anda: <strong>Rp <?php echo number_format($total_hemat, 0, ',', '.'); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>