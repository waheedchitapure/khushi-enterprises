<?php
/**
 * Khushi Enterprises - Simple B2B Admin Dashboard
 * Securely view and export wholesale customer enquiries
 */

session_start();
require_once __DIR__ . '/../config/db.php';

// Simple password protection (Default password: khushi2026 - change as needed)
define('ADMIN_PASSWORD', 'khushi2026');

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['khushi_logged_in']) || $_SESSION['khushi_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Fetch enquiries from MySQL or JSON fallback
$enquiries = [];
$pdo = getDBConnection();
if ($pdo !== null) {
    try {
        $stmt = $pdo->query("SELECT * FROM enquiries ORDER BY id DESC");
        $enquiries = $stmt->fetchAll();
    } catch (Exception $e) {
        $enquiries = [];
    }
}

if (empty($enquiries)) {
    $dataFile = __DIR__ . '/../api/enquiries.json';
    if (file_exists($dataFile)) {
        $enquiries = json_decode(file_get_contents($dataFile), true) ?: [];
        $enquiries = array_reverse($enquiries);
    }
}

// CSV Export Action
if (isset($_GET['action']) && $_GET['action'] === 'export') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=Khushi_Enterprises_Enquiries_' . date('Y-m-d') . '.csv');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['ID', 'Name', 'Shop Name', 'Phone', 'City', 'Requirement', 'Date']);
    foreach ($enquiries as $row) {
        fputcsv($out, [
            $row['id'] ?? '',
            $row['name'] ?? '',
            $row['shop_name'] ?? '',
            $row['phone'] ?? '',
            $row['city'] ?? '',
            $row['message'] ?? '',
            $row['created_at'] ?? ''
        ]);
    }
    fclose($out);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Khushi Enterprises Admin | Enquiries</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f8fafc; color: #0f172a; margin: 0; padding: 20px; }
    .header { display: flex; justify-content: space-between; align-items: center; background: #0a1d37; color: #fff; padding: 16px 24px; border-radius: 10px; margin-bottom: 24px; border-bottom: 3px solid #c69234; }
    .header h1 { font-size: 20px; margin: 0; }
    .header a { color: #f9f4ea; text-decoration: none; font-size: 14px; margin-left: 12px; background: rgba(255,255,255,0.1); padding: 6px 12px; border-radius: 6px; }
    .header a:hover { background: #c69234; color: #fff; }
    .card { background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; }
    .table-wrap { overflow-x: auto; margin-top: 14px; }
    table { width: 100%; border-collapse: collapse; font-size: 14px; text-align: left; }
    th { background: #f1f5f9; padding: 12px; border-bottom: 2px solid #cbd5e1; color: #0a1d37; }
    td { padding: 12px; border-bottom: 1px solid #e2e8f0; }
    tr:hover { background: #f8fafc; }
    .wa-link { color: #16a34a; font-weight: 700; text-decoration: none; }
    .wa-link:hover { text-decoration: underline; }
    .badge { background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 999px; font-size: 11px; font-weight: 700; }
  </style>
</head>
<body>

  <div class="header">
    <div>
      <h1>Khushi Enterprises — Wholesale Enquiry Manager</h1>
      <span style="font-size: 12px; color: #dcb059;">Kondhwa, Pune | Total Enquiries: <?= count($enquiries) ?></span>
    </div>
    <div>
      <a href="?action=export">📥 Export to Excel / CSV</a>
      <a href="../index.html" target="_blank">🌐 View Website</a>
      <a href="?action=logout" style="background: #dc2626;">Logout</a>
    </div>
  </div>

  <div class="card">
    <h2>Customer Requirements & Wholesale Orders</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Date & Time</th>
            <th>Contact Person</th>
            <th>Shop / Firm Name</th>
            <th>Phone / WhatsApp</th>
            <th>City / Area</th>
            <th>Product Requirement</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($enquiries)): ?>
            <tr>
              <td colspan="8" style="text-align: center; padding: 30px; color: #64748b;">
                Abhi tak koi nayi enquiry receive nahi hui hai.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($enquiries as $row): ?>
              <tr>
                <td><strong>#<?= htmlspecialchars($row['id'] ?? '') ?></strong></td>
                <td style="white-space: nowrap;"><?= htmlspecialchars($row['created_at'] ?? '') ?></td>
                <td><strong><?= htmlspecialchars($row['name'] ?? '') ?></strong></td>
                <td><span class="badge"><?= htmlspecialchars($row['shop_name'] ?? 'Direct Retailer') ?></span></td>
                <td>
                  <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $row['phone'] ?? '') ?>" target="_blank" class="wa-link">
                    <?= htmlspecialchars($row['phone'] ?? '') ?> (WhatsApp)
                  </a>
                </td>
                <td><?= htmlspecialchars($row['city'] ?? 'Pune') ?></td>
                <td><?= nl2br(htmlspecialchars($row['message'] ?? '')) ?></td>
                <td>
                  <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $row['phone'] ?? '') ?>?text=<?= urlencode('Hello ' . ($row['name'] ?? '') . ', Khushi Enterprises Pune ki taraf se message hai aapki requirement ke baare me.') ?>" target="_blank" style="background: #25d366; color: #fff; padding: 4px 10px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: bold; white-space: nowrap;">
                    Reply on WhatsApp
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
