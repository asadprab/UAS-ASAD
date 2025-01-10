<?php
include '../config/database.php';

$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$status = mysqli_real_escape_string($conn, $_POST['status']);
$pekerjaan = mysqli_real_escape_string($conn, $_POST['pekerjaan']);
$umur = mysqli_real_escape_string($conn, $_POST['umur']);

$sql = "INSERT INTO tbl_warga (nama, status, pekerjaan, umur) VALUES ('$nama', '$status', '$pekerjaan', '$umur')";

if (mysqli_query($conn, $sql)) {
    $notif = 'Berhasil menyimpan data!';
    header('location:../list.php?msg=' . base64_encode($notif));
    exit;
} else {
    echo "Gagal menginput data, karena " . mysqli_error($conn);
}

mysqli_close($conn);
?>
