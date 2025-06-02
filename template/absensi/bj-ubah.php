<?php
// File: form_ubah_absensi.php (atau nama file yang Anda gunakan, misal: bj-ubah-absensi.php)
include_once 'koneksi.php'; // Pastikan koneksi.php tersedia dan $conn terdefinisi

$id_absensi_to_edit = null;
$data_absensi_lama = null;
$error_message = '';

// 1. Cek apakah ada id_absensi di URL untuk diedit
if (isset($_GET['id_absensi'])) {
    // Pastikan $conn sudah ter-include dan valid
    if (!$conn) {
        $error_message = "Koneksi database gagal. Silakan periksa file koneksi.php.";
    } else {
        $id_absensi_to_edit = mysqli_real_escape_string($conn, $_GET['id_absensi']);

        // 2. Ambil data absensi yang akan diedit dari database
        // Kita juga bisa JOIN di sini jika perlu menampilkan nama langsung dari query awal,
        // namun untuk form, biasanya kita ambil ID-nya lalu populate dropdown secara terpisah.
        $query_get_data = "SELECT * FROM absensi WHERE id_absensi = '$id_absensi_to_edit'";
        $result_get_data = mysqli_query($conn, $query_get_data);

        if ($result_get_data && mysqli_num_rows($result_get_data) > 0) {
            $data_absensi_lama = mysqli_fetch_assoc($result_get_data);
        } else {
            $error_message = "Data absensi dengan ID " . htmlspecialchars($id_absensi_to_edit) . " tidak ditemukan.";
        }
    }
} else {
    $error_message = "ID Absensi untuk diedit tidak disertakan di URL.";
}

