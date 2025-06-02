<?php
// File: form_tambah_absensi.php (atau nama file Anda)
// include_once 'koneksi.php'; // Sebaiknya di-include sekali di atas jika $conn akan dipakai berulang
?>
<html>
<head>
    <title>Form Tambah Absensi</title>
    </head>
<body>

<div class="row">
    <div class="col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">

<h4 style="text-align:center;">FORM TAMBAH ABSENSI</h4>

<form action="" method="post"> <?php // Action kosong akan submit ke halaman ini sendiri ?>
<table class="table table-stripped">
    <tr>
        <td>Nama Pekerja</td>
        <td>
            <select class="form-control" name="id_pekerja" required>
                <option value="">--Pilih Pekerja--</option>
                <?php
                include_once 'koneksi.php'; // Pastikan koneksi.php tersedia dan $conn terdefinisi
                if ($conn) {
                    $query_pekerja = mysqli_query($conn, "SELECT id_pekerja, nama_pekerja FROM pekerja ORDER BY nama_pekerja ASC");
                    while ($data_pekerja = mysqli_fetch_array($query_pekerja)) {
                        echo "<option value='" . htmlspecialchars($data_pekerja['id_pekerja']) . "'>" . htmlspecialchars($data_pekerja['nama_pekerja']) . "</option>";
                    }
                } else {
                     echo "<option value=''>Error: Koneksi DB gagal</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Nama Proyek</td>
        <td>
            <select class="form-control" name="id_proyek" required>
                <option value="">--Pilih Proyek--</option>
                <?php
                // $conn seharusnya sudah ada dari include_once di atas
                if ($conn) {
                    $query_proyek = mysqli_query($conn, "SELECT id_proyek, nama_proyek FROM proyek ORDER BY nama_proyek ASC");
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
        <td>Nama Mandor</td>
        <td>
            <select class="form-control" name="id_mandor" required>
                <option value="">--Pilih Mandor--</option>
                <?php
                // $conn seharusnya sudah ada dari include_once di atas
                // Mandor adalah pekerja juga, jadi ambil dari tabel pekerja
                if ($conn) {
                    $query_mandor = mysqli_query($conn, "SELECT id_pekerja, nama_pekerja FROM pekerja ORDER BY nama_pekerja ASC");
                    while ($data_mandor = mysqli_fetch_array($query_mandor)) {
                        echo "<option value='" . htmlspecialchars($data_mandor['id_pekerja']) . "'>" . htmlspecialchars($data_mandor['nama_pekerja']) . "</option>";
                    }
                } else {
                     echo "<option value=''>Error: Koneksi DB gagal</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Tanggal Absen</td>
        <td><input class="form-control" type="date" name="tgl_absensi" value="<?php echo date('Y-m-d'); ?>" required></td>
    </tr>
    <tr>
        <td>Status Hadir</td>
        <td>
            <select class="form-control" name="status_hadir" required>
                <option value="1">Hadir</option>
                <option value="0">Tidak Hadir</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Lembur</td>
        <td>
            <select class="form-control" name="lembur" required>
                <option value="0">Tidak</option>
                <option value="1">Ya</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Keterangan</td>
        <td><textarea class="form-control" name="keterangan" rows="3"></textarea></td>
    </tr>
    <tr>
        <td>
            <a class="badge badge-danger" href="index.php?folder=absensi&page=nama_file_tampilan_absensi">Batal</a>
            </td>
        <td><button class="badge badge-success" type="submit" name="proses_tambah_absensi">Simpan Absensi</button></td>
    </tr>
</table>
</form>

            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['proses_tambah_absensi'])) {
    // Pastikan $conn sudah ter-include dari atas atau include_once di sini lagi jika perlu
    if (!$conn) {
       include_once 'koneksi.php'; // Pastikan ini ada jika $conn belum didefinisikan
    }

    if ($conn) {
        $id_pekerja = $_POST['id_pekerja'];
        $id_proyek = $_POST['id_proyek'];
        $id_mandor = $_POST['id_mandor'];
        $tgl_absensi = $_POST['tgl_absensi'];
        $status_hadir = $_POST['status_hadir'];
        $lembur = $_POST['lembur'];
        $keterangan = $_POST['keterangan'];

        // Validasi dasar (bisa ditambahkan yang lebih kompleks)
        if (empty($id_pekerja) || empty($id_proyek) || empty($id_mandor) || empty($tgl_absensi)) {
            echo "<script>alert('Pekerja, Proyek, Mandor, dan Tanggal Absen tidak boleh kosong!');</script>";
        } else {
            // id_absensi diasumsikan AUTO_INCREMENT
            $stmt = mysqli_prepare($conn, "INSERT INTO absensi (id_pekerja, id_proyek, id_mandor, tgl_absensi, status_hadir, lembur, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            // Tipe data: id_pekerja(i), id_proyek(i), id_mandor(i), tgl_absensi(s), status_hadir(i), lembur(i), keterangan(s)
            mysqli_stmt_bind_param($stmt, "iiisiss", $id_pekerja, $id_proyek, $id_mandor, $tgl_absensi, $status_hadir, $lembur, $keterangan);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Data absensi berhasil ditambahkan.');</script>";
                // Arahkan ke halaman tampilan data absensi
                echo "<script>window.location.href = 'index.php?folder=absensi&page=nama_file_tampilan_absensi';</script>";
                // Ganti 'nama_file_tampilan_absensi' dengan nama file yang menampilkan tabel absensi
            } else {
                // Cek error duplikasi jika ada unique constraint, misal pekerja tidak boleh absen 2x di tanggal yg sama untuk proyek yg sama
                // if (mysqli_errno($conn) == 1062) { ... }
                echo "<script>alert('Gagal menambahkan data absensi. Error: " . htmlspecialchars(mysqli_stmt_error($stmt)) . "');</script>";
            }
            mysqli_stmt_close($stmt);
        }
        // mysqli_close($conn); // Tutup koneksi di akhir skrip utama aplikasi Anda
    } else {
        echo "<script>alert('Error: Tidak dapat terhubung ke database untuk menyimpan data.');</script>";
    }
}
?>
</body>
</html>
