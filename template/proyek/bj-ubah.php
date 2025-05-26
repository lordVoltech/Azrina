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
        <td> id proyek </td>
        <td> <input class="form-control" type="number" name="id" value="<?php echo $data['id_proyek'];?>" readonly> </td>
    </tr>
    <tr>
        <td> Nama proyek </td>
        <td> <input class="form-control" type="text" name="nama" value="<?php echo $data['nama_proyek'];?>" > </td>
    </tr>
    <tr>
        <td> Lokasi </td>
        <td> <input class="form-control" type="text" name="lokasi" value="<?php echo $data['lokasi'];?>" > </td>
    </tr>
    <tr>
        <td> tanggal </td>
        <td> <input class="form-control" type="date" name="tanggal" value="<?php echo $data['tanggal'];?>" > </td>
    </tr>
    
    <tr>
        <td>Jenis Proyek</td>
        <td>
            <select class="form-control" name="tipe" id="tipe">
                <option value="bangun_rumah" <?= ($data['jenisproyek'] == 'bangun_rumah') ? 'selected' : '' ?>>Bangun Rumah</option>
                <option value="renovasi" <?= ($data['jenisproyek'] == 'renovasi') ? 'selected' : '' ?>>Renovasi</option>
                <option value="bangun_gedung" <?= ($data['jenisproyek'] == 'bangun_gedung') ? 'selected' : '' ?>>Bangun Gedung</option>
            </select>
        </td>
    </tr>

    <tr>
        <td>Klien</td>
        <td>
            <select class="form-control" name="klien" id="klien">
                <option value="">--Pilih--</option>
                <?php 
                include 'koneksi.php';

                // Ambil id_klien yang sedang diedit (pastikan ini udah didefinisikan sebelumnya)
                $id_klien_terpilih = $data['id_klien']; // misal variabel data adalah hasil dari SELECT pekerja WHERE id

                $result = mysqli_query($conn, "SELECT * FROM klien") or die(mysqli_error($conn));
                while ($klien = mysqli_fetch_array($result)) {
                    $selected = ($klien['id_klien'] == $id_klien_terpilih) ? 'selected' : '';
                    echo "<option value='{$klien['id_klien']}' $selected>{$klien['nama']}</option>";
                }
                ?>
            </select>
        </td>
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
    if (isset($_POST['proses'])) {
        include 'koneksi.php';
    
        $id      = $_POST['id'];
        $nama    = $_POST['nama'];
        $klien   = $_POST['klien'];
        $tipe    = $_POST['tipe'];
        $tanggal = $_POST['tanggal'];
        $lokasi  = $_POST['lokasi'];

        // Perhatikan tanda kutip di $id juga, biar aman
        mysqli_query($conn, "UPDATE proyek SET 
            id_klien      = '$klien',
            nama_proyek   = '$nama', 
            jenisproyek  = '$tipe', 
            lokasi        = '$lokasi',
            tanggal       = '$tanggal' 
            WHERE id_proyek = '$id'
        ") or die(mysqli_error($conn));

        echo "<script>window.location.href = 'index.php?folder=proyek&page=bj-lihat';</script>";
    }
?>
