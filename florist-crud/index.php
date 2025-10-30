<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

 $database = new Database();
 $db = $database->getConnection();

if ($db === null) {
    echo '<div class="container mt-4"><div class="alert alert-danger">Tidak dapat terhubung ke database.</div></div>';
    require_once 'includes/footer.php';
    exit();
}

 $search = isset($_GET['search']) ? sanitize($_GET['search']) : '';
 $category_filter = isset($_GET['category']) ? sanitize($_GET['category']) : '';
 $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
 $per_page = 6;

 $count_query = "SELECT COUNT(*) as total FROM flowers WHERE 1=1";
 $params = [];
if (!empty($search)) {
    $count_query .= " AND (name LIKE :search OR latin_name LIKE :search OR description LIKE :search)";
    $params[':search'] = "%{$search}%";
}
if (!empty($category_filter)) {
    $count_query .= " AND category = :category";
    $params[':category'] = $category_filter;
}

 $stmt = $db->prepare($count_query);
 $stmt->execute($params);
 $total_records = $stmt->fetch()['total'];
 $pagination = paginate($total_records, $per_page, $page);

 $query = "SELECT * FROM flowers WHERE 1=1";
if (!empty($search)) {
    $query .= " AND (name LIKE :search OR latin_name LIKE :search OR description LIKE :search)";
}
if (!empty($category_filter)) {
    $query .= " AND category = :category";
}
 $query .= " ORDER BY created_at DESC LIMIT :offset, :per_page";

 $stmt = $db->prepare($query);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
 $stmt->bindParam(':offset', $pagination['offset'], PDO::PARAM_INT);
 $stmt->bindParam(':per_page', $pagination['per_page'], PDO::PARAM_INT);
 $stmt->execute();
?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="bi bi-flower2 me-2"></i>Katalog Bunga</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="pages/create.php" class="btn btn-pink"><i class="bi bi-plus-circle me-1"></i> Tambah Bunga Baru</a>    
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <form action="index.php" method="GET" class="d-flex search-bar">
            <input class="form-control me-2" type="search" name="search" placeholder="Cari nama atau latin bunga..." value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
            <?php if (!empty($search) || !empty($category_filter)): ?>
                <a href="index.php" class="btn btn-outline-secondary ms-2">Clear</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="col-md-6">
        <form action="index.php" method="GET" class="d-flex">
            <select name="category" class="form-select me-2" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                <option value="Bunga Potong" <?php echo ($category_filter == 'Bunga Potong') ? 'selected' : ''; ?>>Bunga Potong</option>
                <option value="Tanaman Hias" <?php echo ($category_filter == 'Tanaman Hias') ? 'selected' : ''; ?>>Tanaman Hias</option>
                <option value="Buket" <?php echo ($category_filter == 'Buket') ? 'selected' : ''; ?>>Buket</option>
                <option value="Karangan Bunga" <?php echo ($category_filter == 'Karangan Bunga') ? 'selected' : ''; ?>>Karangan Bunga</option>
            </select>
            <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
        </form>
    </div>
</div>

<div class="row">
    <?php if ($stmt->rowCount() > 0): ?>
        <?php while ($flower = $stmt->fetch()): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?php echo htmlspecialchars($flower['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($flower['name']); ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($flower['name']); ?></h5>
                        <p class="card-text flex-grow-1"><?php echo substr(htmlspecialchars($flower['description']), 0, 80) . '...'; ?></p>
                        <div class="mb-2">
                            <span class="badge bg-secondary"><?php echo htmlspecialchars($flower['category']); ?></span>
                            <span class="badge bg-info text-dark"><?php echo htmlspecialchars($flower['color']); ?></span>
                        </div>
                        <p class="card-text price-tag"><?php echo formatRupiah($flower['price']); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="pages/view.php?id=<?php echo $flower['id']; ?>" class="btn btn-sm btn-info"><i class="bi bi-eye me-1"></i> Lihat</a>
                            <div>
                                <a href="pages/edit.php?id=<?php echo $flower['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil me-1"></i></a>
                                <a href="pages/delete.php?id=<?php echo $flower['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus bunga ini?')"><i class="bi bi-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle me-2"></i>Tidak ada bunga yang ditemukan.
            </div>
        </div>
    <?php endif; ?>
</div>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php if ($pagination['current_page'] > 1): ?>
            <li class="page-item">
                <a class="page-link" href="index.php?page=<?php echo $pagination['current_page'] - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($category_filter) ? '&category=' . urlencode($category_filter) : ''; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
            <li class="page-item <?php echo ($i == $pagination['current_page']) ? 'active' : ''; ?>">
                <a class="page-link" href="index.php?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($category_filter) ? '&category=' . urlencode($category_filter) : ''; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        
        <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
            <li class="page-item">
                <a class="page-link" href="index.php?page=<?php echo $pagination['current_page'] + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($category_filter) ? '&category=' . urlencode($category_filter) : ''; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?php require_once 'includes/footer.php'; ?>