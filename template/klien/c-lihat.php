<html>

<div class="row">
    <div class="col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">
                <h3 style="text-align : center;"> Data Anggota</h3>
                <form>
                    <a class="badge badge-success" href="index.php?folder=klien&page=c-tambah">Tambah</a>
                    <!-- <a class="kembali" href="../menu.php">Kembali</a> -->
                    <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr >
                            <th>No ID</th>
                            <th>Nama</th>
                            <th>alamat</th>
                            <th>no HP</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tr>
                            <?php
                                include 'koneksi.php';
                                $limit = 10; // Jumlah baris per halaman
                                $hu = isset($_GET['hu']) ? $_GET['hu'] : 1;
                                $start = ($hu - 1) * $limit;
                            
                                $query = mysqli_query($conn, "SELECT * FROM klien LIMIT $start, $limit");
                                while ($data=mysqli_fetch_array($query)){
                                    ?>
                                    <tr>
                                        <td><?php echo $data['id_klien'] ;?></td>
                                        <td><?php echo $data['nama_cos'] ;?></td>
                                        <td><?php echo $data['alamat'] ;?></td>
                                        <td><?php echo $data['no_hp'] ;?></td>
                                        <td>
                                        <a class="badge badge-primary" href="index.php?folder=klien&page=c-ubah&id_klien=<?php echo $data['id_klien'];?>" >Edit</a> 
                                        <a class="badge badge-danger" href="klien/c-hapus.php?id_klien=<?php echo $data['id_klien']; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</a>				
                                        </td>
                                    </tr>
                                    </tr>
                            <?php } ?>

                    </table>
                    <!-- <div class="pagination">
                    <?php
                            $query_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM klien");
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
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</html>
