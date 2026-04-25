<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manipulasi String - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success">
            <strong>Nama:</strong> M. Rafi Risqiyanto <br>
            <strong>NIM:</strong> 60324001
        </div>

        <h1 class="mb-4">Manipulasi String Judul Buku</h1>
        
        <?php
        // Ini bahan-bahan yang mau kita sulap
        $judul = "pemrograman web dengan php dan mysql";
        $pengarang = "BUDI RAHARJO";
        $deskripsi = "Buku ini membahas pemrograman web menggunakan PHP dan MySQL secara lengkap dari dasar hingga mahir";
        ?>
        
        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Data Asli (Sebelum Disulap)</h5>
            </div>
            <div class="card-body">
                <p><strong>Judul:</strong> <?php echo $judul; ?></p>
                <p><strong>Pengarang:</strong> <?php echo $pengarang; ?></p>
                <p><strong>Deskripsi:</strong> <?php echo $deskripsi; ?></p>
            </div>
        </div>
        
        <div class="card mb-3 shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Hasil Sulapan (Manipulasi)</h5>
            </div>
            <div class="card-body">
                
                <p><strong>1. Jadi Huruf Besar Semua:</strong><br />
                   <?php echo strtoupper($judul); ?></p>
                
                <p><strong>2. Jadi Huruf Kecil Semua:</strong><br />
                   <?php echo strtolower($pengarang); ?></p>
                
                <p><strong>3. Huruf Besar di Tiap Kata:</strong><br />
                   <?php echo ucwords($judul); ?></p>
                
                <p><strong>4. Panjang Karakter Judul:</strong><br />
                   <?php echo strlen($judul); ?> karakter</p>
                
                <p><strong>5. Jumlah Kata Judul:</strong><br />
                   <?php echo str_word_count($judul); ?> kata</p>
                
                <p><strong>6. Potong 20 Huruf Pertama:</strong><br />
                   <?php echo substr($deskripsi, 0, 20) . "..."; ?></p>
                
                <p><strong>7. Ganti "php" Jadi "PHP 8":</strong><br />
                   <?php echo str_replace("php", "PHP 8", $judul); ?></p>
                
                <p><strong>8. Di mana letak kata "web"?</strong><br />
                   Ada di urutan ke-<?php echo strpos($judul, "web"); ?></p>
                
                <?php $judul_spasi = "  PHP Programming  "; ?>
                <p><strong>9. Buang Spasi Pinggir (Trim):</strong><br />
                   Sebelum: "<?php echo $judul_spasi; ?>" (panjang: <?php echo strlen($judul_spasi); ?>)<br />
                   Sesudah: "<?php echo trim($judul_spasi); ?>" (panjang: <?php echo strlen(trim($judul_spasi)); ?>)</p>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>