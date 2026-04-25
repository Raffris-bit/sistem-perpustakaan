<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan - V2</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 850px;
            margin: 40px auto;
            padding: 20px;
            background-color: #f0f2f5;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin: 20px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        h1 { color: #2c3e50; border-bottom: 4px solid #27ae60; padding-bottom: 12px; margin-top: 0; }
        h3 { margin-top: 0; color: #2e7d32; }
        
        .info { background: #e8f5e9; border-left: 5px solid #27ae60; padding: 15px; margin: 15px 0; }
        .server { background: #fff3cd; border-left: 5px solid #ffc107; padding: 15px; margin: 15px 0; }
        .operasional { background: #e3f2fd; border-left: 5px solid #2196f3; padding: 15px; margin: 15px 0; }
        
        strong { color: #333; }
        .badge-libur { color: #d32f2f; font-weight: bold; }
    </style>
</head>
<body>
    <div class="card">
        <h1>🏛️ Sistem Manajemen Perpustakaan</h1>
 
        <div class="info">
            <h3>Selamat Datang!</h3>
            <p><strong>Dibuat oleh:</strong> M. Rafi Risqiyanto (NIM: 60324001)</p>
            <p><strong>Status:</strong> Mahasiswa Informatika UIN Gusdur</p>
            <p><strong>Waktu Server:</strong> <?php echo date('H:i:s'); ?></p>
        </div>

        <?php
        // --- KONFIGURASI DATA ---
        $nama_perpus    = "Perpustakaan Digital Informatika";
        $total_buku     = 1250;
        $total_anggota  = 450;
        $buku_dipinjam  = 178;
        $buku_tersedia  = $total_buku - $buku_dipinjam;
        
        // VARIABEL BARU (Tugas 2)
        $alamat_perpus  = "Jl. Pahlawan No. 73, Rowolaku, Kajen, Pekalongan";
        $telepon_perpus = "0812-3456-7890";
        $jam_buka       = "08:30";
        $jam_tutup      = "15:30";

        // PERHITUNGAN PERSENTASE
        $persen_pinjam   = round(($buku_dipinjam / $total_buku) * 100, 1);
        $persen_tersedia = round(($buku_tersedia / $total_buku) * 100, 1);
        ?>

        <div class="operasional">
            <h3>📍 Informasi Perpustakaan</h3>
            <p><strong>Alamat:</strong> <?php echo $alamat_perpus; ?></p>
            <p><strong>Telepon:</strong> <?php echo $telepon_perpus; ?></p>
            <p><strong>Jam Operasional:</strong> <?php echo $jam_buka; ?> – <?php echo $jam_tutup; ?> WIB</p>
            <p><strong>Hari Libur:</strong> <span class="badge-libur">Sabtu – Minggu</span></p>
        </div>
 
        <div class="info">
            <h3>📊 Statistik <?php echo $nama_perpus; ?></h3>
            <p><strong>Total Koleksi:</strong> <?php echo number_format($total_buku); ?> buku</p>
            <p><strong>Total Anggota:</strong> <?php echo number_format($total_anggota); ?> orang</p>
            <hr>
            <p><strong>Buku Dipinjam:</strong> <?php echo $buku_dipinjam; ?> unit (<?php echo $persen_pinjam; ?>%)</p>
            <p><strong>Buku Tersedia:</strong> <?php echo number_format($buku_tersedia); ?> unit (<?php echo $persen_tersedia; ?>%)</p>
        </div>

        <div class="server">
            <h3>⚙️ Informasi Server</h3>
            <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
            <p><strong>Software:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
        </div>
    </div>
</body>
</html>