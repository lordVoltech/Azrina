<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['id_jabatan'])) {
    $id_jabatan=$_GET['id_jabatan'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM jabatan WHERE id_jabatan='$id_jabatan'");
 
// After delete redirect to Home, so that latest user list will be displayed.
echo"<script>window.location.href = '../index.php?folder=jabatan&page=c-lihat';</script>";
?> 