<?php
    if(isset($_POST['button_create'])){
        
        $database = new Database;
        $db = $database->getConnection();

        // ini untuk validasi input
        $validasi = "SELECT * FROM lokasi WHERE nama_lokasi = ?";
        $stmt = $db->prepare($validasi);
        $stmt->bindParam(1, $_POST['nama_lokasi']);
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

            $insertSQL = "INSERT INTO lokasi SET nama_lokasi = ?";
            $stmt = $db->prepare($insertSQL);  
            $stmt->bindParam(1, $_POST['nama_lokasi']);
            
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
              <li class="breadcrumb-item active">Tambah Lokasi</li>
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
                <h3 class="card-title">Tambah Lokasi</h3>
                <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
                Kembali
                </a>
            </div>

            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nama_lokasi">Nama Lokasi</label>
                        <input type="text" name="nama_lokasi" class="form-control">
                    </div>
                    <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
                        <i class="fa fa-times"></i> Batal
                    </a> 
                    <button type="submit" name="button_create" class="btn btn-success btn-sm float-right">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- /.content -->
<?php include_once "partials/scripts.php" ?>