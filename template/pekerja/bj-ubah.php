<?php
    include 'koneksi.php';
    $query = mysqli_query($conn, "Select*from pekerja where id_pekerja = '$_GET[id_pekerja]'");
    $data = mysqli_fetch_array($query);
            
?>
  
  <html>
  <div class="row">
    <div class="col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">
<form action="" method="post">
<table class="table table-stripped">
    <h4>FORM UBAH</h4>

    <tr>
        <td> id pekerja </td>
        <td> <input class="form-control" type="number" name="id" value="<?php echo $data['id_pekerja'];?>" readonly> </td>
    </tr>
    <tr>
        <td> nama pekerja </td>
        <td> <input class="form-control" type="text" name="nama" value="<?php echo $data['nama_pekerja'];?>"> </td>
    </tr>
    <tr>
        <td> Nomor HP pekerja </td>
        <td> <input class="form-control" type="text" name="nohp" value="<?php echo $data['no_hp'];?>"> </td>
    </tr>
    <tr>
        <td> Nomor rekening pekerja </td>
        <td> <input class="form-control" type="text" name="rekening" value="<?php echo $data['rekening'];?>"> </td>
    </tr>

    <tr>
        <td> Jabatan </td>
        <select class="form-control" name="jabatan">
            <option value="">--Pilih--</option>
            <?php 
            include 'koneksi.php';

            // Misalnya variabel ini berisi id_jabatan dari database yang mau diedit
            $id_jabatan_terpilih = $data['id_jabatan']; // kamu harus ambil data data dulu sebelumnya

            $hug = mysqli_query($conn, "SELECT * FROM jabatan") or die(mysqli_error($conn));
            while ($agar = mysqli_fetch_array($hug)) {
                $selected = ($agar['id_jabatan'] == $id_jabatan_terpilih) ? 'selected' : '';
                echo "<option value='{$data['id_jabatan']}' $selected>{$data['namajabatan']}</option>";
            }
            ?>
        </select>
    </tr>
    <tr>
        <td> proyek </td>
        <select class="form-control" name="proyek">
            <option value="">--Pilih--</option>
            <?php 
            include 'koneksi.php';

            // Misalnya variabel ini berisi id_proyek dari database yang mau diedit
            $id_proyek_terpilih = $data['id_proyek']; // kamu harus ambil data pekerja dulu sebelumnya

            $hug = mysqli_query($conn, "SELECT * FROM proyek") or die(mysqli_error($conn));
            while ($ayam = mysqli_fetch_array($hug)) {
                $selected = ($ayam['id_proyek'] == $id_proyek_terpilih) ? 'selected' : '';
                echo "<option value='{$data['id_proyek']}' $selected>{$data['nama_proyek']}</option>";
            }
            ?>
        </select>
    </tr>

    <tr>
        <td><a class="badge badge-danger" href="index.php?folder=pekerja&page=bj-lihat">Batal</a></td>
        <td><button class="badge badge-success" type="submit" name="proses" value="Simpan"> Simpan </td>
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
    $tipe= $_POST['tipe'];

    
    mysqli_query($conn, "UPDATE pekerja SET nama='$nama', jabatan='$tipe' WHERE id_pekerja= '$id'");
    echo"<script>window.location.href = 'index.php?folder=pekerja&page=bj-lihat';</script>";
}
?>