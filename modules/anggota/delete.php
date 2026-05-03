<?php
require_once '../../config/database.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_anggota = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT nama, foto FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id_anggota);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $agt = $res->fetch_assoc();
    $nama = $agt['nama'];
    
    if(!empty($agt['foto']) && file_exists('uploads/' . $agt['foto'])) {
        unlink('uploads/' . $agt['foto']); // Hapus file fisik foto
    }

    $stmt_del = $conn->prepare("DELETE FROM anggota WHERE id_anggota = ?");
    $stmt_del->bind_param("i", $id_anggota);
    
    if($stmt_del->execute()) {
        header("Location: index.php?success=" . urlencode("Anggota '$nama' berhasil dihapus."));
    } else {
        header("Location: index.php?error=Gagal menghapus data.");
    }
    $stmt_del->close();
} else {
    header("Location: index.php?error=Data tidak ditemukan.");
}

$stmt->close();
closeConnection();
?>