<?php
require_once __DIR__ . '/helpers.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: dashboard.php'); exit; }
if (!verify_csrf($_POST['csrf'] ?? '')) { die('CSRF token invalid'); }

$fname = sanitize_filename($_POST['file'] ?? '');
$path = UPLOAD_DIR . '/' . $fname;
if ($fname === '' || !is_file($path)) {
    die('Invalid file.');
}
if (@unlink($path)) {
    header('Location: dashboard.php');
    exit;
} else {
    include __DIR__ . '/header.php';
    echo '<h2>Delete Failed</h2><p class="notice" style="border-color:#ef4444;background:rgba(239,68,68,.08)">Could not delete file.</p><p><a class="btn" href="dashboard.php">Go back</a></p>';
    include __DIR__ . '/footer.php';
}