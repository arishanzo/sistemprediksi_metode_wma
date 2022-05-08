<?php include_once('header.php');
require_once "../config/config.php";
?>

<div class="row col-lg-12">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-success">
                <h4 class="text-white">Data Admin</h4>
            </div>

            <div class="card-body">
                <div class="card-body">
                    <a class="btn btn-success btn-action btn-xs mr-1" href="add.php" data-toggle="tooltip" title="Tambah Data"><span>Tambah Admin</span></a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 admin" id="admin">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $SqlQuery = mysqli_query($con, "select * from admin");
                                $no = 1;
                                if (mysqli_num_rows($SqlQuery) > 0) {
                                    while ($row = mysqli_fetch_array($SqlQuery)) {
                                ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row['nama_admin'] ?></td>
                                            <td><?= $row['username'] ?></td>
                                            <td>
                                                <a href="edit.php?id=<?= $row['id_admin'] ?>" class="btn btn-primary btn-action mr-1" title="Edit"><i class="fas fa-pencil-alt"></i></a>

                                                <a href="delete.php?id=<?= $row['id_admin'] ?>" class="btn btn-danger btn-xs delete-data" title="hapus"><i class="fas fa-trash"></i></a>
                                            </td>

                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan=\"4\" align=\"center\">data tidak ada</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal fade" id="tambahdata" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Kriteria</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    <?php
                                    // mengambil data barang dengan kode paling besar
                                    $query = mysqli_query($con, "SELECT max(id_user) as maxKode FROM user");
                                    $data = mysqli_fetch_array($query);
                                    $id_kriteria = $data['maxKode'];

                                    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
                                    // dan diubah ke integer dengan (int)
                                    $urutan = (int) substr($id_kriteria, 3, 3);

                                    $urutan++;
                                    $huruf = "USR";
                                    $id_user = $huruf . sprintf("%03s", $urutan);
                                    ?>
                                    <div class="form-group">
                                        <div class="section-title mt-0">id Kategori Produk</div>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="iduser" value="<?php echo $id_user ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="section-title mt-0">Nama</div>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="nama">
                                        </div>
                                        <div class="form-group">
                                            <div class="section-title mt-0">Username</div>
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="username">
                                            </div>
                                            <div class="form-group">
                                                <div class="section-title mt-0">Password</div>
                                                <div class="input-group mb-2">
                                                    <input type="password" class="form-control" name="password">
                                                </div>
                                                <div class="form-group">
                                                    <label for="jabatan">
                                                        <div class="section-title mt-0"> jabatan </div>
                                                    </label>

                                                    <select class="custom-select" id="jabatan" name="jabatan">
                                                        <option selected disabled>Pilih</option>
                                                        <option value="1">Petugas</option>
                                                        <option value="2">Pemilik</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="section-title">File Browser</div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="customFile" id="customFile">
                                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="modal-footer">
                                        <button class="btn btn-primary mr-1" type="submit" name="submit">Simpan</button>

                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                                    </div>
                            </div>
                            </form>
                        </div>

                    </div>
                </div>
                </section>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>

<?php
if (isset($_POST['submit'])) {
    $tempdir = "asset/assets/img/fotouser";

    $id_user = $_POST['iduser'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $pass_enskripsi = md5($password);
    $jabatan = $_POST['jabatan'];
    $File = $_POST['customFile'];
    $file_name = $_FILES['customFile']['name'];

    if ($file == '') {
        echo "<script type='text/javascript'>
                            setTimeout(function () { 
                                swal({ 
                                    title: 'Warning', 
                                    text: 'HARAP UPLOAD FOTO TERLEBIH DAHULU', 
                                    type: 'warning',
                                     timer: 3000,
                                      showConfirmButton: false });
                            },10);  
                            window.setTimeout(function(){ 
                              window.location.replace('#');
                            } ,3000); 
                            </script>";
    } else {
        $file_name = $_FILES['customFile']['name'];
        $file_size = $_FILES['customFile']['size'];
        $file_type = $_FILES['customFile']['type'];

        $image   = addslashes(file_get_contents($_FILES['customFile']['tmp_name']));

        $tmp_name = $_FILES['customFile']['tmp_name'];
        move_uploaded_file($tmp_name, "../asset/assets/img/fotouser" . $file_name);

        if ($file_size < 2048000 and ($file_type == 'image/jpeg' or $file_type == 'image/png' or $file_type == 'image/jpg')) {
            $save = mysqli_query($con, "INSERT INTO user VALUES ('$id_user', '$nama', '$username', '$pass_enskripsi', '$jabatan','$file_name' )") or die(mysqli_error($con));

            echo "<script type='text/javascript'>
                                setTimeout(function () { 
                                    swal({ 
                                        title: 'Suksess', 
                                        text: 'Data Berhasil Disimpan $nama', 
                                        type: 'success',
                                         timer: 3000,
                                          showConfirmButton: false });
                                },10);  
                                window.setTimeout(function(){ 
                                  window.location.replace('index.php');
                                } ,3000); 
                                </script>";
        } else {
            echo "<script type='text/javascript'>
                                setTimeout(function () { 
                                    swal({ 
                                        title: 'Warning', 
                                        text: 'File Melebihi Ukuran atau Tidak Sesuai', 
                                        type: 'warning',
                                         timer: 3000,
                                          showConfirmButton: false });
                                },10);  
                                window.setTimeout(function(){ 
                                  window.location.replace('index.php');
                                } ,3000); 
                                </script>";
        }
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
<div>
</div>
</div>

<?php include_once('footer.php');
?>