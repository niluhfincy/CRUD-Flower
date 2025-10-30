<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

 $database = new Database();
 $db = $database->getConnection();

if ($db === null || !isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = "Akses tidak valid.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../index.php");
    exit();
}

 $id = (int)$_GET['id'];
 $query = "SELECT id FROM flowers WHERE id = :id";
 $stmt = $db->prepare($query);
 $stmt->bindParam(':id', $id);
 $stmt->execute();

if ($stmt->rowCount() === 0) {
    $_SESSION['message'] = "Bunga tidak ditemukan.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../index.php");
    exit();
}

try {
    $query = "DELETE FROM flowers WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Bunga berhasil dihapus!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal menghapus bunga.";
        $_SESSION['message_type'] = "danger";
    }
} catch (PDOException $e) {
    $_SESSION['message'] = "Database error.";
    $_SESSION['message_type'] = "danger";
}

header("Location: ../index.php");
exit();
?>