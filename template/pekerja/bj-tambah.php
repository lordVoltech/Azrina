<html>

<div class="row">
    <div class="col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">

<form action="" method="post">
<table class="table table-stripped">
    <h4 style="text-align:center;">FORM TAMBAH</h4>
    <tr>
        <td> id pekerja </td>
        <td> <input class="form-control" type="number" name="id"> </td>
    </tr>
    <tr>
        <td> nama pekerja </td>
        <td> <input class="form-control" type="text" name="nama"> </td>
    </tr>
    <tr>
        <td> Nomor HP pekerja </td>
        <td> <input class="form-control" type="text" name="nohp"> </td>
    </tr>
    <tr>
        <td> Nomor rekening pekerja </td>
        <td> <input class="form-control" type="text" name="rekening"> </td>
    </tr>

    <tr>
        <td> jabatan </td>
        <td>
            <select class="form-control" name="jabatan">
                <option value="">--Pilih--</option>
                <?php 
                include 'koneksi.php';
                $hug = mysqli_query($conn, "SELECT * FROM jabatan") or die(mysqli_error($conn));
                while ($data = mysqli_fetch_array($hug)) { ?>
                    <option value="<?php echo $data['id_jabatan']; ?>">
                        <?php echo $data['namajabatan']; ?>
                    </option>
                <?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td> proyek </td>
        <td>
            <select class="form-control" name="proyek">
                <option value="">--Pilih--</option>
                <?php 
                include 'koneksi.php';
                $ayg = mysqli_query($conn, "SELECT * FROM proyek") or die(mysqli_error($conn));
                while ($data = mysqli_fetch_array($ayg)) { ?>
                    <option value="<?php echo $data['id_proyek']; ?>">
                        <?php echo $data['nama_proyek']; ?>
                    </option>
                <?php } ?>
            </select>
        </td>
    </tr>

    <tr>
        <td><a class="badge badge-danger" href="pekerja.php?page=lihat">Batal</a></td>
        <td><button class="badge badge-success" type="submit" name="proses" value="Simpan"> Simpan</td>
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
    $nohp = $_POST['nohp'];
    $rekening = $_POST['rekening'];
    $jabatan= $_POST['jabatan'];
    $proyek= $_POST['proyek'];

    
    mysqli_query($conn, "INSERT INTO pekerja VALUES('$id','$nama','$nohp','$proyek','$jabatan','$rekening')");
    echo"<script>window.location.href = 'index.php?folder=pekerja&page=bj-lihat';</script>";
}
?>