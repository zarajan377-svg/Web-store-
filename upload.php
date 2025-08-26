<?php
require_once __DIR__ . '/helpers.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: dashboard.php'); exit; }
if (!verify_csrf($_POST['csrf'] ?? '')) { die('CSRF token invalid'); }

if (!isset($_FILES['file'])) { die('No file received'); }
$err = '';
$f = $_FILES['file'];

if ($f['error'] !== UPLOAD_ERR_OK) {
    $err = 'Upload error code: ' . $f['error'];
} elseif ($f['size'] > MAX_FILE_BYTES) {
    $err = 'File too large. Max per-file is ' . human_filesize(MAX_FILE_BYTES);
} else {
    $name = sanitize_filename($f['name']);
    $ext = ext_of($name);
    if ($ext && is_blocked_ext($ext)) {
        $err = 'This file type is not allowed.';
    } elseif ($ext && !is_allowed_ext($ext)) {
        $err = 'Extension not in allowed list.';
    } else {
        // make unique name to avoid overwrite
        $base = $ext ? substr($name, 0, -(strlen($ext)+1)) : $name;
        $final = $base . '__' . date('Ymd_His') . ($ext ? ('.' . $ext) : '');
        $dest = UPLOAD_DIR . '/' . $final;
        if (move_uploaded_file($f['tmp_name'], $dest)) {
            @chmod($dest, 0644);
            header('Location: dashboard.php');
            exit;
        } else {
            $err = 'Failed to save file.';
        }
    }
}

// If we got here, show error and link back
include __DIR__ . '/header.php';
?>
  <h2>Upload Failed</h2>
  <p class="notice" style="border-color:#ef4444;background:rgba(239,68,68,.08)"><?php echo htmlspecialchars($err); ?></p>
  <p><a class="btn" href="dashboard.php">Go back</a></p>
<?php include __DIR__ . '/footer.php'; ?>