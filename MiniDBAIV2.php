<?php
session_start();
$koneksi = null;
$error = '';
$success = '';

// Mengecek apakah detail koneksi sudah ada dalam sesi
if (isset($_SESSION['servername'], $_SESSION['username'], $_SESSION['database'])) {
    // Membuat koneksi menggunakan detail dari sesi
    $servername = $_SESSION['servername'];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $database = $_SESSION['database'];

    // Membuat koneksi
    $koneksi = new mysqli($servername, $username, $password, $database);

    // Cek koneksi
    if ($koneksi->connect_error) {
        $error = "Koneksi gagal: " . $koneksi->connect_error;
    }
}

// Ketika form di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['koneksi'])) {
    $servername = $_POST['servername'] ?? 'localhost'; // Default to localhost if not provided
    $username = $_POST['username'];
    $password = $_POST['password'] ?? ''; // Allow empty password
    $database = $_POST['database'] ?? ''; // Allow empty database name

    // Menyimpan detail koneksi ke dalam sesi
    $_SESSION['servername'] = $servername;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['database'] = $database;

    // Membuat koneksi baru
    $koneksi = new mysqli($servername, $username, $password);

    // Cek koneksi
    if ($koneksi->connect_error) {
        $error = "Koneksi gagal: " . $koneksi->connect_error;
    } else {
        // Jika nama database kosong, tampilkan daftar database
        if (empty($database)) {
            $success = "Koneksi berhasil. Berikut daftar database:";
            $query = "SHOW DATABASES";
            $result = $koneksi->query($query);

            if ($result->num_rows > 0) {
                echo "<h2>Daftar Database</h2><ul>";
                while ($row = $result->fetch_array()) {
                    echo "<li><a href=\"?database=" . urlencode($row[0]) . "\">" . htmlspecialchars($row[0]) . "</a></li>";
                }
                echo "</ul>";
            } else {
                echo "Tidak ada database ditemukan.";
            }
        } else {
            // Jika database diisi, lakukan koneksi ke database tersebut
            $koneksi = new mysqli($servername, $username, $password, $database);
            if ($koneksi->connect_error) {
                $error = "Koneksi gagal: " . $koneksi->connect_error;
            } else {
                $success = "Koneksi berhasil ke database $database";
            }
        }
    }
}

