<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-primary">
            <strong>Nama:</strong> M. Rafi Risqiyanto <br>
            <strong>NIM:</strong> 60324001
        </div>

        <h1 class="mb-4">Informasi Buku</h1>
        
        <?php
        // --- DATA BUKU BARU (EKSPLORASI) ---
        // Kita ganti isi kotaknya dengan mainan baru!
        $judul = "Laravel: From Beginner to Advanced"; // Judulnya berubah
        $pengarang = "Budi Raharjo";
        $penerbit = "Informatika";
        $tahun_terbit = 2023;
        $harga = 125000;                              // Harganya jadi lebih mahal
        $stok = 8;                                     // Stoknya jadi lebih sedikit
        $isbn = "978-602-1234-56-7";
        ?>
        
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">📖 <?php echo $judul; ?></h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Nama Pengarang</th>
                        <td>: <?php echo $pengarang; ?></td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td>: <?php echo $penerbit; ?></td>
                    </tr>
                    <tr>
                        <th>Tahun Terbit</th>
                        <td>: <?php echo $tahun_terbit; ?></td>
                    </tr>
                    <tr>
                        <th>Kode ISBN</th>
                        <td>: <?php echo $isbn; ?></td>
                    </tr>
                    <tr>
                        <th>Harga Buku</th>
                        <td>: Rp <?php echo number_format($harga, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Sisa Stok</th>
                        <td>: <span class="badge bg-success"><?php echo $stok; ?> buku</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>