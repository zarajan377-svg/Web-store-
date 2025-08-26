<?php
require_once __DIR__ . '/config.php';

function is_logged_in(): bool {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: index.php');
        exit;
    }
}

function csrf_token(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function verify_csrf($token): bool {
    return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token ?? '');
}

function sanitize_filename(string $name): string {
    // Remove path parts
    $name = basename($name);
    // Replace spaces and weird chars
    $name = preg_replace('/[^A-Za-z0-9._-]+/', '_', $name);
    // Prevent hidden dotfiles like .htaccess
    $name = ltrim($name, '.');
    if ($name === '') $name = 'file';
    return $name;
}

function ext_of(string $filename): string {
    $dot = strrpos($filename, '.');
    return $dot === false ? '' : strtolower(substr($filename, $dot + 1));
}

function is_blocked_ext(string $ext): bool {
    global $BLOCKED_EXTS; return in_array(strtolower($ext), $BLOCKED_EXTS, true);
}

function is_allowed_ext(string $ext): bool {
    global $ALLOWED_EXTS; return in_array(strtolower($ext), $ALLOWED_EXTS, true);
}

function human_filesize($bytes) {
    $units = ['B','KB','MB','GB','TB'];
    $i = 0; $bytes = max($bytes, 0);
    while ($bytes >= 1024 && $i < count($units)-1) { $bytes /= 1024; $i++; }
    return round($bytes, 2) . ' ' . $units[$i];
}

function list_files_sorted(): array {
    $files = [];
    $dir = new DirectoryIterator(UPLOAD_DIR);
    foreach ($dir as $f) {
        if ($f->isDot() || !$f->isFile()) continue;
        $path = $f->getPathname();
        $files[] = [
            'name' => $f->getFilename(),
            'size' => $f->getSize(),
            'mtime' => $f->getMTime(),
            'path' => $path,
        ];
    }
    // sort by newest first
    usort($files, function($a,$b){ return $b['mtime'] <=> $a['mtime']; });
    return $files;
}