// Jika parameter database ada di URL, perbarui sesi
if (isset($_GET['database'])) {
    $database = $_GET['database'];
    $_SESSION['database'] = $database;
    // Redirect untuk mencegah pengulangan saat refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_POST['logout'])) {
    // Menghapus sesi
    session_unset();
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

function tampilkanTabel($koneksi) {
    $query = "SHOW TABLES";
    $result = $koneksi->query($query);

    if ($result->num_rows > 0) {
        echo "<h2>Daftar Tabel</h2><ul>";
        while ($row = $result->fetch_array()) {
            echo "<li><a href=\"?table=" . urlencode($row[0]) . "\">" . htmlspecialchars($row[0]) . "</a></li>";
        }
        echo "</ul>";
    } else {
        echo "Tidak ada tabel ditemukan.";
    }
}

function tampilkanIsiTabel($koneksi, $table) {
    $table = $koneksi->real_escape_string($table);
    $query = "SELECT * FROM `$table`";
    $result = $koneksi->query($query);

    if ($result->num_rows > 0) {
        echo "<h2>Isi Tabel: $table</h2><table border='1'><tr>";
echo "<th>Aksi</th>";

        // Menampilkan header tabel
        $field_info = $result->fetch_fields();
        foreach ($field_info as $val) {
            echo "<th>{$val->name}</th>";
        }
        
        echo "</tr>";

        // Menampilkan data
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
// Tombol edit
echo "<td><a href=\"?table=$table&edit_id=" . urlencode($row[array_keys($row)[0]]) . "\">Edit</a></td>";

            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            

            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Tabel kosong atau tidak ditemukan.";
    }
}

function tampilkanFormEdit($koneksi, $table, $edit_id) {
    $table = $koneksi->real_escape_string($table);
    $edit_id = $koneksi->real_escape_string($edit_id);

    // Mendapatkan nama kolom primary key
    $primary_key_query = "SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'";
    $primary_key_result = $koneksi->query($primary_key_query);

    if ($primary_key_result === false || $primary_key_result->num_rows === 0) {
        echo "Gagal mendapatkan primary key atau tabel tidak ditemukan.";
        return;
    }

    $primary_key_row = $primary_key_result->fetch_assoc();
    $primary_key = $primary_key_row['Column_name']; // Mendapatkan nama kolom primary key

    // Mendapatkan data baris yang akan diedit
    $query = "SELECT * FROM `$table` WHERE `$primary_key` = '$edit_id'";
    $result = $koneksi->query($query);

    if ($result === false) {
        // Jika query gagal, tampilkan pesan error
        echo "Error dalam menjalankan query: " . $koneksi->error;
        return;
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h2>Edit Data di Tabel: $table</h2>";
        echo "<form method='post'>";

        // Menampilkan input untuk setiap kolom
        foreach ($row as $column => $value) {
            echo "<label for='$column'>$column:</label><br>";
            echo "<input type='text' id='$column' name='$column' value='" . htmlspecialchars($value) . "'><br><br>";
        }

        echo "<input type='hidden' name='table' value='$table'>";
        echo "<input type='hidden' name='edit_id' value='$edit_id'>";
        echo "<input type='submit' name='simpan_edit' value='Simpan Perubahan'>";
        echo "</form>";
    } else {
        echo "Data tidak ditemukan.";
    }
}

function prosesEditData($koneksi, $table, $data, $edit_id) {
    $table = $koneksi->real_escape_string($table);
    $edit_id = $koneksi->real_escape_string($edit_id);

    // Membuat query update berdasarkan data yang di-submit
    $set = '';
    foreach ($data as $column => $value) {
        if ($column != 'table' && $column != 'simpan_edit' && $column != 'edit_id') {
            $set .= "`$column` = '" . $koneksi->real_escape_string($value) . "', ";
        }
    }
    $set = rtrim($set, ', ');

    // Mendapatkan nama primary key
    $primary_key_query = "SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'";
    $primary_key_result = $koneksi->query($primary_key_query);

    if ($primary_key_result && $primary_key_result->num_rows > 0) {
        $primary_key_row = $primary_key_result->fetch_assoc();
        $primary_key = $primary_key_row['Column_name']; // Perbaikan untuk mendapatkan kolom primary key

        // Membuat query update
        $query = "UPDATE `$table` SET $set WHERE `$primary_key` = '$edit_id'";

        if ($koneksi->query($query)) {
            echo "Perubahan berhasil disimpan.";
        } else {
            echo "Error: " . $koneksi->error;
        }
    } else {
        echo "Primary key tidak ditemukan.";
    }
}

if (isset($_POST['simpan_edit'])) {
    prosesEditData($koneksi, $_POST['table'], $_POST, $_POST['edit_id']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minidbai</title>
<meta name="robots" content="noindex, nofollow">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #5d5c61;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"], input[type="password"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #5d5c61;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #379683;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #379683;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .message {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .message.error {
            background-color: #ffcccb;
            color: #a94442;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
        }

        ul li a {
            color: #379683;
            text-decoration: none;
            font-weight: bold;
        }

        ul li a:hover {
            text-decoration: underline;
        }

        .form-wrapper {
            background-color: #eaeaea;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>MiniDBAIV2</h1>

    <?php
    if (!empty($error)) {
        echo "<p class='message error'>$error</p>";
    } elseif (!empty($success)) {
        echo "<p class='message success'>$success</p>";
    }
    ?>

    <?php if (!isset($_SESSION['servername'])): ?>
    <div class="form-wrapper">
        <form method="post">
            <label for="servername">Server Name:</label>
            <input type="text" id="servername" name="servername" value="localhost" required>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            
            <label for="database">Database Name:</label>
            <input type="text" id="database" name="database">
            
            <input type="submit" name="koneksi" value="Koneksi">
        </form>
    </div>
    <?php else: ?>
    <form method="post">
        <input type="submit" name="logout" value="Logout">
    </form>

    <?php
    if ($koneksi && !$koneksi->connect_error) {
        if (isset($_GET['table']) && isset($_GET['edit_id'])) {
            tampilkanFormEdit($koneksi, $_GET['table'], $_GET['edit_id']);
        } elseif (isset($_GET['table'])) {
            tampilkanIsiTabel($koneksi, $_GET['table']);
        } else {
            tampilkanTabel($koneksi);
        }
    }
    ?>
    <?php endif; ?>
</div>
<center>
<p class="u-small-text u-text u-text-variant u-text-1"> ©Copyright Powered By <a target="_blank" href="https://bukakartu.id/minidbai">MiniDBAI</a></p>
<center>
</body>
</html>
