<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Florist Shop - Kelola Bunga Anda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- PERBAIKAN 1: Kode warna diperbaiki -->
    <nav class="navbar navbar-expand-lg shadow-sm" style="background-color: #ffe1f0;">    
        <div class="container">
            <!-- PERBAIKAN 2: Tambahkan style warna font langsung ke brand -->
            <a class="navbar-brand fw-bold" href="index.php" style="color: #95537f;">
                <i class="bi bi-flower1 me-2"></i>Florist Shop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <!-- PERBAIKAN 3: Tambahkan style warna font langsung ke link -->
                        <a class="nav-link" href="index.php" style="color: #95537f;"><i class="bi bi-house me-1"></i> Katalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/create.php" style="color: #95537f;"><i class="bi bi-plus-circle me-1"></i> Tambah Bunga</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>