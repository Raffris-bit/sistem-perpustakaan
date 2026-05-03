<?php
/**
 * M. Rafi Risqiyanto | 60324001
 * File: functions_anggota.php (Tugas 2 - Library Functions)
 */

// 1. Function untuk hitung total anggota
function hitung_total_anggota($anggota_list) {
    return count($anggota_list);
}
 
// 2. Function untuk hitung anggota aktif
function hitung_anggota_aktif($anggota_list) {
    $aktif = 0;
    foreach ($anggota_list as $anggota) {
        if ($anggota["status"] == "Aktif") {
            $aktif++;
        }
    }
    return $aktif;
}
 
// 3. Function untuk hitung rata-rata pinjaman
function hitung_rata_rata_pinjaman($anggota_list) {
    if (count($anggota_list) == 0) return 0;
    $total_pinjam = 0;
    foreach ($anggota_list as $anggota) {
        $total_pinjam += $anggota["total_pinjaman"];
    }
    return round($total_pinjam / count($anggota_list), 1);
}
 
// 4. Function untuk cari anggota by ID
function cari_anggota_by_id($anggota_list, $id) {
    foreach ($anggota_list as $anggota) {
        if ($anggota["id"] == $id) {
            return $anggota;
        }
    }
    return null;
}
 
// 5. Function untuk cari anggota teraktif
function cari_anggota_teraktif($anggota_list) {
    if (count($anggota_list) == 0) return null;
    $teraktif = $anggota_list[0];
    foreach ($anggota_list as $anggota) {
        if ($anggota["total_pinjaman"] > $teraktif["total_pinjaman"]) {
            $teraktif = $anggota;
        }
    }
    return $teraktif;
}
 
// 6. Function untuk filter by status
function filter_by_status($anggota_list, $status) {
    $hasil = [];
    foreach ($anggota_list as $anggota) {
        if ($anggota["status"] == $status) {
            $hasil[] = $anggota;
        }
    }
    return $hasil;
}
 
// 7. Function untuk validasi email
function validasi_email($email) {
    // Cek: tidak kosong, ada @, ada .
    if (!empty($email) && strpos($email, '@') !== false && strpos($email, '.') !== false) {
        return true;
    }
    return false;
}
 
// 8. Function untuk format tanggal Indonesia
function format_tanggal_indo($tanggal) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $pecahkan = explode('-', $tanggal); // YYYY-MM-DD
    // Array: [0]=>Tahun, [1]=>Bulan, [2]=>Tanggal
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

// ================= BONUS (+10%) =================

// BONUS 1: Function untuk sort anggota by nama (A-Z)
function sort_anggota_by_nama($anggota_list) {
    $sorted = $anggota_list;
    // Menggunakan usort untuk mengurutkan array multidimensi berdasarkan field "nama"
    usort($sorted, function($a, $b) {
        return strcmp($a["nama"], $b["nama"]);
    });
    return $sorted;
}

// BONUS 2: Function untuk search anggota by nama (partial match)
function search_anggota_by_nama($anggota_list, $keyword) {
    $hasil = [];
    foreach ($anggota_list as $anggota) {
        if (stripos($anggota["nama"], $keyword) !== false) {
            $hasil[] = $anggota;
        }
    }
    return $hasil;
}
?>