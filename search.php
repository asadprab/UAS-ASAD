<?php
// Start session
session_start();

// Cek sudah login atau belum
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    $msg = "Kamu harus login terlebih dahulu!";
    header("Location: login.php?msg=" . base64_encode($msg));
    exit();
}

// Menyertakan file database untuk membuat koneksi
include 'config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pencarian Daftar Warga</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- HTML5 Shim and Respond.js IE8 support -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Aplikasi Data Warga</a>
            </div>

            <div class="collapse navbar-collapse navbar-ex1-collapse">
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
                            <h3 class="panel-title">Pencarian Data</h3>
                        </div>
                        <div class="panel-body">
                            <form method="GET" role="form">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="keyword" placeholder="Masukan nama, id, umur, pekerjaan, atau status" required="required">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">Go!</button>
                                    </span>
                                </div>
                            </form>
                            <div class="clearfix">&nbsp;</div>

                            <?php if (isset($_GET['keyword'])) { 
                                // Escape keyword untuk mencegah SQL injection
                                $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);

                                // Query pencarian
                                $sql = "SELECT * FROM tbl_warga WHERE id LIKE '%$keyword%' OR nama LIKE '%$keyword%' OR status LIKE '%$keyword%' OR pekerjaan LIKE '%$keyword%' OR umur LIKE '%$keyword%'";
                                $query = mysqli_query($conn, $sql);

                                if ($query && mysqli_num_rows($query) > 0) { ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Status</th>
                                                    <th>Pekerjaan</th>
                                                    <th>Umur</th>
                                                    <th width="88">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($data['id']); ?></td>
                                                        <td><?php echo htmlspecialchars($data['nama']); ?></td>
                                                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                                                        <td><?php echo htmlspecialchars($data['pekerjaan']); ?></td>
                                                        <td><?php echo htmlspecialchars($data['umur']); ?></td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="edit.php?id=<?php echo $data['id']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                                                    <span class="glyphicon glyphicon-edit"></span>
                                                                </a>
                                                                <a href="actions/delete.php?id=<?php echo $data['id']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin?')">
                                                                    <span class="glyphicon glyphicon-remove"></span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="alert alert-info">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <strong>Info!</strong> Data dengan keyword '<?php echo htmlspecialchars($keyword); ?>' tidak ditemukan di database.
                                    </div>
                                <?php } 
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <nav class="navbar navbar-default navbar-fixed-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="credit">Copyright &copy; Muhammad Asad Prabowo 2024</p>
                        </div>
                    </div>
                </div>
            </nav>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
// Menutup koneksi database
mysqli_close($conn);
?>
