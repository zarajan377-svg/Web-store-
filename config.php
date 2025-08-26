<?php
// ====== BASIC CONFIG ======
// Change these for your own credentials
define('APP_TITLE', 'Mr.Arslan'); // Shown in the header
define('USERNAME', 'arslan0299');     // ← set your username
define('PASSWORD', 'Zara0299='); // ← set a strong password

// Max upload size (in bytes). Example: 200 * 1024 * 1024 = 200 MB
define('MAX_FILE_BYTES', 200 * 1024 * 1024);

// Upload directory (relative to this file)
define('UPLOAD_DIR', __DIR__ . '/uploads');

// Allowed extensions (lowercase, without dot). Keep restrictive.
$ALLOWED_EXTS = [
    'jpg','jpeg','png','gif','webp','bmp','svg',
    'mp4','mov','m4v','avi','mkv','wmv',
    'mp3','wav','m4a','ogg',
    'pdf','txt','csv','zip','rar','7z','doc','docx','xls','xlsx','ppt','pptx'
];

// Blocked extensions (extra safety)
$BLOCKED_EXTS = ['php','phtml','phar','cgi','pl','jsp','asp','aspx','js','html','htm','sh','bat','cmd'];

// Session settings
ini_set('session.use_strict_mode', 1);
session_name('arslan_session');
session_start();

// Ensure uploads dir & protect it
if (!is_dir(UPLOAD_DIR)) {
    @mkdir(UPLOAD_DIR, 0755, true);
}
// Add an index.html to prevent listing (for hosts that ignore .htaccess)
$indexPath = UPLOAD_DIR . '/index.html';
if (!file_exists($indexPath)) {
    file_put_contents($indexPath, "");
}
// Add .htaccess to disable script execution (works on Apache)
$htPath = UPLOAD_DIR . '/.htaccess';
if (!file_exists($htPath)) {
    @file_put_contents($htPath, "Options -Indexes\nphp_flag engine off\nRemoveHandler .php .phtml .php3 .php4 .php5 .php7 .php8\nAddType text/plain .php .phtml .php3 .php4 .php5 .php7 .php8\n");
}