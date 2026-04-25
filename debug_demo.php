<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debugging - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        pre {
            background-color: #2d2d2d;
            color: #ccc;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #444;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-dark shadow-sm">
            <strong>Nama:</strong> M. Rafi Risqiyanto <br>
            <strong>NIM:</strong> 60324001
        </div>

        <h1 class="mb-4">Detektif PHP: Mengintip Isi Variabel</h1>
        
        <?php
        // --- DATA YANG MAU KITA INTIP ---
        $judul = "Pemrograman PHP";     // String (Tulisan)
        $harga = 85000;                // Integer (Angka)
        $tersedia = true;              // Boolean (Benar/Salah)
        $kategori = null;              // Kosong
        
        // Kotak besar yang isinya banyak (Array)
        $buku = [
            "judul" => "Laravel for Beginners",
            "pengarang" => "John Doe",
            "stok" => 8
        ];
        ?>
        
        <div class="card mb-3 border-danger shadow-sm">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">1. var_dump() : Kaca Pembesar Super Detail</h5>
            </div>
            <div class="card-body">
                <p>Kalo pake ini, kamu bisa liat tipe datanya dan berapa panjangnya.</p>
                <p><strong>Cek Judul:</strong></p>
                <pre><?php var_dump($judul); ?></pre>
                
                <p><strong>Cek Harga & Status:</strong></p>
                <pre><?php var_dump($harga, $tersedia); ?></pre>
            </div>
        </div>
        
        <div class="card mb-3 border-info shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">2. print_r() : Daftar Yang Rapi</h5>
            </div>
            <div class="card-body">
                <p>Biasanya dipake buat liat isi **Array** (kotak besar) biar mata nggak pusing.</p>
                <p><strong>Isi Kotak Buku:</strong></p>
                <pre><?php print_r($buku); ?></pre>
            </div>
        </div>

        <div class="card border-success shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">3. gettype() : Cuma Mau Tau Namanya</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Variabel</th>
                        <th>Tipe Datanya</th>
                    </tr>
                    <tr>
                        <td>$judul</td>
                        <td><span class="badge bg-primary"><?php echo gettype($judul); ?></span></td>
                    </tr>
                    <tr>
                        <td>$harga</td>
                        <td><span class="badge bg-primary"><?php echo gettype($harga); ?></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>