<?php
require_once __DIR__ . '/helpers.php';
require_login();
$token = csrf_token();
$files = list_files_sorted();
include __DIR__ . '/header.php';
?>
  <h2 style="margin-top:0">Your Files</h2>
  <p class="muted">Upload new files and manage existing items. Max per-file: <span class="badge"><?php echo human_filesize(MAX_FILE_BYTES); ?></span></p>

  <form class="grid two" action="upload.php" method="post" enctype="multipart/form-data">
    <div>
      <label>Select file</label>
      <input type="file" name="file" required>
      <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($token); ?>">
    </div>
    <div style="display:flex;align-items:end"><button class="btn" type="submit">Upload</button></div>
  </form>

  <div style="margin-top:18px" class="notice">
    <strong>Tips:</strong> Avoid uploading executable files. Allowed extensions are restricted for safety.
  </div>

  <div style="margin-top:20px;overflow:auto">
    <table class="table">
      <thead>
        <tr>
          <th>File</th>
          <th>Size</th>
          <th>Modified</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php if (empty($files)): ?>
        <tr><td colspan="4" class="muted">No files yet.</td></tr>
      <?php else: foreach ($files as $f): ?>
        <tr>
          <td><?php echo htmlspecialchars($f['name']); ?></td>
          <td><?php echo human_filesize($f['size']); ?></td>
          <td><?php echo date('Y-m-d H:i', $f['mtime']); ?></td>
          <td>
            <a class="btn secondary" href="uploads/<?php echo rawurlencode($f['name']); ?>" download>Download</a>
            <form style="display:inline" method="post" action="delete.php" onsubmit="return confirm('Delete this file?');">
              <input type="hidden" name="file" value="<?php echo htmlspecialchars($f['name']); ?>">
              <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($token); ?>">
              <button class="btn secondary" type="submit">Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
<?php include __DIR__ . '/footer.php'; ?>