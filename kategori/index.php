<?php include_once('header.php');
require_once "../config/config.php";
?>

<div class="row col-lg-12">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-white">Input Data Kategori</h4>
            </div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="card-body">
                            <?php
                            // mengambil data barang dengan kode paling besar
                            $query = mysqli_query($con, "SELECT max(id_kategori) as maxKode FROM kategori");
                            $data = mysqli_fetch_array($query);
                            $id = $data['maxKode'];


                            $urutan = $id;

                            $urutan++;

                            $id = sprintf("%03s", $urutan);
                            ?>
                            <form action="" enctype="multipart/form-data" method="post">
                                <div class="form-group" hidden>
                                    <div class="section-title mt-0">Id Ketgori</div>
                                    <div class="input-group mb-2">
                                        <input type="text" name="id" class="form-control" value="<?= $id ?>" readonly hidden>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="section-title mt-0">Nama Kategori</div>
                                    <div class="input-group mb-2">
                                        <input type="text" name="namakategori" class="form-control">
                                    </div>
                                </div>

                                <div class="card-footer bg-white">
                                    <button class="btn btn-primary mr-1" type="submit" name="submit">Submit</button>

                                </div>
                                </from>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-5">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-white">Data Kategori</h4>
            </div>
            <div class="card-body">

                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0 admin" id="admin">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Id Kategori</th>
                                        <th>Nama Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $SqlQuery = mysqli_query($con, "SELECT * FROM kategori");
                                    $no = 1;
                                    if (mysqli_num_rows($SqlQuery) > 0) {
                                        while ($row = mysqli_fetch_array($SqlQuery)) {
                                    ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row['id_kategori'] ?></td>
                                                <td><?= $row['nama_kategori'] ?></td>
                                                <td>
                                                    <a href="edit.php?id=<?= $row['id_kategori'] ?>" class="btn btn-primary btn-action mr-1" title="Edit"><i class="fas fa-pencil-alt"></i></a>

                                                    <a href="delete.php?id=<?= $row['id_kategori'] ?>" class="btn btn-danger btn-xs delete-data" title="hapus"><i class="fas fa-trash"></i></a>
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

<?php
if (isset($_POST['submit'])) {

    $id = $_POST['id'];
    $namakategori = $_POST['namakategori'];

    $sql = mysqli_query($con, "SELECT * FROM kategori where nama_kategori ='$namakategori'");
    $row = mysqli_num_rows($sql);
    if ($row > 0) {

        echo "<script type='text/javascript'>
                                setTimeout(function () { 
                                    swal({ 
                                        title: 'Maaf', 
                                        text: 'Data Kategori $namakategori sudah ada', 
                                        type: 'warning',
                                         timer: 3000,
                                          showConfirmButton: false });
                                },10);  
                                window.setTimeout(function(){ 
                                  window.location.replace('index.php');
                                } ,3000); 
                                </script>";
    } else {
        $save = mysqli_query($con, "INSERT INTO kategori VALUES ('$id', '$namakategori')") or die(mysqli_error($con));


        echo "<script type='text/javascript'>
                                setTimeout(function () { 
                                    swal({ 
                                        title: 'Suksess', 
                                        text: 'Data Berhasil Disimpan', 
                                        type: 'success',
                                         timer: 3000,
                                          showConfirmButton: false });
                                },10);  
                                window.setTimeout(function(){ 
                                  window.location.replace('index.php');
                                } ,3000); 
                                </script>";
    }
}

?>

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
<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
<?php include_once('footer.php');

?>