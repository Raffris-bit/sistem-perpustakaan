<?php
/**
 * M. Rafi Risqiyanto | 60324001
 * File Sistem - Proses Eksekusi Delete
 */
require_once '../../config/database.php';
 
// 1. Verifikasi ID Buku dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?error=Penghapusan dicegah. Parameter ID tidak terdeteksi.");
    exit();
}
 
$id_buku = (int)$_GET['id'];
 
// 2. Baca judul buku untuk pesan notifikasi sebelum dihapus permanen
$stmt = $conn->prepare("SELECT judul FROM buku WHERE id_buku = ?");
$stmt->bind_param("i", $id_buku);
$stmt->execute();
$result = $stmt->get_result();
 
if ($result->num_rows == 0) {
    $stmt->close();
    closeConnection();
    header("Location: index.php?error=Gagal menghapus. Data buku tersebut sudah tidak ada di database.");
    exit();
}
 
$buku = $result->fetch_assoc();
$judul_buku = $buku['judul'];
$stmt->close();
 
// 3. Lakukan Eksekusi DELETE dari Server Database
$stmt = $conn->prepare("DELETE FROM buku WHERE id_buku = ?");
$stmt->bind_param("i", $id_buku);
 
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        $stmt->close();
        closeConnection();
        // Redirect bawa pesan sukses
        header("Location: index.php?success=" . urlencode("Sistem telah menghapus permanen buku '$judul_buku' dari arsip."));
        exit();
    } else {
        $stmt->close();
        closeConnection();
        header("Location: index.php?error=Kegagalan teknis. Tidak ada data yang terhapus.");
        exit();
    }
} else {
    $error = $stmt->error;
    $stmt->close();
    closeConnection();
    header("Location: index.php?error=" . urlencode("Kegagalan Server Database: $error"));
    exit();
}
?>