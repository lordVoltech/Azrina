<html>
<div class="row">
<div class="col-lg-8 grid-margin stretch-card mx-auto">
<div class="card">
<div class="card-body">

<form> <?php // Tag form di sini mungkin tidak diperlukan jika tidak ada input submit di dalamnya, tapi saya biarkan sesuai kode asli ?>
<h4>TABEL Absensi</h4>
<a class="badge badge-success" href="index.php?folder=absensi&page=bj-tambah">Tambah Absensi</a>
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
    <tbody>
        <?php
            include 'koneksi.php'; // Pastikan file ini ada dan koneksi $conn berhasil
            $limit = 10; // Jumlah baris per halaman
            // Asumsikan nama file/page yang menampilkan tabel ini adalah 'bj-lihat-absensi'
            $nama_page_ini = 'bj-lihat-absensi'; 

            $hu = isset($_GET['hu']) ? (int)$_GET['hu'] : 1; // Ambil halaman saat ini, pastikan integer
            $start = ($hu - 1) * $limit;
            $no = $start + 1; // Untuk penomoran baris

            // Query untuk mengambil data absensi dengan join
            $query_sql = "SELECT
                            absensi.id_absensi,
                            pekerja.nama_pekerja AS nama_pekerja_absensi,
                            proyek.nama_proyek,
                            mandor.nama_pekerja AS nama_mandor,
                            absensi.tgl_absensi,
                            absensi.status_hadir,
                            absensi.lembur,
                            absensi.keterangan
                            -- absensi.id_pekerja tidak lagi secara eksplisit dibutuhkan untuk link edit absensi
                        FROM
                            absensi
                        LEFT JOIN
                            pekerja ON absensi.id_pekerja = pekerja.id_pekerja
                        LEFT JOIN
                            proyek ON absensi.id_proyek = proyek.id_proyek
                        LEFT JOIN
                            pekerja AS mandor ON absensi.id_mandor = mandor.id_pekerja
                        ORDER BY absensi.tgl_absensi DESC, absensi.id_absensi DESC -- Contoh Urutan
                        LIMIT $start, $limit";
            
            $query_data_absensi = mysqli_query($conn, $query_sql);

            if (!$query_data_absensi) {
                echo "<tr><td colspan='9'>Error: " . mysqli_error($conn) . "</td></tr>";
            } elseif (mysqli_num_rows($query_data_absensi) > 0) {
                while ($data = mysqli_fetch_array($query_data_absensi)) {
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
                            <a class="badge badge-primary" href="index.php?folder=absensi&page=bj-ubah-absensi&id_absensi=<?php echo $data['id_absensi']; ?>">Edit Absensi</a>
                            
                            <?php // Tombol Hapus Absensi (Contoh jika Anda ingin menghapus absensi, bukan pekerja)
                                  // Jika Anda masih ingin tombol hapus pekerja, biarkan seperti kode asli Anda.
                                  // Baris di bawah ini adalah contoh untuk HAPUS ABSENSI:
                            ?>
                            <a class="badge badge-danger" href="index.php?folder=absensi&page=bj-hapus-absensi&id_absensi=<?php echo $data['id_absensi']; ?>" onclick="return confirm('Anda yakin ingin menghapus data absensi ini?')">Hapus Absensi</a>
                            
                            <?php // Jika Anda ingin mempertahankan tombol hapus pekerja dari kode asli Anda:
                                  // <a class="badge badge-danger" href="pekerja/bj-hapus.php?id_pekerja=<?php // echo $data_asli['id_pekerja']; // Anda perlu select id_pekerja jika mau pakai ini ?>" onclick="return confirm('Anda yakin ingin menghapus data pekerja terkait absensi ini?')">Hapus Pekerja</a>
                            ?>
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
            echo '<a class="badge badge-info" href="index.php?folder=absensi&page=' . $nama_page_ini . '&hu=' . ($hu - 1) . '">Back</a> ';
        }

        // Link halaman
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $hu) {
                echo '<a class="badge badge-secondary" href="index.php?folder=absensi&page=' . $nama_page_ini . '&hu=' . $i . '">' . $i . '</a> ';
            } else {
                echo '<a class="badge badge-light" href="index.php?folder=absensi&page=' . $nama_page_ini . '&hu=' . $i . '">' . $i . '</a> ';
            }
        }

        // Tombol Next
        if ($hu < $total_pages) {
            echo '<a class="badge badge-info" href="index.php?folder=absensi&page=' . $nama_page_ini . '&hu=' . ($hu + 1) . '">Next</a>';
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
