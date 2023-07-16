<?php
include_once("koneksi/config.php");

$judul = "";
$id_mahasiswa = "";
$id_dosen = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "DELETE FROM tugas_akhir WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error = "Gagal melakukan delete data";
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM tugas_akhir WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $judul = $r1['judul'];
    $id_mahasiswa = $r1['id_mahasiswa'];
    $id_dosen = $r1['id_dosen'];

    if ($judul == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) { // Untuk create
    $judul = $_POST['judul'];
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $id_dosen = $_POST['id_dosen'];

    if ($judul && $id_mahasiswa && $id_dosen) {
        if ($op == 'edit') { // Untuk update
            $sql1 = "UPDATE tugas_akhir SET judul = '$judul', id_mahasiswa = '$id_mahasiswa', id_dosen = '$id_dosen' WHERE id = '$id'";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
            }
        } else { // Untuk insert
            $sql1 = "INSERT INTO tugas_akhir (judul, id_mahasiswa, id_dosen) VALUES ('$judul', '$id_mahasiswa', '$id_dosen')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil memasukkan data baru";
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}

?>


<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tugas Akhir Mahasiswa</h1>
        <ol class="breadcrumb mb-4">
        </ol>

        <!-- Class Create -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-plus"></i>
                Masukkan Data Tugas Akhir
            </div>

            <div class="card-body">
                <?php if ($error) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>

                <?php if ($sukses) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses; ?>
                    </div>
                <?php } ?>

                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="judul" class="col-sm-2 col-form-label">Judul Tugas Akhir</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $judul; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="id_mahasiswa" class="col-sm-2 col-form-label">Mahasiswa</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_mahasiswa" id="id_mahasiswa">
                                <option>---</option>
                                <?php
                                $query_mahasiswa = mysqli_query($koneksi, "SELECT * FROM mahasiswa") or die(mysqli_error($koneksi));
                                while ($data_mahasiswa = mysqli_fetch_array($query_mahasiswa)) {
                                    echo "<option value='" . $data_mahasiswa['id'] . "'" . ($data_mahasiswa['id'] == $id_mahasiswa ? "selected" : "") . ">" . $data_mahasiswa['nama'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="id_dosen" class="col-sm-2 col-form-label">Dosen Pembimbing</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_dosen" id="id_dosen">
                                <option>---</option>
                                <?php
                                $query_dosen = mysqli_query($koneksi, "SELECT * FROM dosen") or die(mysqli_error($koneksi));
                                while ($data_dosen = mysqli_fetch_array($query_dosen)) {
                                    echo "<option value='" . $data_dosen['id'] . "'" . ($data_dosen['id'] == $id_dosen ? "selected" : "") . ">" . $data_dosen['nama'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>

        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-building-columns me-1"></i>
                Data Tugas Akhir Mahasiswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Judul Tugas Akhir</th>
                            <th scope="col">Mahasiswa</th>
                            <th scope="col">Dosen Pembimbing</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query_tugas_akhir = mysqli_query($koneksi, "SELECT tugas_akhir.id, tugas_akhir.judul, mahasiswa.nama AS nama_mahasiswa, dosen.nama AS nama_dosen FROM tugas_akhir INNER JOIN mahasiswa ON tugas_akhir.id_mahasiswa = mahasiswa.id INNER JOIN dosen ON tugas_akhir.id_dosen = dosen.id") or die(mysqli_error($koneksi));
                        $nomor = 1;
                        while ($tugas_akhir = mysqli_fetch_array($query_tugas_akhir)) { 
                            $judul              = $tugas_akhir['judul'];
                            $nama_mahasiswa     = $tugas_akhir['nama_mahasiswa'];
                            $nama_dosen         = $tugas_akhir['nama_dosen'];
                            $id                 = $tugas_akhir['id'];
                            ?>
                         
                         <tr>
                                <th scope="row"><?php echo $nomor++ ?></th>
                                <td scope="row"><?php echo $judul ?></td>
                                <td scope="row"><?php echo $nama_mahasiswa ?></td>
                                <td scope="row"><?php echo $nama_dosen ?></td>
                                <td scope="row">
                                    <a href="tugasakhir.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="tugasakhir.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
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