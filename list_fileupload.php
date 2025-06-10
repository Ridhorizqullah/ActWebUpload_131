<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar File</title>
  <style>
    body {
      font-family: sans-serif;
      background: #f8fafc;
      padding: 40px;
    }
    .container {
      width: 600px;
      margin: auto;
      background: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
    }
    .file {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #e2e8f0;
      padding: 10px 0;
    }
    .file img {
      width: 40px;
      height: 40px;
      object-fit: cover;
      border-radius: 4px;
      margin-right: 10px;
    }
    .file .name {
      flex: 1;
    }
    .btn {
      border: none;
      padding: 6px 10px;
      color: white;
      border-radius: 6px;
      margin-left: 5px;
      cursor: pointer;
    }
    .download { background-color: #16a34a; }
    .hapus { background-color: #dc2626; }
  </style>
</head>
<body>
  <div class="container">
    <h2>📁 Daftar File yang Telah Diupload</h2>
    <div style="text-align:right; margin-bottom:15px;">
      <a href="index.html">
        <button style="background:#3b82f6; color:white; border:none; padding:8px 15px; border-radius:6px; cursor:pointer;">
          ⬆️ Upload Lagi
        </button>
      </a>
    </div>

    <?php
    $dir = "uploads/";
    if (!is_dir($dir)) {
        echo "<p>Folder <code>uploads/</code> tidak ditemukan!</p>";
        exit;
    }

    $files = array_diff(scandir($dir), array('.', '..'));
    if (empty($files)) {
        echo "<p>Tidak ada file yang diunggah.</p>";
    } else {
        foreach ($files as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $icon = "";

            if (in_array(strtolower($ext), ['png', 'jpg', 'jpeg'])) {
                $icon = "<img src='uploads/$file'>";
            } else {
                $icon = "📄";
            }

            echo "
            <div class='file'>
              <div class='name'>$icon <a href='uploads/$file' target='_blank'>$file</a></div>
              <div>
                <a href='uploads/$file' download><button class='btn download'>Unduh</button></a>
                <a href='delete.php?file=$file'><button class='btn hapus'>Hapus</button></a>
              </div>
            </div>";
        }
    }
    ?>
  </div>
</body>
</html>
 