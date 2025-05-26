<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['id_klien'])) {
    $id_klien=$_GET['id_klien'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM klien WHERE id_klien='$id_klien'");
 
// After delete redirect to Home, so that latest user list will be displayed.
echo"<script>window.location.href = '../index.php?folder=klien&page=c-lihat';</script>";
?> 