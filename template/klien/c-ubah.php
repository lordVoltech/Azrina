<?php
    include 'koneksi.php';
    $query = mysqli_query($conn, "Select*from klien where id_klien = '$_GET[id_klien]'");
    $data = mysqli_fetch_array($query);
            
?>
  
<html>

<div class="row">
    <div class="col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                <table class="table table-stripped">
                    <h4>FORM UBAH ORANG</h4>
                    <tr>
                        <td> id klien </td>
                        <td> <input class="form-control" type="number" name="id" value="<?php echo $data['id_klien']; ?>" > </td>
                    </tr>
                    <tr>
                        <td> Nama klien </td>
                        <td> <input  class="form-control" type="text" name="nama" value="<?php echo $data['nama']; ?>"> </td>
                    </tr>
                    <tr>
                        <td> alamat </td>
                        <td> <input  class="form-control" type="text" name="alamat" value="<?php echo $data['alamat']; ?>"> </td>
                    </tr>
                    <tr>
                        <td> no hp </td>
                        <td> <input  class="form-control" type="text" name="nohp" value="<?php echo $data['no_hp']; ?>"> </td>
                    </tr>
                    <tr>
                        <td><a class="badge badge-danger" href="c-lihat.php">Batal</a></td>
                        <td><button class="badge badge-success" type="submit" name="proses" value="Simpan">Simpan </td>
                    </tr>
                </form>
                </table>
        </div>
        </div>
    </div>
</div>
</html>

<?php

if (isset($_POST['proses'])){
    include 'koneksi.php';
  
    $id = $_POST['id-item'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['nohp'];

    mysqli_query($conn, "UPDATE klien SET nama='$nama', alamat='$alamat', no_hp='$nohp' WHERE id_klien= $id");
    echo"<script>window.location.href = 'index.php?folder=klien&page=c-lihat';</script>";
}
?>