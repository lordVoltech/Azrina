<?php
    include 'koneksi.php';
    $query = mysqli_query($conn, "Select*from jabatan where no_pol = '$_GET[no_pol]'");
    $data = mysqli_fetch_array($query);
            
?>
  
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
        <td> <input class="form-control" type="text" name="id" value="<?php echo $data['id_jabatan'];?>" readonly> </td>
    </tr>
    <tr>
        <td> nama jabatan baru </td>
        <td> <input class="form-control" type="text" name="nama" value="<?php echo $data['namajabatan'];?>"> </td>
    </tr>
    <tr>
        <td> gaji pokok(harian) </td>
        <td> <input class="form-control" type="text" name="gaji" value="<?php echo $data['gajipokok'];?>"> </td>
    </tr>

    <tr>
        <td><a class="badge badge-danger" href="index.php?folder=jabatan&page=c-lihat">Batal</a></td>
        <td><button class="badge badge-success" type="submit" name="proses" value="Simpan"> Simpan </td>
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
  
    $nama = $_POST['id'];
    $harga = $_POST['nama'];
    $tipe= $_POST['tipe'];
    $pemilik= $_POST['pemilik'];
    
    mysqli_query($conn, "UPDATE jabatan SET jenis_jabatan = '$harga', jenis_cc = '$tipe', id_cos = '$pemilik' WHERE no_pol='$nama'");
    echo"<script>window.location.href = 'index.php?folder=jabatan&page=c-lihat';</script>";
}
?>