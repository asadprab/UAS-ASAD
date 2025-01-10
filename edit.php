<?php
// Start session
session_start();

// Cek sudah login atau belum
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    $msg = "Kamu harus login terlebih dahulu!";
    header("location:login.php?msg=" . base64_encode($msg));
    exit;
}

// Menyertakan file database untuk koneksi
include 'config/database.php';

// Menerima ID dari form dengan method GET
$id = mysqli_real_escape_string($conn, $_GET['id']);

// Membuat query untuk mengambil data berdasarkan ID
$query = "SELECT * FROM tbl_warga WHERE id = '$id'";

// Mengirim query ke database
$result = mysqli_query($conn, $query);

// Memastikan data ditemukan
if (!$result || mysqli_num_rows($result) === 0) {
    echo "Data tidak ditemukan!";
    exit;
}

// Mengambil hasil query berupa array
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Data</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Aplikasi Data Warga</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">Dashboard</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="list.php">Data Warga</a></li>
                                <li><a href="add.php">Tambah data</a></li>
                                <li><a href="search.php">Pencarian data</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Edit Data Warga</h3>
                            </div>
                            <div class="panel-body">
                                <form action="actions/update.php" method="POST" class="form-horizontal">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id']); ?>">
                                    <div class="form-group">
                                        <label for="nama" class="control-label col-md-2">Nama</label>
                                        <div class="col-md-10">
                                            <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="status" class="control-label col-md-2">Status</label>
                                        <div class="col-md-10">
                                            <select name="status" id="status" class="form-control">
                                                <option value="Menikah" <?php echo $data['status'] === 'Menikah' ? 'selected' : ''; ?>>Menikah</option>
                                                <option value="Belum Menikah" <?php echo $data['status'] === 'Belum Menikah' ? 'selected' : ''; ?>>Belum Menikah</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pekerjaan" class="control-label col-md-2">Pekerjaan</label>
                                        <div class="col-md-10">
                                            <input type="text" name="pekerjaan" class="form-control" value="<?php echo htmlspecialchars($data['pekerjaan']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="umur" class="control-label col-md-2">Umur</label>
                                        <div class="col-md-10">
                                            <input type="number" name="umur" class="form-control" value="<?php echo htmlspecialchars($data['umur']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10 col-sm-offset-2">
                                            <a href="list.php" class="btn btn-warning">Back</a>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <nav class="navbar navbar-default navbar-fixed-bottom">
                <div class="container">
                    <p class="credit">Copyright &copy; Muhammad Asad Prabowo 2024</p>
                </div>
            </nav>
        </footer>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
<?php
// Menutup koneksi database
mysqli_close($conn);
?>
