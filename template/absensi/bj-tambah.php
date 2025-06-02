<?php
// File: form_tambah_pekerja.php (atau nama file Anda)
// Sebaiknya letakkan include koneksi di awal jika akan digunakan di banyak tempat,
// atau pastikan path-nya benar jika diletakkan di dalam blok kode.
// Untuk contoh ini, kita akan mengandalkan include di dalam blok jika diperlukan.
?>
<html>
<head>
    <title>Form Tambah Pekerja</title>
    </head>
<body>

<div class="row">
    <div class="col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">

<form action="" method="post"> <?php // Action kosong akan submit ke halaman ini sendiri ?>
<table class="table table-stripped">
    <h4 style="text-align:center;">FORM TAMBAH PEKERJA</h4>
    <tr>
        <td>ID Pekerja</td>
        <td><input class="form-control" type="number" name="id_pekerja" required></td>
    </tr>
    <tr>
        <td>Nama Pekerja</td>
        <td><input class="form-control" type="text" name="nama_pekerja" required></td>
    </tr>
    <tr>
        <td>Nomor HP Pekerja</td>
        <td><input class="form-control" type="text" name="no_hp"></td>
    </tr>
    <tr>
        <td>Nomor Rekening Pekerja</td>
        <td><input class="form-control" type="text" name="rekening"></td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>
            <select class="form-control" name="id_jabatan" required>
                <option value="">--Pilih Jabatan--</option>
                <?php
                include 'koneksi.php'; // Pastikan koneksi.php tersedia dan $conn terdefinisi
                if ($conn) { // Cek apakah koneksi berhasil
                    $query_jabatan = mysqli_query($conn, "SELECT * FROM jabatan") or die(mysqli_error($conn));
                    while ($data_jabatan = mysqli_fetch_array($query_jabatan)) {
                        echo "<option value='" . htmlspecialchars($data_jabatan['id_jabatan']) . "'>" . htmlspecialchars($data_jabatan['namajabatan']) . "</option>";
                    }
                } else {
                    echo "<option value=''>Error: Koneksi DB gagal</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Proyek</td>
        <td>
            <select class="form-control" name="id_proyek" required>
                <option value="">--Pilih Proyek--</option>
                <?php
                // include 'koneksi.php'; // $conn seharusnya sudah di-include dari blok Jabatan jika filenya sama
                if ($conn) { // Cek apakah koneksi berhasil
                    $query_proyek = mysqli_query($conn, "SELECT * FROM proyek") or die(mysqli_error($conn));
                    while ($data_proyek = mysqli_fetch_array($query_proyek)) {
                        echo "<option value='" . htmlspecialchars($data_proyek['id_proyek']) . "'>" . htmlspecialchars($data_proyek['nama_proyek']) . "</option>";
                    }
                } else {
                    echo "<option value=''>Error: Koneksi DB gagal</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><a class="badge badge-danger" href="index.php?folder=pekerja&page=bj-lihat">Batal</a></td>
        <td><button class="badge badge-success" type="submit" name="proses">Simpan</button></td>
    </tr>
</table>
</form>

            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['proses'])) {
    // include_once 'koneksi.php'; // $conn seharusnya sudah di-include dari atas jika diperlukan di sini lagi.
                                 // Jika koneksi hanya untuk blok ini, maka include di sini.
                                 // Untuk konsistensi dengan form, asumsikan $conn sudah ada atau di-include di atas.
                                 // Jika belum, uncomment baris di bawah:
    if (!$conn) { // Jika $conn belum ada dari blok form, include lagi
       include_once 'koneksi.php';
    }


    if ($conn) { // Lanjutkan hanya jika koneksi berhasil
        $id_pekerja = $_POST['id_pekerja'];
        $nama_pekerja = $_POST['nama_pekerja'];
        $no_hp = $_POST['no_hp']; // Bisa kosong jika tidak required
        $rekening = $_POST['rekening']; // Bisa kosong jika tidak required
        $id_jabatan = $_POST['id_jabatan'];
        $id_proyek = $_POST['id_proyek'];

        // Validasi dasar sisi server
        if (empty($id_pekerja) || empty($nama_pekerja) || empty($id_jabatan) || empty($id_proyek)) {
            echo "<script>alert('ID Pekerja, Nama Pekerja, Jabatan, dan Proyek tidak boleh kosong!');</script>";
        } else {
            // Urutan kolom di tabel pekerja: id_pekerja, nama_pekerja, no_hp, id_proyek, id_jabatan, rekening
            $stmt = mysqli_prepare($conn, "INSERT INTO pekerja (id_pekerja, nama_pekerja, no_hp, id_proyek, id_jabatan, rekening) VALUES (?, ?, ?, ?, ?, ?)");
            
            mysqli_stmt_bind_param($stmt, "issiis", $id_pekerja, $nama_pekerja, $no_hp, $id_proyek, $id_jabatan, $rekening);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Data pekerja berhasil ditambahkan.');</script>";
                echo "<script>window.location.href = 'index.php?folder=pekerja&page=bj-lihat';</script>";
            } else {
                if (mysqli_errno($conn) == 1062) {
                     echo "<script>alert('Gagal menambahkan data. ID Pekerja " . htmlspecialchars($id_pekerja) . " sudah ada.');</script>";
                } else {
                     echo "<script>alert('Gagal menambahkan data pekerja. Error: " . htmlspecialchars(mysqli_stmt_error($stmt)) . "');</script>";
                }
            }
            mysqli_stmt_close($stmt);
        }
        // mysqli_close($conn); // Pertimbangkan untuk menutup koneksi di akhir skrip utama, bukan di sini jika $conn dipakai lagi.
    } else {
        echo "<script>alert('Error: Tidak dapat terhubung ke database untuk menyimpan data.');</script>";
    }
}
?>
</body>
</html>
