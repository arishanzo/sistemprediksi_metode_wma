<?php include_once('header.php');
require_once "../config/config.php";
?>



<div class="row col-lg-12">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-white">Laporan</h4>
            </div>
            <div class="card-body">
                <div class="modal-body">
                    <form action="<?= base_url() ?>//laporan/cetak.php" method="POST">
                        <div class="form-group">
                            <label for="kategori">
                                <div class="section-title mt-0"> Nama Kategori </div>
                            </label>

                            <select class="custom-select" id="namakategori" name="namakategori">
                                <option disabled selected> Pilih Kategori</option>
                                <?php

                                $sql2 = mysqli_query($con, "SELECT * FROM kategori ");
                                while ($row2 = mysqli_fetch_array($sql2)) {
                                ?>
                                    <option value="<?= $row2['nama_kategori'] ?>"><?= $row2['nama_kategori'] ?></option>
                                <?php

                                }

                                ?>
                            </select>
                        </div>


                        <div class="modal-footer">
                            <button class="btn btn-danger mr-1" type="submit" name="pdf">PDF</button>

                            <button type="submit" class="btn btn-success" name="excel">EXCEL</button>

                        </div>
                </div>
                </form>
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