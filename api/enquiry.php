<?php
/**
 * Khushi Enterprises - Wholesale Enquiry Processing API
 * Securely handles B2B contact and quotation submissions
 */

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

require_once __DIR__ . '/../config/db.php';

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

// Sanitize & Validate Input
$name      = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$shop_name = trim(filter_input(INPUT_POST, 'shop_name', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$phone     = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$city      = trim(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$message   = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');

// Simple honeypot anti-spam check
$honeypot  = trim(filter_input(INPUT_POST, 'website_url', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
if (!empty($honeypot)) {
    // Spam bot trapped
    echo json_encode(['success' => true, 'message' => 'Enquiry received.']);
    exit;
}

if (empty($name) || empty($phone) || empty($message)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Kripya apna Naam, Phone number aur requirement message zaroor bharein.'
    ]);
    exit;
}

$ip_address = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
$user_agent = substr($_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN', 0, 250);
$created_at = date('Y-m-d H:i:s');

$saved = false;
$pdo = getDBConnection();

if ($pdo !== null) {
    // Save to MySQL Database
    try {
        $stmt = $pdo->prepare("INSERT INTO enquiries (name, shop_name, phone, city, message, ip_address, user_agent, created_at) 
                               VALUES (:name, :shop_name, :phone, :city, :message, :ip_address, :user_agent, :created_at)");
        $saved = $stmt->execute([
            ':name'       => $name,
            ':shop_name'  => $shop_name,
            ':phone'      => $phone,
            ':city'       => $city,
            ':message'    => $message,
            ':ip_address' => $ip_address,
            ':user_agent' => $user_agent,
            ':created_at' => $created_at
        ]);
    } catch (Exception $e) {
        $saved = false;
    }
}

// Fallback / Concurrent JSON Logging
$dataFile = __DIR__ . '/enquiries.json';
$existing = [];
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $existing = json_decode($json, true) ?: [];
}

$newRecord = [
    'id'         => count($existing) + 1,
    'name'       => $name,
    'shop_name'  => $shop_name,
    'phone'      => $phone,
    'city'       => $city,
    'message'    => $message,
    'ip_address' => $ip_address,
    'created_at' => $created_at
];

$existing[] = $newRecord;
file_put_contents($dataFile, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
$saved = true;

// Optional Email Notification to Business Owner
$mailBody = "New Wholesale Requirement from Website:\n\n" .
            "Name: {$name}\n" .
            "Shop: {$shop_name}\n" .
            "Phone: {$phone}\n" .
            "City: {$city}\n" .
            "Message: {$message}\n\n" .
            "Received: {$created_at}\n" .
            "Khushi Enterprises Website";

$headers = "From: no-reply@" . ($_SERVER['SERVER_NAME'] ?? 'khushienterprises.com') . "\r\n" .
           "Reply-To: {$phone}\r\n" .
           "X-Mailer: PHP/" . phpversion();

@mail(ADMIN_EMAIL, "New Wholesale Enquiry from {$shop_name} ({$name})", $mailBody, $headers);

echo json_encode([
    'success' => true,
    'message' => 'Dhanyawad! Aapki requirement submit ho gayi hai. Khushi Enterprises aapse jald hi WhatsApp/Call par best wholesale rate list ke sath contact karega.'
]);
