<html>
<div class="row">
    <div class="col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">
                <form>
                <h4>TABEL jabatan</h4>
                <a class="badge badge-success" href="index.php?folder=jabatan&page=c-tambah">Tambah</a>
                <!-- <a class="kembali" href="../menu.php">Kembali</a> -->
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>jabatan</th>
                            <th>gaji</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tr>
                        <?php
                            include 'koneksi.php';
                            $limit = 10; // Jumlah baris per halaman
                            $hu = isset($_GET['hu']) ? $_GET['hu'] : 1;
                            $start = ($hu - 1) * $limit;
                        
                            $query = mysqli_query($conn, "SELECT * FROM jabatan LIMIT $start, $limit");
                            while ($data=mysqli_fetch_array($query)){
                                ?>
                                <tr>
                                    <td><?php echo $data['id_jabatan'] ;?></td>
                                    <td><?php echo $data['namajabatan'] ;?></td>
                                    <td><?php echo $data['gajipokok'] ;?></td>
                                    <td>
                                    <a class="badge badge-primary" href="index.php?folder=jabatan&page=c-ubah&no_pol=<?php echo $data['no_pol'];?>" >Edit</a>
                                    <a class="badge badge-danger" href="jabatan/c-hapus.php?no_pol=<?php echo $data['no_pol']; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</a>				
                                    </td>
                                </tr>
                                </tr>
                        <?php } ?>

                </table>

                        <!-- <div class="pagination">
                            <?php
                            $query_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM jabatan");
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
