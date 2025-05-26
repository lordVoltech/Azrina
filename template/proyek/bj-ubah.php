<?php
    include 'koneksi.php';
    $query = mysqli_query($conn, "Select*from proyek where id_proyek = '$_GET[id_proyek]'");
    $data = mysqli_fetch_array($query);
            
?>
  
  <html>
<div class="row">
    <div class="col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">

<form class="form-sample"action="" method="post">

<table class="table table-stripped">
    <h4>Form Ubah</h4>

    <tr>
        <td> id Item </td>
        <td> <input class="form-control" type="number" name="id-item" value="<?php echo $data['id_proyek'];?>" readonly> </td>
    </tr>
    <tr>
        <td> Nama Item </td>
        <td> <input class="form-control" type="text" name="nama" value="<?php echo $data['nama_proyek'];?>" > </td>
    </tr>
    <tr>
        <td> Harga </td>
        <td> <input class="form-control" type="number" name="harga" value="<?php echo $data['lokasi'];?>" > </td>
    </tr>

    <tr>
        <td> jenis_proyek </td>
        <td>
            <select class="form-control" name="tipe" id="tipe">
            <option value="barang" <?= ($data['jenis_proyek'] == 'barang') ? 'selected' : '' ?>>Barang</option>
            <option value="jasa" <?= ($data['jenis_proyek'] == 'jasa') ? 'selected' : '' ?>>Jasa</option>
            </select>
        </td>
    </tr>

    <tr>
        <td> tanggal </td>
        <td> <input class="form-control" type="tanggal" name="tanggal" value="<?php echo $data['tanggal'];?>" > </td>
    </tr>

    <tr>
        <td><a class="badge badge-danger" href="barjas.php?page=lihat">Batal</a></td>
        <td><button class="badge badge-success" type="submit" name="proses" value="Simpan"> Ubah </td>
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
    include '../koneksi.php';
  
    $id = $_POST['id-item'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $tipe= $_POST['tipe'];
    $tanggal= $_POST['tanggal'];
    
    mysqli_query($conn, "UPDATE proyek SET nama_proyek='$nama', lokasi='$harga', jenis_proyek='$tipe', tanggal='$tanggal' WHERE id_proyek= $id");
    echo"<script>window.location.href = 'index.php?folder=proyek&page=bj-lihat';</script>";
}
?>