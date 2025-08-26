<?php
require_once __DIR__ . '/helpers.php';
if (is_logged_in()) { header('Location: dashboard.php'); exit; }

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');
    if (hash_equals(USERNAME, $user) && hash_equals(PASSWORD, $pass)) {
        $_SESSION['logged_in'] = true;
        // rotate CSRF per login
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        header('Location: dashboard.php');
        exit;
    } else {
        $err = 'Invalid credentials';
    }
}
include __DIR__ . '/header.php';
?>
  <h2 style="margin-top:0">Welcome back</h2>
  <p class="muted">Login to access your private storage.</p>
  <?php if ($err): ?><p class="notice" style="border-color:#ef4444;background:rgba(239,68,68,.08)"><?php echo htmlspecialchars($err); ?></p><?php endif; ?>
  <form method="post" class="grid two" autocomplete="off">
    <div>
      <label>Username</label>
      <input type="text" name="username" required>
    </div>
    <div>
      <label>Password</label>
      <input type="password" name="password" required>
    </div>
    <div>
      <button class="btn" type="submit">Login</button>
    </div>
  </form>
<?php include __DIR__ . '/footer.php'; ?>