-- =========================================================================
-- NAMA : M. Rafi Risqiyanto
-- NIM  : 60324001
-- TUGAS 2 : Desain Database Lengkap (+ BONUS Soft Delete, Tabel Rak, Procedure)
-- =========================================================================

-- 1. Buat Database Baru dan Gunakan
CREATE DATABASE perpustakaan_lengkap;
USE perpustakaan_lengkap;

-- =========================================================================
-- A. DDL (DATA DEFINITION LANGUAGE) - Membuat Tabel
-- =========================================================================

-- Tabel Kategori (Bonus: is_deleted)
CREATE TABLE kategori_buku (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL UNIQUE,
    deskripsi TEXT,
    is_deleted BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Penerbit (Bonus: is_deleted)
CREATE TABLE penerbit (
    id_penerbit INT AUTO_INCREMENT PRIMARY KEY,
    nama_penerbit VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(15),
    email VARCHAR(100),
    is_deleted BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- [BONUS] Tabel Rak Buku
CREATE TABLE rak (
    id_rak INT AUTO_INCREMENT PRIMARY KEY,
    nama_rak VARCHAR(50) NOT NULL,
    lokasi VARCHAR(100),
    is_deleted BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Modifikasi Tabel Buku (Menggunakan Foreign Key & Bonus is_deleted)
CREATE TABLE buku (
    id_buku INT AUTO_INCREMENT PRIMARY KEY,
    kode_buku VARCHAR(20) UNIQUE NOT NULL,
    judul VARCHAR(200) NOT NULL,
    id_kategori INT NOT NULL,
    id_penerbit INT NOT NULL,
    id_rak INT, -- Relasi ke tabel rak
    pengarang VARCHAR(100) NOT NULL,
    tahun_terbit INT NOT NULL,
    isbn VARCHAR(20),
    harga DECIMAL(10,2) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    is_deleted BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kategori) REFERENCES kategori_buku(id_kategori),
    FOREIGN KEY (id_penerbit) REFERENCES penerbit(id_penerbit),
    FOREIGN KEY (id_rak) REFERENCES rak(id_rak)
);

-- =========================================================================
-- B. DML (DATA MANIPULATION LANGUAGE) - Insert Data Sample
-- =========================================================================

-- Insert 5 Kategori
INSERT INTO kategori_buku (nama_kategori, deskripsi) VALUES 
('Programming', 'Buku terkait bahasa pemrograman dan rekayasa perangkat lunak'),
('Database', 'Buku terkait desain dan manajemen basis data'),
('Web Design', 'Buku terkait desain UI/UX dan frontend web'),
('Networking', 'Buku terkait jaringan komputer dan server'),
('Cyber Security', 'Buku terkait keamanan siber dan kriptografi');

-- Insert 5 Penerbit
INSERT INTO penerbit (nama_penerbit, alamat, telepon, email) VALUES 
('Informatika Bandung', 'Jl. Buah Batu No. 1, Bandung', '022123456', 'info@informatika.com'),
('Graha Ilmu', 'Jl. Mataram No. 9, Yogyakarta', '0274123456', 'redaksi@grahailmu.com'),
('Andi Offset', 'Jl. Beo No. 38, Yogyakarta', '0274654321', 'info@andipublisher.com'),
('Elex Media Komputindo', 'Gedung Kompas, Palmerah, Jakarta', '021987654', 'redaksi@elexmedia.id'),
('Erlangga', 'Jl. Baping Raya No. 100, Jakarta', '021555666', 'support@erlangga.co.id');

-- Insert 3 Rak (Bonus)
INSERT INTO rak (nama_rak, lokasi) VALUES 
('Rak A1', 'Lantai 1, Lorong Kanan'),
('Rak B2', 'Lantai 1, Lorong Tengah'),
('Rak C3', 'Lantai 2, Ruang Referensi');

-- Insert 15 Buku dengan Relasi (id_kategori, id_penerbit, id_rak)
INSERT INTO buku (kode_buku, judul, id_kategori, id_penerbit, id_rak, pengarang, tahun_terbit, harga, stok) VALUES 
('BK-101', 'Belajar PHP dari Nol', 1, 1, 1, 'Budi Raharjo', 2023, 85000, 10),
('BK-102', 'Mastering MySQL', 2, 2, 2, 'Andi Nugroho', 2022, 95000, 5),
('BK-103', 'UI/UX Design', 3, 3, 1, 'Dedi Santoso', 2021, 120000, 7),
('BK-104', 'Cisco Networking', 4, 4, 3, 'Rina Wijaya', 2020, 150000, 3),
('BK-105', 'Hacking Exposed', 5, 5, 3, 'Ilham Saputra', 2024, 200000, 8),
('BK-106', 'Laravel Framework', 1, 1, 1, 'Siti Aminah', 2024, 110000, 12),
('BK-107', 'PostgreSQL Advanced', 2, 2, 2, 'Ahmad Yani', 2023, 130000, 4),
('BK-108', 'CSS & HTML5', 3, 3, 1, 'Budi Raharjo', 2022, 75000, 15),
('BK-109', 'Linux Server', 4, 4, 3, 'Rina Wijaya', 2021, 140000, 6),
('BK-110', 'Web Penetration Testing', 5, 5, 3, 'Ilham Saputra', 2023, 180000, 9),
('BK-111', 'Python for Data Science', 1, 4, 2, 'Siti Aminah', 2024, 160000, 11),
('BK-112', 'MongoDB Guide', 2, 1, 2, 'Andi Nugroho', 2020, 90000, 2),
('BK-113', 'Figma Tutorial', 3, 5, 1, 'Dedi Santoso', 2023, 95000, 5),
('BK-114', 'MikroTik Router', 4, 2, 3, 'Ahmad Yani', 2022, 105000, 8),
('BK-115', 'Cryptography Basics', 5, 3, 3, 'Budi Raharjo', 2021, 115000, 10);

-- =========================================================================
-- C. QUERY WAJIB
-- =========================================================================

-- 1. JOIN untuk tampilkan buku dengan nama kategori dan penerbit
SELECT 
    b.judul, 
    k.nama_kategori, 
    p.nama_penerbit
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit
WHERE b.is_deleted = FALSE;

-- 2. Jumlah buku per kategori
SELECT 
    k.nama_kategori, 
    COUNT(b.id_buku) as jumlah_buku
FROM kategori_buku k
LEFT JOIN buku b ON k.id_kategori = b.id_kategori AND b.is_deleted = FALSE
GROUP BY k.id_kategori;

-- 3. Jumlah buku per penerbit
SELECT 
    p.nama_penerbit, 
    COUNT(b.id_buku) as jumlah_buku
FROM penerbit p
LEFT JOIN buku b ON p.id_penerbit = b.id_penerbit AND b.is_deleted = FALSE
GROUP BY p.id_penerbit;

-- 4. Buku beserta detail lengkap (kategori + penerbit + rak)
SELECT 
    b.kode_buku, 
    b.judul, 
    k.nama_kategori, 
    p.nama_penerbit, 
    r.nama_rak,
    b.pengarang, 
    b.harga, 
    b.stok
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit
LEFT JOIN rak r ON b.id_rak = r.id_rak
WHERE b.is_deleted = FALSE;

-- =========================================================================
-- D. BONUS STORED PROCEDURE
-- =========================================================================

-- Membuat Stored Procedure untuk melakukan Soft Delete pada Buku
DELIMITER //
CREATE PROCEDURE SoftDeleteBuku(IN target_id INT)
BEGIN
    UPDATE buku SET is_deleted = TRUE WHERE id_buku = target_id;
END //
DELIMITER ;

-- Cara memanggil procedure (Hanya untuk dicatat, tidak perlu dieksekusi sekarang)
-- CALL SoftDeleteBuku(1);