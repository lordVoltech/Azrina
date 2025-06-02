<html>
<div class="row">
<div class="col-lg-8 grid-margin stretch-card mx-auto">
<div class="card">
<div class="card-body">

<form>
<h4>TABEL Absensi</h4>
<a class="badge badge-success" href="index.php?folder=absensi&page=bj-tambah">Tambah</a>
<table class="table table-stripped" width="100%">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Pekerja</th>
        <th>Nama Proyek</th>
        <th>Nama Mandor</th>
        <th>Tanggal Absen</th>
        <th>Status Hadir</th>
        <th>Lembur</th>
        <th>Keterangan</th>
        <th>Aksi</th>
    </tr>
    </thead>
    <tbody> <?php
            include 'koneksi.php'; // Pastikan file ini ada dan koneksi $conn berhasil
            $limit = 10; // Jumlah baris per halaman
            $hu = isset($_GET['hu']) ? (int)$_GET['hu'] : 1; // Ambil halaman saat ini, pastikan integer
            $start = ($hu - 1) * $limit;
            $no = $start + 1; // Untuk penomoran baris

            // Query untuk mengambil data absensi dengan join ke tabel pekerja (untuk nama pekerja dan nama mandor) dan proyek
            $query_sql = "SELECT
                            absensi.id_absensi,
                            pekerja.nama_pekerja AS nama_pekerja_absensi,
                            proyek.nama_proyek,
                            mandor.nama_pekerja AS nama_mandor,
                            absensi.tgl_absensi,
                            absensi.status_hadir,
                            absensi.lembur,
                            absensi.keterangan,
                            absensi.id_pekerja -- Tetap ambil id_pekerja untuk link aksi jika masih diperlukan
                        FROM
                            absensi
                        LEFT JOIN
                            pekerja ON absensi.id_pekerja = pekerja.id_pekerja
                        LEFT JOIN
                            proyek ON absensi.id_proyek = proyek.id_proyek
                        LEFT JOIN
                            pekerja AS mandor ON absensi.id_mandor = mandor.id_pekerja
                        LIMIT $start, $limit";
            
            $query = mysqli_query($conn, $query_sql);

            if (!$query) {
                // Jika query gagal, tampilkan error SQL untuk debugging
                echo "<tr><td colspan='9'>Error: " . mysqli_error($conn) . "</td></tr>";
            } elseif (mysqli_num_rows($query) > 0) {
                while ($data = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($data['nama_pekerja_absensi']); ?></td>
                        <td><?php echo htmlspecialchars($data['nama_proyek']); ?></td>
                        <td><?php echo htmlspecialchars($data['nama_mandor']); ?></td>
                        <td><?php echo htmlspecialchars(date('d-m-Y', strtotime($data['tgl_absensi']))); ?></td>
                        <td><?php echo ($data['status_hadir'] == 1) ? 'Hadir' : 'Tidak Hadir'; ?></td>
                        <td><?php echo ($data['lembur'] == 1) ? 'Ya' : 'Tidak'; ?></td>
                        <td><?php echo htmlspecialchars($data['keterangan']); ?></td>
                        <td>
                            <a class="badge badge-primary" href="index.php?folder=pekerja&page=bj-ubah&id_pekerja=<?php echo $data['id_pekerja']; ?>">Edit Pekerja</a>
                            <a class="badge badge-danger" href="pekerja/bj-hapus.php?id_pekerja=<?php echo $data['id_pekerja']; ?>" onclick="return confirm('Anda yakin ingin menghapus data pekerja ini?')">Hapus Pekerja</a>
                        </td>
                    </tr>
                <?php
                }
            } else {
                echo "<tr><td colspan='9' style='text-align:center;'>Tidak ada data absensi.</td></tr>";
            }
            ?>
    </tbody>
</table>

<div class="pagination">
    <?php
    // Query untuk menghitung total data absensi
    $query_total_sql = "SELECT COUNT(*) as total FROM absensi";
    $query_total = mysqli_query($conn, $query_total_sql);
    $data_total = mysqli_fetch_assoc($query_total);
    $total_pages = ceil($data_total['total'] / $limit);

    if ($total_pages > 1) { // Tampilkan paginasi hanya jika ada lebih dari 1 halaman
        // Tombol Back/Previous
        if ($hu > 1) {
            echo '<a class="badge badge-info" href="index.php?folder=absensi&page=nama_file_anda&hu=' . ($hu - 1) . '">Back</a> '; // Ganti nama_file_anda.php
        }

        // Link halaman
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $hu) {
                echo '<a class="badge badge-secondary" href="index.php?folder=absensi&page=nama_file_anda&hu=' . $i . '">' . $i . '</a> '; // Ganti nama_file_anda.php
            } else {
                echo '<a class="badge badge-light" href="index.php?folder=absensi&page=nama_file_anda&hu=' . $i . '">' . $i . '</a> '; // Ganti nama_file_anda.php
            }
        }

        // Tombol Next
        if ($hu < $total_pages) {
            echo '<a class="badge badge-info" href="index.php?folder=absensi&page=nama_file_anda&hu=' . ($hu + 1) . '">Next</a>'; // Ganti nama_file_anda.php
        }
    }
    ?>
</div>

</form>
</div>
</div>
</div>
</div>
</html>
