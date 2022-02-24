<?php

if(isset($_GET['id'])){

    $database = new Database();
    $db = $database->getConnection();

    $id = $_GET['id'];
    $findSql = "SELECT * FROM lokasi WHERE id = ?";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1, $_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch();
    
    if(isset($row['id'])){
        if(isset($_POST['button_update'])){

            $database = new Database();
            $db = $database->getConnection();

            $validateSql = "SELECT * FROM lokasi WHERE nama_lokasi = ? AND id != ?";
            $stmt = $db->prepare($validateSql);
            $stmt->bindParam(1, $_POST['nama_lokasi']);
            $stmt->bindParam(2, $_POST['id']);
            $stmt->execute();

            if($stmt->rowCount() > 0 ){
        ?>          

            <div class="alert alert-danger alert-dismissible">
                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                <h5><i class="icon fas fa-check"></i> Gagal </h5>
                Nama Lokasi Sama sudah ada.
            </div>

        <?php

            }else{
                $updateSql = "UPDATE lokasi SET nama_lokasi = ? WHERE id = ?";
                $stmt = $db->prepare($updateSql);
                $stmt->bindParam(1, $_POST['nama_lokasi']);
                $stmt->bindColumn(2, $_POST['id']);

                if($stmt->execute()){
                    $_SESSION['hasil'] = true;
                    $_SESSION['pesan'] = "Berhasil Simpan Data";
                }else{
                    $_SESSION['hasil'] = false;
                    $_SESSION['pesan'] = "Gagal Simpan Data";
                }
                echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
            }
        }
    }
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Lokasi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Lokasi</li>
              <li class="breadcrumb-item active">Edit Lokasi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Lokasi</h3>
                <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
                Kembali
                </a>
            </div>

            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nama_lokasi">Nama Lokasi</label>
                        <input type="hidden" name="id" class="form-control" value="<?= $row['id']  ?>">
                        <input type="text" name="nama_lokasi" class="form-control" value="<?= $row['nama_lokasi']  ?>">
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
    </div>
    <!-- /.content -->
<?php include_once "partials/scripts.php" ?>