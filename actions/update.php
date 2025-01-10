<?php
/*
| -------------------------------------------------------------------
| PROSES SIMPAN DATA
| -------------------------------------------------------------------
| include(). Fungsi ini digunakan untuk memanggil dan menyertakan file PHP.
| mysqli_query(). Fungsi ini digunakan untuk mengirim query ke MySQL server.
| header($location). Fungsi ini digunakan untuk men-redirect halaman.
| -
| Jika mysqli_query() berhasil maka halaman akan diredirect kehalaman/file list.php.
| Jika mysqli_query() tidak berhasil maka selanjutnya akan ditampilkan pesan error.
|
*/

include '../config/database.php';

// Pastikan koneksi tersedia
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Validasi dan sanitasi data yang diterima
$id = mysqli_real_escape_string($conn, $_POST['id']);
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$status = mysqli_real_escape_string($conn, $_POST['status']);
$pekerjaan = mysqli_real_escape_string($conn, $_POST['pekerjaan']);
$umur = mysqli_real_escape_string($conn, $_POST['umur']);

// Query untuk mengupdate data
$sql = "UPDATE tbl_warga 
        SET nama='$nama', status='$status', pekerjaan='$pekerjaan', umur='$umur' 
        WHERE id='$id'";

if (mysqli_query($conn, $sql)) {
    $notif = 'Berhasil mengupdate data!';
    header('location:../list.php?msg=' . base64_encode($notif));
    exit;
} else {
    echo "Gagal mengupdate data, karena: " . mysqli_error($conn);
}

// Menutup koneksi database
mysqli_close($conn);
?>