// 3. Proses Update Data jika form disubmit
if (isset($_POST['proses_ubah_absensi'])) {
    if (!$conn) {
        // Jika koneksi hilang atau belum di-set
        include_once 'koneksi.php'; 
        if (!$conn) {
             echo "<script>alert('Error: Tidak dapat terhubung ke database untuk menyimpan data.');</script>";
             // Bisa tambahkan exit atau return jika ini function
        }
    }
    
    // Lanjutkan hanya jika koneksi ada dan data lama (untuk ID) ditemukan
    if ($conn && isset($_POST['id_absensi_hidden'])) {
        $id_absensi_hidden = $_POST['id_absensi_hidden'];
        $id_pekerja = $_POST['id_pekerja'];
        $id_proyek = $_POST['id_proyek'];
        $id_mandor = $_POST['id_mandor'];
        $tgl_absensi = $_POST['tgl_absensi'];
        $status_hadir = $_POST['status_hadir'];
        $lembur = $_POST['lembur'];
        $keterangan = $_POST['keterangan'];

        if (empty($id_pekerja) || empty($id_proyek) || empty($id_mandor) || empty($tgl_absensi)) {
            echo "<script>alert('Pekerja, Proyek, Mandor, dan Tanggal Absen tidak boleh kosong!');</script>";
        } else {
            $stmt = mysqli_prepare($conn, "UPDATE absensi SET id_pekerja=?, id_proyek=?, id_mandor=?, tgl_absensi=?, status_hadir=?, lembur=?, keterangan=? WHERE id_absensi=?");
            
            // Tipe data: id_pekerja(i), id_proyek(i), id_mandor(i), tgl_absensi(s), status_hadir(i), lembur(i), keterangan(s), id_absensi_WHERE(i)
            mysqli_stmt_bind_param($stmt, "iiisissi", $id_pekerja, $id_proyek, $id_mandor, $tgl_absensi, $status_hadir, $lembur, $keterangan, $id_absensi_hidden);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Data absensi berhasil diubah.');</script>";
                // GANTI 'bj-lihat-absensi' dengan nama file/page yang menampilkan tabel absensi
                echo "<script>window.location.href = 'index.php?folder=absensi&page=bj-lihat-absensi';</script>"; 
                exit; 
            } else {
                echo "<script>alert('Gagal mengubah data absensi. Error: " . htmlspecialchars(mysqli_stmt_error($stmt)) . "');</script>";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
         echo "<script>alert('Error: Tidak dapat memproses permintaan. Data awal tidak ditemukan atau koneksi gagal.');</script>";
    }
}
?>
<html>
<head>
    <title>Form Ubah Absensi</title>
    </head>
<body>

<div class="row">
    <div class="col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">

<h4 style="text-align:center;">FORM UBAH ABSENSI</h4>

<?php if (!empty($error_message)): ?>
    <div class="alert alert-danger" role="alert" style="margin-top: 20px;"><?php echo $error_message; ?></div>
<?php elseif ($data_absensi_lama && $conn): // Tampilkan form hanya jika data ditemukan DAN koneksi berhasil ?>
<form action="" method="post">
    <input type="hidden" name="id_absensi_hidden" value="<?php echo htmlspecialchars($data_absensi_lama['id_absensi']); ?>">
    <table class="table table-stripped">
        <tr>
            <td>Nama Pekerja</td>
            <td>
                <select class="form-control" name="id_pekerja" required>
                    <option value="">--Pilih Pekerja--</option>
                    <?php
                    $query_all_pekerja = mysqli_query($conn, "SELECT id_pekerja, nama_pekerja FROM pekerja ORDER BY nama_pekerja ASC");
                    while ($pekerja_option = mysqli_fetch_array($query_all_pekerja)) {
                        $selected = ($pekerja_option['id_pekerja'] == $data_absensi_lama['id_pekerja']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($pekerja_option['id_pekerja']) . "' $selected>" . htmlspecialchars($pekerja_option['nama_pekerja']) . "</option>";
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
                    $query_all_proyek = mysqli_query($conn, "SELECT id_proyek, nama_proyek FROM proyek ORDER BY nama_proyek ASC");
                    while ($proyek_option = mysqli_fetch_array($query_all_proyek)) {
                        $selected = ($proyek_option['id_proyek'] == $data_absensi_lama['id_proyek']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($proyek_option['id_proyek']) . "' $selected>" . htmlspecialchars($proyek_option['nama_proyek']) . "</option>";
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
                    // Mandor adalah pekerja juga, jadi ambil dari tabel pekerja
                    $query_all_mandor = mysqli_query($conn, "SELECT id_pekerja, nama_pekerja FROM pekerja ORDER BY nama_pekerja ASC");
                    while ($mandor_option = mysqli_fetch_array($query_all_mandor)) {
                        $selected = ($mandor_option['id_pekerja'] == $data_absensi_lama['id_mandor']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($mandor_option['id_pekerja']) . "' $selected>" . htmlspecialchars($mandor_option['nama_pekerja']) . "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tanggal Absen</td>
            <td><input class="form-control" type="date" name="tgl_absensi" value="<?php echo htmlspecialchars($data_absensi_lama['tgl_absensi']); ?>" required></td>
        </tr>
        <tr>
            <td>Status Hadir</td>
            <td>
                <select class="form-control" name="status_hadir" required>
                    <option value="1" <?php echo ($data_absensi_lama['status_hadir'] == 1) ? 'selected' : ''; ?>>Hadir</option>
                    <option value="0" <?php echo ($data_absensi_lama['status_hadir'] == 0) ? 'selected' : ''; ?>>Tidak Hadir</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Lembur</td>
            <td>
                <select class="form-control" name="lembur" required>
                    <option value="0" <?php echo ($data_absensi_lama['lembur'] == 0) ? 'selected' : ''; ?>>Tidak</option>
                    <option value="1" <?php echo ($data_absensi_lama['lembur'] == 1) ? 'selected' : ''; ?>>Ya</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td><textarea class="form-control" name="keterangan" rows="3"><?php echo htmlspecialchars($data_absensi_lama['keterangan']); ?></textarea></td>
        </tr>
        <tr>
            <td>
                 <a class="badge badge-danger" href="index.php?folder=absensi&page=bj-lihat-absensi">Batal</a>
            </td>
            <td><button class="badge badge-success" type="submit" name="proses_ubah_absensi">Update Absensi</button></td>
        </tr>
    </table>
</form>
<?php elseif (!$conn): // Jika koneksi gagal di awal ?>
    <div class="alert alert-danger" role="alert" style="margin-top: 20px;">Koneksi ke database gagal. Form tidak dapat ditampilkan.</div>
<?php endif; ?>

            </div>
        </div>
    </div>
</div>

</body>
</html>
