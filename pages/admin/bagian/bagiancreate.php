  <?php
    if(isset($_POST['button_create'])){

      $database = new Database();
      $db = $database->getconnection();

      $validasi = "SELECT * FROM bagian WHERE nama_bagian= ?";
      $stmt = $db->prepare($validasi);
      $stmt->bindParam(1, $_POST['nama_bagian']);
      $stmt->execute();

      if($stmt->rowCount() > 0 ){
        ?>
        <div class="alert alert-danger alert-dismissible">
          <button class="close" type="button" data-dismiss="alert" aria hidden="true">x</button>
          <h5><i class="icon fas fa-check"></i> Gagal </h5>
          Nama Bagian sudah ada.
          </div>
          <?php
      }else{

      // ini untuk validasi input
      $insertSQL = "INSERT INTO bagian SET nama_bagian= ?, karyawan_id= ?, lokasi_id= ?";
      $stmt = $db->prepare($insertSQL);
      $stmt->bindParam(1, $_POST['nama_bagian']);
      $stmt->bindParam(2, $_POST['karyawan_id']);
      $stmt->bindParam(3, $_POST['lokasi_id']);

      if($stmt->execute()){
        $_SESSION['hasil'] = true;
        $_SESSION['pesan'] = "Berhasil Simpan Data";
      }else{
        $_SESSION['hasil'] = false;
        $_SESSION['pesan'] = "Gagal Simpan Data";
      }
      echo "<meta http-equiv='refresh' content='0;url=?pagebagianread'>";
  }
}

  ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">bagian</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">bagian</li>
              <li class="breadcrumb-item active">Tambah bagian</li>
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
        <h3 class="card-title">Tambah bagian</h3>
        <a href="?page=bagianread" class="btn btn-danger btn-sm float-right">
            <i class="fa fa-arrow back-circle"></i> Kembali
        </a>
        </div>

        <div class="card-body">
         <form action="" method="post">
         <div class="form-group">
          <label class="nama_bagian">Nama Bagian</label>
          <input type="text" name="nama_bagian" class="form-control">
          </div>
          

          <div class="form-group">
          <label class="nama_kepala_bagian">Nama Kepala bagian</label>
          <select name="karyawan_id" class="form-control">
            <option value="" selected>--Pilih Kepala Bagian--</option>
            <?php
            $database = new Database();
            $db = $database->getConnection();

            $selectSql = "SELECT * FROM karyawan";
            $stmt_karyawan = $db->prepare($selectSql);
            $stmt_karyawan->execute();

            while($row_kry = $stmt_karyawan->fetch(PDO::FETCH_ASSOC)) {
              echo "<option value=\"".$row_kry['id']."\">".$row_kry['nama_lengkap']."</option>";
            }
?>

</select>
          </div>
          
          <div class="form-group">
          <label class="nama_lokasi_bagian">Nama Lokasi bagian</label>
          <select name="lokasi_id" class="form-control">
          <option value="" selected>--Pilih Lokasi--</option>
                            <?php
                                $database = new Database();
                                $db = $database->getConnection();

                                $selectSql = "SELECT * FROM lokasi";
                                $stmt_lokasi = $db->prepare($selectSql);
                                $stmt_lokasi->execute();

                                while($row_lks = $stmt_lokasi->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value=\"".$row_lks['id']."\">".$row_lks['nama_lokasi']."</option>";
                                }
                            ?>
                        </select>
                        </div>
          <a href="?page=bagiancreate" class="btn btn-danger btn-sm float-right">
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
    <?php include_once "partials/scriptsdatatables.php" ?>