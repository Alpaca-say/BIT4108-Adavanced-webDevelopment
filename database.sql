<?php
// php/products.php - Product CRUD API
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'list':
        getProducts();
        break;
    case 'get':
        getProduct($_GET['id'] ?? 0);
        break;
    case 'add':
        requireLogin();
        addProduct();
        break;
    case 'update':
        requireLogin();
        updateProduct();
        break;
    case 'delete':
        requireLogin();
        deleteProduct($_POST['id'] ?? $_GET['id'] ?? 0);
        break;
    case 'categories':
        getCategories();
        break;
    default:
        getProducts();
}

function getProducts() {
    global $pdo;
    $category = $_GET['category'] ?? '';
    $search   = $_GET['search'] ?? '';
    $sort     = $_GET['sort'] ?? 'id';

    $sortMap = ['price_asc' => 'p.price ASC', 'price_desc' => 'p.price DESC', 'name' => 'p.name ASC', 'id' => 'p.id ASC'];
    $orderBy = $sortMap[$sort] ?? 'p.id ASC';

    $sql = 'SELECT p.*, c.name AS category_name, c.slug AS category_slug
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE 1=1';
    $params = [];

    if ($category) {
        $sql .= ' AND c.slug = ?';
        $params[] = $category;
    }
    if ($search) {
        $sql .= ' AND (p.name LIKE ? OR p.description LIKE ?)';
        $params[] = "%$search%";
        $params[] = "%$search%";
    }

    $sql .= " ORDER BY $orderBy";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();

    jsonResponse(['success' => true, 'products' => $products]);
}

function getProduct($id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = ?');
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    if (!$product) jsonResponse(['success' => false, 'message' => 'Product not found.'], 404);
    jsonResponse(['success' => true, 'product' => $product]);
}

function addProduct() {
    global $pdo;
    $name        = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = floatval($_POST['price'] ?? 0);
    $category_id = intval($_POST['category_id'] ?? 0);
    $image_url   = trim($_POST['image_url'] ?? '');
    $badge       = trim($_POST['badge'] ?? '');

    if (!$name || !$price || !$category_id) {
        jsonResponse(['success' => false, 'message' => 'Name, price and category are required.']);
    }

    $stmt = $pdo->prepare('INSERT INTO products (category_id, name, description, price, image_url, badge) VALUES (?,?,?,?,?,?)');
    $stmt->execute([$category_id, $name, $description, $price, $image_url, $badge ?: null]);
    jsonResponse(['success' => true, 'message' => 'Product added!', 'id' => $pdo->lastInsertId()]);
}

function updateProduct() {
    global $pdo;
    $id          = intval($_POST['id'] ?? 0);
    $name        = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = floatval($_POST['price'] ?? 0);
    $category_id = intval($_POST['category_id'] ?? 0);
    $image_url   = trim($_POST['image_url'] ?? '');
    $badge       = trim($_POST['badge'] ?? '');

    if (!$id || !$name || !$price || !$category_id) {
        jsonResponse(['success' => false, 'message' => 'All fields required.']);
    }

    $stmt = $pdo->prepare('UPDATE products SET category_id=?, name=?, description=?, price=?, image_url=?, badge=? WHERE id=?');
    $stmt->execute([$category_id, $name, $description, $price, $image_url, $badge ?: null, $id]);
    jsonResponse(['success' => true, 'message' => 'Product updated!']);
}

function deleteProduct($id) {
    global $pdo;
    $id = intval($id);
    if (!$id) jsonResponse(['success' => false, 'message' => 'Invalid product ID.']);
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute([$id]);
    jsonResponse(['success' => true, 'message' => 'Product deleted.']);
}

function getCategories() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM categories ORDER BY name');
    jsonResponse(['success' => true, 'categories' => $stmt->fetchAll()]);
}
?>
