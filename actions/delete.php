<?php
/*
| -------------------------------------------------------------------
| PROSES HAPUS DATA
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

// Validasi dan sanitasi data dari parameter GET
$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

if ($id) {
    // Query untuk menghapus data
    $sql = "DELETE FROM tbl_warga WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        $notif = 'Berhasil menghapus data!';
        header('location:../list.php?msg=' . base64_encode($notif));
        exit;
    } else {
        echo "Gagal menghapus data, karena: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak ditemukan atau tidak valid.";
}

// Menutup koneksi database
mysqli_close($conn);
?>
