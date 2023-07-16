<?php
// include database connection file
include_once("koneksi/config.php");

$nidn        = "";
$nama       = "";
$nohp     = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from dosen where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from dosen where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nidn        = $r1['nidn'];
    $nama       = $r1['nama'];
    $nohp       = $r1['nohp'];

    if ($nidn == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nidn        = $_POST['nidn'];
    $nama       = $_POST['nama'];
    $nohp     = $_POST['nohp'];

    if ($nidn && $nama && $nohp ) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update dosen set nidn = '$nidn',nama='$nama',nohp = '$nohp' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into dosen(nidn,nama,nohp) values ('$nidn','$nama','$nohp')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Data Dosen Universitas Al-Khairiyah</h1>
        <ol class="breadcrumb mb-4">
        </ol>

        <!-- Class Create -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-plus"></i>
                Masukkan data Dosen
            </div>

            <div class="card-body">
            <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nidn" class="col-sm-2 col-form-label">NIDN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nidn" name="nidn" value="<?php echo $nidn ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nohp" class="col-sm-2 col-form-label">No Hp</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nohp" name="nohp" value="<?php echo $nohp ?>">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>

        </div>
    </div>
</main>




    <!-- ======================================================================================================================================= -->




    <!-- Class Read  -->
    <?php
    // Create database connection using config file
    include_once("koneksi/config.php");

    // Fetch all users data from database
    $result = mysqli_query($koneksi, "SELECT * FROM dosen ORDER BY id DESC");

    ?>
<main>
    <div class="container-fluid px-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-building-columns me-1"></i>
                Data Dosen Universitas Al-Khairiyah
            </div>
            <div class="card-body">
            <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from dosen order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id         = $r2['id'];
                            $nidn       = $r2['nidn'];
                            $nama       = $r2['nama'];
                            $nohp       = $r2['nohp'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nidn ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $nohp ?></td>
                                <td scope="row">
                                    <a href="dosen.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="dosen.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</main>