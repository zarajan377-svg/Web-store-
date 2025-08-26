<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars(APP_TITLE); ?> – Personal Cloud</title>
  <style>
    :root{ --bg:#0f172a; --card:#111827; --muted:#334155; --text:#e5e7eb; --brand:#22d3ee; --accent:#a78bfa; }
    *{box-sizing:border-box} body{margin:0;font-family:system-ui,Segoe UI,Roboto,Ubuntu,Arial,sans-serif;background:linear-gradient(120deg,#0f172a,#111827);color:var(--text);}
    a{color:var(--brand);text-decoration:none}
    .wrap{max-width:1100px;margin:0 auto;padding:24px}
    .nav{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
    .brand{display:flex;align-items:center;gap:12px}
    .logo{width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,var(--brand),var(--accent));box-shadow:0 8px 24px rgba(34,211,238,.3)}
    .brand h1{margin:0;font-size:20px;letter-spacing:.5px}
    .card{background:rgba(17,24,39,.7);backdrop-filter:blur(6px);border:1px solid #1f2937;border-radius:16px;padding:20px;box-shadow:0 10px 30px rgba(0,0,0,.25)}
    .btn{display:inline-flex;align-items:center;gap:8px;padding:10px 14px;background:linear-gradient(135deg,var(--brand),var(--accent));color:#0b1220;border:none;border-radius:12px;font-weight:600;cursor:pointer}
    .btn.secondary{background:#1f2937;color:#e5e7eb;border:1px solid #374151}
    .grid{display:grid;gap:16px}
    .grid.two{grid-template-columns:1fr 1fr}
    .muted{color:#cbd5e1}
    .table{width:100%;border-collapse:collapse}
    .table th,.table td{padding:10px;border-bottom:1px solid #1f2937;text-align:left}
    .badge{padding:4px 8px;border-radius:8px;background:#0b1220;border:1px solid #243041;color:#9fb3c8;font-size:12px}
    .right{display:flex;align-items:center;gap:10px}
    input[type=text], input[type=password], input[type=file]{width:100%;padding:10px;border-radius:10px;border:1px solid #374151;background:#0b1220;color:#e5e7eb}
    .foot{margin-top:30px;color:#9fb3c8;font-size:12px;text-align:center}
    .notice{border:1px dashed #3b82f6;background:rgba(59,130,246,.08);padding:10px;border-radius:10px}
    @media (max-width:780px){ .grid.two{grid-template-columns:1fr} }
  </style>
</head>
<body>
<div class="wrap">
  <div class="nav">
    <div class="brand">
      <div class="logo"></div>
      <h1><?php echo htmlspecialchars(APP_TITLE); ?> Drive</h1>
    </div>
    <div class="right">
      <?php if (is_logged_in()): ?>
        <a class="btn secondary" href="dashboard.php">Dashboard</a>
        <a class="btn secondary" href="logout.php">Logout</a>
      <?php endif; ?>
    </div>
  </div>
  <div class="card">