<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['id_proyek'])) {
    $id_proyek=$_GET['id_proyek'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM proyek WHERE id_proyek='$id_proyek'");
 
// After delete redirect to Home, so that latest user list will be displayed.
echo"<script>window.location.href = '../index.php?folder=proyek&page=bj-lihat';</script>";
?> 