<?php
if (isset($_GET['id'])) {

    $database = new Database();
    $db = $database->getConnection();

    if (isset($_POST['button_update'])) {

        $updateSql = "UPDATE bagian SET nama_bagian = ?, karyawan_id = ?, lokasi_id = ? WHERE id = ?";
        $stmt = $db->prepare($updateSql);
        $stmt->bindParam(1, $_POST['nama_bagian']);
        $stmt->bindParam(2, $_POST['karyawan_id']);
        $stmt->bindParam(3, $_POST['lokasi_id']);
        $stmt->bindParam(4, $_POST['id']);
        if ($stmt->execute()) {
            $_SESSION['hasil_update'] = true;
        } else {
            $_SESSION['hasil_update'] = false;
        }
        echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
    }

    $id = $_GET['id'];
    $findSql = "SELECT * FROM bagian WHERE id = ?";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1, $_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch();
    if (isset($row['id'])) {
?>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Bagian</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                            <li class="breadcrumb-item"><a href="?page=lokasiread">Bagian</a></li>
                            <li class="breadcrumb-item active">Ubah Data</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ubah Bagian</h3>
                </div>
                <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="id" value="<?= $row['id'] ?>">
                        <label for="nama_lokasi">Nama Bagian</label>
                        <input type="text" name="nama_bagian" class="form-control" value="<?= $row['nama_bagian'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="nama_lokasi">Kepala Bagian</label>
                        <select name="karyawan_id" class="form-control">
                            <option value="">--Pilih Kepala Bagian--</option>
                            <?php
                                $database = new Database();
                                $db = $database->getConnection();

                                $selectSql = "SELECT id, nama_lengkap  FROM karyawan";
                                $stmt_karyawan = $db->prepare($selectSql);
                                $stmt_karyawan->execute();

                                while($row_kry = $stmt_karyawan->fetch(PDO::FETCH_ASSOC)) {
                                    $selectedValue = $row_kry["id"] == $row["karyawan_id"] ? " selected" : "";
                                    echo "<option $selectedValue value=\"".$row_kry['id']."\">".$row_kry['nama_lengkap']."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_lokasi">Bagian</label>
                        <select name="lokasi_id" class="form-control">
                            <option value="" selected>--Pilih Bagian--</option>
                            <?php
                                $database = new Database();
                                $db = $database->getConnection();

                                $selectSql = "SELECT * FROM lokasi";
                                $stmt_lokasi = $db->prepare($selectSql);
                                $stmt_lokasi->execute();

                                while($row_lks = $stmt_lokasi->fetch(PDO::FETCH_ASSOC)) {
                                    $selectedLokasi = $row_lks["id"] == $row["lokasi_id"] ? " selected" : "";
                                    echo "<option $selectedLokasi value=\"".$row_lks['id']."\">".$row_lks['nama_lokasi']."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
                        <i class="fa fa-times"></i> Batal
                    </a> 
                    <button type="submit" name="button_update" class="btn btn-success btn-sm float-right">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </form>
                </div>
            </div>
        </section>
<?php
    } else {
        $_SESSION['hasil_update'] = false;
        echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
    }
} else {
    $_SESSION['hasil_update'] = false;
    echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
}
include_once "partials/scripts.php" 
?>