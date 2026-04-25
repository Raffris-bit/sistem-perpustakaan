<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhitungan Harga - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-warning shadow-sm">
            <strong>Nama:</strong> M. Rafi Risqiyanto <br>
            <strong>NIM:</strong> 60324001
        </div>

        <h1 class="mb-4">Sistem Perhitungan Harga Buku</h1>
        
        <?php
        // 1. Data Belanjaan (Variabel)
        $judul_buku = "Mastering Laravel Framework";
        $harga_satuan = 95000;
        $jumlah_beli = 3; // Coba ganti angka ini nanti!
        
        // 2. Rumus Matematika (Operator)
        $subtotal = $harga_satuan * $jumlah_beli; // Harga asli
        
        // 3. Aturan Hadiah (Diskon)
        // Kalo beli 3 atau lebih, dapet diskon 10%
        if ($jumlah_beli >= 3) {
            $persentase_diskon = 10; 
        } else {
            $persentase_diskon = 0;
        }
        
        $diskon = $subtotal * ($persentase_diskon / 100);
        $total_setelah_diskon = $subtotal - $diskon;
        
        // 4. Pajak Pemerintah (PPN 11%)
        $ppn = $total_setelah_diskon * 0.11;
        
        // 5. Total Akhir (Yang harus dibayar)
        $total_akhir = $total_setelah_diskon + $ppn;
        ?>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card border-primary shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Struk Pembelian</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>                           
                                <th width="250">Judul Buku</th>
                                <td>: <?php echo $judul_buku; ?></td>
                            </tr>
                            <tr>
                                <th>Harga Satuan</th>
                                <td>: Rp <?php echo number_format($harga_satuan, 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Jumlah Beli</th>
                                <td>: <?php echo $jumlah_beli; ?> buku</td>
                            </tr>
                            <tr class="table-secondary">
                                <th>Harga Total</th>
                                <td>: Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                            </tr>
                            <tr class="text-success">
                                <th>Potongan Diskon (<?php echo $persentase_diskon; ?>%)</th>
                                <td>: - Rp <?php echo number_format($diskon, 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Pajak PPN 11%</th>
                                <td>: + Rp <?php echo number_format($ppn, 0, ',', '.'); ?></td>
                            </tr>
                            <tr class="table-primary fw-bold">
                                <th>TOTAL YANG DIBAYAR</th>
                                <td>: Rp <?php echo number_format($total_akhir, 0, ',', '.'); ?></td>
                            </tr>
                        </table>
                        
                        <?php if ($persentase_diskon > 0): ?>
                        <div class="alert alert-success">
                            <strong>Hore!</strong> Rafi dapet diskon <?php echo $persentase_diskon; ?>% karena borong <?php echo $jumlah_beli; ?> buku!
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">Hematnya Rafi</h6>
                    </div>
                    <div class="card-body text-center">
                        <h3 class="text-success">
                            Rp <?php echo number_format($diskon, 0, ',', '.'); ?>
                        </h3>
                        <small class="text-muted">Disimpan di celengan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>