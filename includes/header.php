<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Perpustakaan Rafi'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }
        main {
            flex: 1;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="/perpustakaan/">
                <i class="bi bi-book-half"></i> Sistem Perpustakaan Rafi
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/perpustakaan/modules/buku/index.php">
                            <i class="bi bi-journal-text"></i> Kelola Data Buku (CRUD)
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <main class="py-4">
        <div class="container mb-3">
            <div class="alert alert-dark text-center shadow-sm py-2 mb-0">
                <strong>M. Rafi Risqiyanto | 60324001</strong> - Pertemuan 7 (PHP-MySQL Integration)
            </div>
        </div>