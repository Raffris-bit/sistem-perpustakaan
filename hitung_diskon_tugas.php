<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Diskon - Rafi Risqiyanto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-dark text-white text-center py-3">
                        <h3 class="mb-0">🧾 Struk Pembayaran Perpustakaan</h3>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php
                        // 1. INPUT DATA
                        $nama_pembeli = "Budi Santoso";
                        $judul_buku = "Laravel Advanced";
                        $harga_satuan = 150000;
                        $jumlah_beli = 4;
                        $is_member = true; 

                        // 2. HITUNG SUBTOTAL
                        $subtotal = $harga_satuan * $jumlah_beli;

                        // 3. LOGIKA DISKON BERTINGKAT (Berdasarkan Jumlah)
                        if ($jumlah_beli > 10) {
                            $persentase_diskon = 20;
                        } elseif ($jumlah_beli >= 6) {
                            $persentase_diskon = 15;
                        } elseif ($jumlah_beli >= 3) {
                            $persentase_diskon = 10;
                        } else {
                            $persentase_diskon = 0;
                        }

                        $diskon_jumlah = $subtotal * ($persentase_diskon / 100);
                        $total_setelah_diskon1 = $subtotal - $diskon_jumlah;

                        // 4. DISKON MEMBER (Bonus 5%)
                        $diskon_member = 0;
                        if ($is_member) {
                            $diskon_member = $total_setelah_diskon1 * 0.05;
                        }

                        $total_setelah_semua_diskon = $total_setelah_diskon1 - $diskon_member;

                        // 5. PPN (11%)
                        $ppn = $total_setelah_semua_diskon * 0.11;

                        // 6. HASIL AKHIR
                        $total_akhir = $total_setelah_semua_diskon + $ppn;
                        $total_hemat = $diskon_jumlah + $diskon_member;
                        ?>

                        <div class="row mb-4">
                            <div class="col-6">
                                <p class="mb-1 text-muted">Nama Pembeli:</p>
                                <h5 class="fw-bold"><?php echo $nama_pembeli; ?></h5>
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-1 text-muted">Status:</p>
                                <?php echo $is_member ? '<span class="badge bg-warning text-dark">GOLD MEMBER</span>' : '<span class="badge bg-secondary">Reguler</span>'; ?>
                            </div>
                        </div>

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $judul_buku; ?> (x<?php echo $jumlah_beli; ?>)</td>
                                    <td class="text-end">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                                </tr>
                                <tr class="text-danger">
                                    <td>Diskon Pembelian (<?php echo $persentase_diskon; ?>%)</td>
                                    <td class="text-end">- Rp <?php echo number_format($diskon_jumlah, 0, ',', '.'); ?></td>
                                </tr>
                                <?php if($is_member): ?>
                                <tr class="text-danger">
                                    <td>Diskon Member (5%)</td>
                                    <td class="text-end">- Rp <?php echo number_format($diskon_member, 0, ',', '.'); ?></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <td>PPN (11%)</td>
                                    <td class="text-end">+ Rp <?php echo number_format($ppn, 0, ',', '.'); ?></td>
                                </tr>
                                <tr class="table-dark fw-bold">
                                    <td class="fs-5">TOTAL AKHIR</td>
                                    <td class="text-end fs-5">Rp <?php echo number_format($total_akhir, 0, ',', '.'); ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="alert alert-success mt-4 border-0 shadow-sm">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-piggy-bank-fill fs-2 me-3"></i>
                                <div>
                                    <h6 class="mb-0">Total Penghematan Rafi:</h6>
                                    <h4 class="mb-0 fw-bold">Rp <?php echo number_format($total_hemat, 0, ',', '.'); ?></h4>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-center text-muted small py-3">
                        Terima kasih sudah berbelanja! <br>
                        Admin: Rafi Risqiyanto | NIM: 60324001
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>