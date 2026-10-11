<?php
/**
 * Khushi Enterprises - Products Catalog API
 * Returns list of wholesale products from Database or local JSON
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../config/db.php';

$category = isset($_GET['category']) ? trim($_GET['category']) : 'all';
$search   = isset($_GET['q']) ? trim($_GET['q']) : '';

$pdo = getDBConnection();
$products = [];

if ($pdo !== null) {
    try {
        $sql = "SELECT id, name, category, category_label as categoryLabel, brand, description, image, wholesale_only as wholesaleOnly, min_order_note as minOrderNote, whatsapp_message as whatsappMessage FROM products WHERE is_active = 1";
        $params = [];

        if ($category !== 'all') {
            $sql .= " AND category = :category";
            $params[':category'] = $category;
        }

        if (!empty($search)) {
            $sql .= " AND (name LIKE :s1 OR description LIKE :s2 OR brand LIKE :s3)";
            $params[':s1'] = "%{$search}%";
            $params[':s2'] = "%{$search}%";
            $params[':s3'] = "%{$search}%";
        }

        $sql .= " ORDER BY id ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll();
    } catch (Exception $e) {
        $products = [];
    }
}

// Fallback to local products.json if DB query returned empty or DB is offline
if (empty($products)) {
    $jsonFile = __DIR__ . '/products.json';
    if (file_exists($jsonFile)) {
        $data = json_decode(file_get_contents($jsonFile), true) ?: [];
        $products = $data;

        if ($category !== 'all') {
            $products = array_filter($products, function($p) use ($category) {
                return isset($p['category']) && $p['category'] === $category;
            });
        }

        if (!empty($search)) {
            $q = mb_strtolower($search);
            $products = array_filter($products, function($p) use ($q) {
                return (isset($p['name']) && mb_stripos($p['name'], $q) !== false) ||
                       (isset($p['description']) && mb_stripos($p['description'], $q) !== false) ||
                       (isset($p['brand']) && mb_stripos($p['brand'], $q) !== false);
            });
        }
        $products = array_values($products);
    }
}

echo json_encode([
    'success' => true,
    'count'   => count($products),
    'data'    => $products
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
