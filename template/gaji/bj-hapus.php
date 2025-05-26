<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['id_gaji'])) {
    $id_gaji=$_GET['id_gaji'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM gaji WHERE id_gaji='$id_gaji'");
 
// After delete redirect to Home, so that latest user list will be displayed.
echo"<script>window.location.href = '../index.php?folder=gaji&page=bj-lihat';</script>";
?> 