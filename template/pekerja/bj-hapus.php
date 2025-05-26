<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['id_pekerja'])) {
    $id_pekerja=$_GET['id_pekerja'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM pekerja WHERE id_pekerja='$id_pekerja'");
 
// After delete redirect to Home, so that latest user list will be displayed.
echo"<script>window.location.href = '../index.php?folder=pekerja&page=bj-lihat';</script>";
?> 