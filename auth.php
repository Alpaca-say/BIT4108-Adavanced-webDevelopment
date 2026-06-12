<?php
// php/cart.php - Shopping cart operations
require_once 'config.php';
requireLogin();

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'add':    addToCart();    break;
    case 'remove': removeFromCart(); break;
    case 'update': updateCart();   break;
    case 'get':    getCart();      break;
    case 'clear':  clearCart();    break;
    default: getCart();
}

function getCart() {
    global $pdo;
    $userId = $_SESSION['user_id'];
    $stmt = $pdo->prepare('
        SELECT c.id AS cart_id, c.quantity, p.id, p.name, p.price, p.image_url, p.badge
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
    ');
    $stmt->execute([$userId]);
    $items = $stmt->fetchAll();
    $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));
    jsonResponse(['success' => true, 'items' => $items, 'total' => $total, 'count' => array_sum(array_column($items, 'quantity'))]);
}

function addToCart() {
    global $pdo;
    $userId    = $_SESSION['user_id'];
    $productId = intval($_POST['product_id'] ?? 0);
    $qty       = max(1, intval($_POST['quantity'] ?? 1));

    if (!$productId) jsonResponse(['success' => false, 'message' => 'Invalid product.']);

    // Check if already in cart
    $stmt = $pdo->prepare('SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?');
    $stmt->execute([$userId, $productId]);
    $existing = $stmt->fetch();

    if ($existing) {
        $newQty = $existing['quantity'] + $qty;
        $stmt = $pdo->prepare('UPDATE cart SET quantity = ? WHERE id = ?');
        $stmt->execute([$newQty, $existing['id']]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO cart (user_id, product_id, quantity) VALUES (?,?,?)');
        $stmt->execute([$userId, $productId, $qty]);
    }
    jsonResponse(['success' => true, 'message' => 'Added to cart!']);
}

function removeFromCart() {
    global $pdo;
    $cartId = intval($_POST['cart_id'] ?? 0);
    $stmt = $pdo->prepare('DELETE FROM cart WHERE id = ? AND user_id = ?');
    $stmt->execute([$cartId, $_SESSION['user_id']]);
    jsonResponse(['success' => true, 'message' => 'Item removed.']);
}

function updateCart() {
    global $pdo;
    $cartId = intval($_POST['cart_id'] ?? 0);
    $qty    = max(1, intval($_POST['quantity'] ?? 1));
    $stmt = $pdo->prepare('UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?');
    $stmt->execute([$qty, $cartId, $_SESSION['user_id']]);
    jsonResponse(['success' => true]);
}

function clearCart() {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM cart WHERE user_id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    jsonResponse(['success' => true]);
}
?>
