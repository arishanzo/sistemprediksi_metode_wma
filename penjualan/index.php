<?php include_once('header.php');
require_once "../config/config.php";
?>


<div class="row col-lg-12">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-white">Data Penjualan</h4>
            </div>
            <div class="card-body">
                <div class="card-body" style="text-align: right;">
                    <a class="btn btn-primary btn-action btn-xs mr-1" href="add.php" data-toggle="tooltip" title="Tambah Data"><span>Tambah Data</span></a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0 admin" id="admin">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kategori</th>
                                        <th>Bulan</th>
                                        <th>Tahun</th>
                                        <th>Jumlah</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $SqlQuery = mysqli_query($con, "SELECT * FROM `data` AS ak INNER JOIN kategori AS st ON st.id_kategori=ak.id_kategori WHERE ak.id_kategori=ak.id_kategori");
                                    $no = 1;
                                    if (mysqli_num_rows($SqlQuery) > 0) {
                                        while ($row = mysqli_fetch_array($SqlQuery)) {
                                    ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row['nama_kategori'] ?></td>
                                                <td><?= $row['bulan'] ?></td>
                                                <td><?= $row['tahun'] ?></td>
                                                <td><?= $row['jumlah'] ?></td>
                                                <td>
                                                    <a href="edit.php?id=<?= $row['id_data'] ?>" class="btn btn-primary btn-action mr-1" title="Edit"><i class="fas fa-pencil-alt"></i></a>

                                                    <a href="delete.php?id=<?= $row['id_data'] ?>" class="btn btn-danger btn-xs delete-data" title="hapus"><i class="fas fa-trash"></i></a>
                                                </td>

                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan=\"8\" align=\"center\">data tidak ada</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.admin').DataTable({
            "paging": true,

        });

    });
</script>
<script>
    // swall
    $('.delete-data').on('click', function(e) {
        e.preventDefault();
        var getLink = $(this).attr('href');

        Swal.fire({
            title: 'Apa Anda Yakin?',
            text: "Data akan dihapus permanen",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.value) {
                window.location.href = getLink;
            }
        })
    });
</script>
<div>
</div>
</div>

<?php include_once('footer.php');
?>