<?php
    include 'koneksi.php';
    $query = mysqli_query($conn, "Select*from pekerja where id_pekerja = '$_GET[id_pekerja]'");
    $pekerja = mysqli_fetch_array($query);
            
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
        <td> <input class="form-control" type="number" name="id" value="<?php echo $pekerja['id_pekerja'];?>" readonly> </td>
    </tr>
    <tr>
        <td> nama pekerja </td>
        <td> <input class="form-control" type="text" name="nama" value="<?php echo $pekerja['nama_pekerja'];?>"> </td>
    </tr>
    <tr>
        <td> Nomor HP pekerja </td>
        <td> <input class="form-control" type="text" name="nohp" value="<?php echo $pekerja['no_hp'];?>"> </td>
    </tr>
    <tr>
        <td> Nomor rekening pekerja </td>
        <td> <input class="form-control" type="text" name="rekening" value="<?php echo $pekerja['rekening'];?>"> </td>
    </tr>

    <tr>
        <td> Jabatan </td>
        <td>
        <select class="form-control" name="jabatan">
            <option value="">--Pilih--</option>
            <?php 
            include 'koneksi.php';

            // Misalnya variabel ini berisi id_jabatan dari database yang mau diedit
            $id_jabatan_terpilih = $pekerja['id_jabatan']; // kamu harus ambil data pekerja dulu sebelumnya

            $hug = mysqli_query($conn, "SELECT * FROM jabatan") or die(mysqli_error($conn));
            while ($data = mysqli_fetch_array($hug)) {
                $selected = ($data['id_jabatan'] == $id_jabatan_terpilih) ? 'selected' : '';
                echo "<option value='{$data['id_jabatan']}' $selected>{$data['namajabatan']}</option>";
            }
            ?>
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

            // Misalnya variabel ini berisi id_proyek dari database yang mau diedit
            $id_proyek_terpilih = $pekerja['id_proyek']; // kamu harus ambil data pekerja dulu sebelumnya

            $hug = mysqli_query($conn, "SELECT * FROM proyek") or die(mysqli_error($conn));
            while ($data = mysqli_fetch_array($hug)) {
                $selected = ($data['id_proyek'] == $id_proyek_terpilih) ? 'selected' : '';
                echo "<option value='{$data['id_proyek']}' $selected>{$data['nama_proyek']}</option>";
            }
            ?>
        </select>
        </td>
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
if (isset($_POST['proses'])) {
    include 'koneksi.php';

    $id       = $_POST['id'];
    $nama     = $_POST['nama'];
    $nohp     = $_POST['nohp'];
    $rekening = $_POST['rekening'];
    $jabatan  = $_POST['jabatan'];
    $proyek   = $_POST['proyek'];

    $query = "UPDATE pekerja SET 
                nama_pekerja = '$nama',
                no_hp        = '$nohp',
                rekening     = '$rekening',
                id_jabatan   = '$jabatan',
                id_proyek    = '$proyek'
              WHERE id_pekerja = '$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>window.location.href = 'index.php?folder=pekerja&page=bj-lihat';</script>";
    } else {
        echo "Update gagal: " . mysqli_error($conn);
    }
}
?>