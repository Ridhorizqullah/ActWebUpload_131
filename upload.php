<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Unggah</title>
    <style>
        /* Anda bisa menyalin CSS dari file utama untuk tampilan yang konsisten */
        :root {
            --primary: #4361ee; --background: #f8fafc; --card: #ffffff;
            --text: #1e293b; --success: #10b981; --error: #ef4444;
        }
        body {
            font-family: 'Inter', sans-serif; background-color: var(--background);
            display: flex; justify-content: center; align-items: center;
            min-height: 100vh; margin: 0; color: var(--text);
        }
        .container {
            background-color: var(--card); border-radius: 16px; padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); width: 100%;
            max-width: 420px; text-align: center;
        }
        .status { font-size: 1.2rem; margin-bottom: 1.5rem; }
        .success { color: var(--success); }
        .error { color: var(--error); }
        a {
            display: inline-block; background-color: var(--primary); color: white;
            padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none;
            margin-top: 1rem; transition: background-color 0.2s ease;
        }
        a:hover { background-color: #3a56d4; }
    </style>
</head>
<body>
    <div class="container">
<?php
// Tentukan direktori tujuan untuk menyimpan file yang diunggah
$target_dir = "uploads/";

// Buat path lengkap untuk file di server
// basename() mencegah serangan file system traversal
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1; // Variabel penanda status, 1 = OK
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// --- PEMERIKSAAN KEAMANAN DAN VALIDASI ---

// 1. Cek apakah file benar-benar dikirim atau tidak
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        // Jika bukan gambar, kita tetap izinkan (untuk PDF), jadi cek ekstensi saja
        if ($fileType != "pdf") {
            echo "<p class='status error'>File bukan gambar atau PDF.</p>";
            $uploadOk = 0;
        }
    }
}

// 2. Cek apakah file sudah ada
if (file_exists($target_file)) {
    echo "<p class='status error'>Maaf, file dengan nama tersebut sudah ada.</p>";
    $uploadOk = 0;
}

// 3. Batasi ukuran file (misal: 5MB)
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "<p class='status error'>Maaf, ukuran file Anda terlalu besar (maksimal 5 MB).</p>";
    $uploadOk = 0;
}

// 4. Izinkan hanya format tertentu (Gambar & PDF)
if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg"
&& $fileType != "gif" && $fileType != "pdf" ) {
    echo "<p class='status error'>Maaf, hanya format JPG, JPEG, PNG, GIF, & PDF yang diizinkan.</p>";
    $uploadOk = 0;
}

// --- PROSES UPLOAD ---

// Cek jika $uploadOk masih 1 (berarti semua pemeriksaan lolos)
if ($uploadOk == 1) {
    // Pindahkan file dari lokasi sementara ke direktori tujuan
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<h2>Unggah Berhasil</h2>";
        echo "<p class='status success'>File ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " telah berhasil diunggah.</p>";
        echo '<a href="uploads/'. htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) .'" target="_blank">Lihat File</a>';
    } else {
        echo "<h2>Unggah Gagal</h2>";
        echo "<p class='status error'>Maaf, terjadi kesalahan saat mengunggah file Anda.</p>";
    }
} else {
    // Jika $uploadOk adalah 0 karena ada error
    echo "<h2>Unggah Gagal</h2>";
    echo "<p class='status error'>File Anda tidak dapat diunggah karena tidak memenuhi syarat.</p>";
}
?>
        <br>
        <a href="index.html">Unggah File Lain</a>
        <a href="list_fileupload.php">Lihat Daftar File</a>
    </div>
</body>
</html>