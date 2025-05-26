<html>
<div class="row">
    <div class="col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">
<form action="" method="post">
<table class="table table-stripped">
    <h4>FORM TAMBAH</h4>
    <tr>
        <td> id Jabatan </td>
        <td> <input class="form-control" type="text" name="id"> </td>
    </tr>
    <tr>
        <td> nama jabatan baru </td>
        <td> <input class="form-control" type="text" name="nama"> </td>
    </tr>
    <tr>
        <td> gaji pokok(harian) </td>
        <td> <input class="form-control" type="text" name="gaji"> </td>
    </tr>

    <tr>
        <td><a class="badge badge-danger" href="index.php?folder=jabatan&page=c-lihat">Batal</a></td>
        <td><button class="badge badge-success" type="submit" name="proses" value="Simpan"> Sipman </td>
    </tr>

</table>

</form>
    </div>
    </div>
    </div>
    </div>

</html>

<?php

if (isset($_POST['proses'])){
    include 'koneksi.php';
  
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $gaji= $_POST['gaji'];
    $pemilik= $_POST['pemilik'];
    
    mysqli_query($conn, "INSERT INTO jabatan VALUES('$id','$nama','$gaji')");
    echo"<script>window.location.href = 'index.php?folder=jabatan&page=c-lihat';</script>";
}
?>