<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/header.php';

 $database = new Database();
 $db = $database->getConnection();

if ($db === null || !isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = "Akses tidak valid.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../index.php");
    exit();
}

 $id = (int)$_GET['id'];
 $query = "SELECT * FROM flowers WHERE id = :id";
 $stmt = $db->prepare($query);
 $stmt->bindParam(':id', $id);
 $stmt->execute();

if ($stmt->rowCount() === 0) {
    $_SESSION['message'] = "Bunga tidak ditemukan.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../index.php");
    exit();
}

 $flower = $stmt->fetch();
?>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header bg-pink text-white d-flex justify-content-between align-items-center">
                <h3><i class="bi bi-flower1 me-2"></i>Detail Bunga</h3>
                <div>
                    <a href="edit.php?id=<?php echo $flower['id']; ?>" class="btn btn-warning"><i class="bi bi-pencil me-1"></i> Edit</a>
                    <a href="delete.php?id=<?php echo $flower['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus bunga ini?')"><i class="bi bi-trash me-1"></i> Hapus</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <img src="<?php echo htmlspecialchars($flower['image_url']); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($flower['name']); ?>">
                    </div>
                    <div class="col-md-7">
                        <h2 class="card-title"><?php echo htmlspecialchars($flower['name']); ?></h2>
                        <p class="text-muted fst-italic"><?php echo htmlspecialchars($flower['latin_name']); ?></p>
                        
                        <div class="mb-3">
                            <span class="badge bg-secondary fs-6"><?php echo htmlspecialchars($flower['category']); ?></span>
                            <span class="badge bg-info text-dark fs-6"><?php echo htmlspecialchars($flower['color']); ?></span>
                        </div>
                        
                        <p class="card-text fs-5"><?php echo nl2br(htmlspecialchars($flower['description'])); ?></p>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <span class="detail-label">Harga:</span>
                                <p class="price-tag"><?php echo formatRupiah($flower['price']); ?></p>
                            </div>
                            <div class="col-sm-4">
                                <span class="detail-label">Stok:</span>
                                <p><?php echo htmlspecialchars($flower['stock']); ?> pcs</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="../index.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog</a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>