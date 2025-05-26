<html>

<div class="row">
    <div class="col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">
<form>

<h4>TABEL PEKERJA</h4>
<a class="badge badge-success" href="index.php?folder=pekerja&page=bj-tambah">Tambah</a>
<!-- <a class="kembali" href="../menu.php">Kembali</a> -->
<table class="table table-stripped" width="100%">
    <thead>
    <tr>
        <th>No</th>
        <th>ID Pekerja</th>
        <th>ID Proyek</th>
        <th>ID Mandor</th>
        <th>Tanggal Absen</th>
        <th>Hadir</th>
        <th>Lembur</th>
        <th>Keterangan</th>
        <th>aksi</th>
    </tr>
    </thead>
    <tr>
        <?php
            include 'koneksi.php';
            $limit = 10; // Jumlah baris per halaman
            $hu = isset($_GET['hu']) ? $_GET['hu'] : 1;
            $start = ($hu - 1) * $limit;
        
            $query = mysqli_query($conn, "SELECT * FROM absensi  LIMIT $start, $limit");
            while ($data=mysqli_fetch_array($query)){
                ?>
                <tr>
                    <td><?php echo $data['id_absensi'] ;?></td>
                    <td><?php echo $data['namapekerja'] ;?></td>
                    <td><?php echo $data['nama_proyek'] ;?></td>
                    <td><?php echo $data['nama mandor'] ;?></td>
                    <td><?php echo $data['tanggal'] ;?></td>
                    <td><?php echo $data['hadir'] ;?></td>
                    <td><?php echo $data['lembur'] ;?></td>
                    <td><?php echo $data['keterangan'] ;?></td>
                    <td>
                    <a class="badge badge-primary" href="index.php?folder=pekerja&page=bj-ubah&id_pekerja=<?php echo $data['id_pekerja'];?>" >Edit</a>
                    <a class="badge badge-danger" href="pekerja/bj-hapus.php?id_pekerja=<?php echo $data['id_pekerja'];?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</a>				
                    </td>
                </tr>
                </tr>
        <?php } ?>
        
</table>

        <!-- <div class="pagination">
            <?php
            $query_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM absensi");
            $data_total = mysqli_fetch_assoc($query_total);
            $total_pages = ceil($data_total['total'] / $limit);

            if ($page > 1) {
                echo '<a href="?page=' . ($page - 1) . '">Back</a>';
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo '<a href="?page=' . $i . '" class="current">' . $i . '</a>';
                } else {
                    echo '<a href="?page=' . $i . '">' . $i . '</a>';
                }
            }

            if ($page < $total_pages) {
                echo '<a href="?page=' . ($page + 1) . '">Next</a>';
            }
            ?>
        </div> -->
</form>

        </div>
        </div>
        </div>
        </div>
</html>
