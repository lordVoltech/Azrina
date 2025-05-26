<html>
<div class="row">
    <div class="col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">
<h3 style="text-align:center;"> Form Tambah </h3>

<form action="" method="post">
<table class="table table">
    <tr>
        <td> ID proyek </td>
        <td> <input class="form-control"type="number" name="id"> </td>
    </tr>
    <tr>
        <td> Nama proyek </td>
        <td> <input class="form-control"type="text" name="nama"> </td>
    </tr>
    <tr>
        <td> Klien </td>
        <td>
            <select class="form-control" name="klien" id="klien">
            <option value="">--Pilih--</option>
            <?php 
            include 'koneksi.php';

            // Misalnya variabel ini berisi id_klien dari database yang mau diedit
            $id_klien_terpilih = $pekerja['id_klien']; // kamu harus ambil data pekerja dulu sebelumnya

            $hug = mysqli_query($conn, "SELECT * FROM klien") or die(mysqli_error($conn));
            while ($data = mysqli_fetch_array($hug)) {
                $selected = ($data['id_klien'] == $id_klien_terpilih) ? 'selected' : '';
                echo "<option value='{$data['id_klien']}' $selected>{$data['nama']}</option>";
            }
            ?>
        </select>
        </td>
    </tr>
    <tr>
        <td> lokasi </td>
        <td> <input class="form-control" type="text" name="lokasi"> </td>
    </tr>
    <tr>
        <td> tanggal </td>
        <td> <input class="form-control" type="date" name="tanggal"> </td>
    </tr>

    <tr>
        <td> jenis_proyek </td>
        <td>
            <select class="form-control" name="tipe" id="tipe">
            <option value="bangun rumah">bangun Rumah</option>
            <option value="renovasi">renovasi</option>
            <option value="bangun gedung">bangun gedung</option>
            </select>
        </td>
    </tr>

    <tr>
        <td><a class="badge badge-danger" href="index.php?folder=proyek&page=bj-lihat">Batal</a></td>
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
  
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $klien = $_POST['klien'];
    $tipe = $_POST['tipe'];
    $tanggal = $_POST['tanggal'];
    $lokasi = $_POST['lokasi'];
    
    mysqli_query($conn, "INSERT INTO proyek VALUES('$id','$klien','$nama','$tipe','$lokasi','$tanggal')");
    echo"<script>window.location.href = 'index.php?folder=proyek&page=bj-lihat';</script>";
}
?>