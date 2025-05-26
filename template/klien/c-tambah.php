<html>
<div class="row">
    <div class="col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                <table class="table table-strippped">
                    <h4>FORM TAMBAH</h4>
                    <tr>
                        <td> id klien </td>
                        <td> <input class="form-control" type="number" name="id"> </td>
                    </tr>
                    <tr>
                        <td> Nama klien </td>
                        <td> <input  class="form-control" type="text" name="nama"> </td>
                    </tr>
                    <tr>
                        <td> alamat </td>
                        <td> <input  class="form-control" type="text" name="alamat"> </td>
                    </tr>
                    <tr>
                        <td> no hp </td>
                        <td> <input  class="form-control" type="text" name="nohp"> </td>
                    </tr>


                    <tr>
                        <td><a class="badge badge-danger" href="c-lihat.php">Batal</a></td>
                        <td><button class="badge badge-success" type="submit" name="proses" value="Simpan">Simpan </td>
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
    $alamat= $_POST['alamat'];
    $nohp= $_POST['nohp'];
    
    mysqli_query($conn, "INSERT INTO klien VALUES('$nama','$harga','$alamat','$nohp')");
    echo"<script>window.location.href = 'index.php?folder=klien&page=c-lihat';</script>";
}
?>