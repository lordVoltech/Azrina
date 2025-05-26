<?php
    include 'koneksi.php';
    $query = mysqli_query($conn, "Select*from jabatan where id_jabatan = '$_GET[id_jabatan]'");
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
        <td> <input class="form-control" type="number" name="id" value="<?php echo $data['id_jabatan'];?>" readonly> </td>
    </tr>
    <tr>
        <td> nama jabatan baru </td>
        <td> <input class="form-control" type="text" name="nama" value="<?php echo $data['namajabatan'];?>"> </td>
    </tr>
    <tr>
        <td> gaji pokok(harian) </td>
        <td> <input class="form-control" type="number" name="gaji" value="<?php echo $data['gajipokok'];?>"> </td>
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
if (isset($_POST['proses'])) {
    include 'koneksi.php';

    $id     = $_POST['id'];        // id_jabatan
    $nama   = $_POST['nama'];      // namajabatan
    $gaji   = $_POST['gaji'];      // gaji

    $query = "UPDATE jabatan SET 
                namajabatan = '$nama',
                gajipokok    = '$gaji'
              WHERE id_jabatan = '$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>window.location.href = 'index.php?folder=jabatan&page=c-lihat';</script>";
    } else {
        echo "Update gagal: " . mysqli_error($conn);
    }
}
?>
