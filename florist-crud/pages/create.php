<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/header.php';

 $database = new Database();
 $db = $database->getConnection();

if ($db === null) {
    echo '<div class="container mt-4"><div class="alert alert-danger">Tidak dapat terhubung ke database.</div></div>';
    require_once '../includes/footer.php';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $latin_name = sanitize($_POST['latin_name']);
    $price = sanitize($_POST['price']);
    $stock = sanitize($_POST['stock']);
    $description = sanitize($_POST['description']);
    $image_url = sanitize($_POST['image_url']);
    $category = sanitize($_POST['category']);
    $color = sanitize($_POST['color']);
    
    $errors = [];
    if (empty($name)) $errors[] = "Nama bunga wajib diisi.";
    if (empty($price) || !is_numeric($price)) $errors[] = "Harga harus berupa angka.";
    if (empty($stock) || !is_numeric($stock)) $errors[] = "Stok harus berupa angka.";
    if (empty($category)) $errors[] = "Kategori wajib dipilih.";
    
    if (empty($errors)) {
        try {
            $query = "INSERT INTO flowers (name, latin_name, price, stock, description, image_url, category, color) VALUES (:name, :latin_name, :price, :stock, :description, :image_url, :category, :color)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':latin_name', $latin_name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image_url', $image_url);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':color', $color);
            
            if ($stmt->execute()) {
                $_SESSION['message'] = "Bunga berhasil ditambahkan!";
                $_SESSION['message_type'] = "success";
                header("Location: ../index.php");
                exit();
            } else {
                $errors[] = "Gagal menambahkan bunga.";
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
<div style="background-color: #ffdaecff; color: maroon; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; font-weight: bold; font-size: 1.25rem;">                <h3><i class="bi bi-plus-circle me-2"></i>Tambah Bunga Baru</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <form action="create.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Bunga</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="latin_name" class="form-label">Nama Latin</label>
                            <input type="text" class="form-control" id="latin_name" name="latin_name" value="<?php echo isset($_POST['latin_name']) ? htmlspecialchars($_POST['latin_name']) : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control" id="price" name="price" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="<?php echo isset($_POST['stock']) ? htmlspecialchars($_POST['stock']) : ''; ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="color" class="form-label">Warna</label>
                            <input type="text" class="form-control" id="color" name="color" value="<?php echo isset($_POST['color']) ? htmlspecialchars($_POST['color']) : ''; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Bunga Potong" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Bunga Potong') ? 'selected' : ''; ?>>Bunga Potong</option>
                                <option value="Tanaman Hias" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Tanaman Hias') ? 'selected' : ''; ?>>Tanaman Hias</option>
                                <option value="Buket" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Buket') ? 'selected' : ''; ?>>Buket</option>
                                <option value="Karangan Bunga" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Karangan Bunga') ? 'selected' : ''; ?>>Karangan Bunga</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="image_url" class="form-label">URL Gambar</label>
                            <input type="url" class="form-control" id="image_url" name="image_url" value="<?php echo isset($_POST['image_url']) ? htmlspecialchars($_POST['image_url']) : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="../index.php" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i> Batal</a>
                        <button type="submit" class="btn btn-danger"><i class="bi bi-check-circle me-1"></i> Simpan Bunga</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>