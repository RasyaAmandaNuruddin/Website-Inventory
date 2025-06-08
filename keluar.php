<?php
require 'function.php';
require 'cek.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap5.css">
    </head>
    <body class="sb-nav-fixed">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#example').DataTable( {
                    dom: 'Bfrtip',
                    
                });
            });
        </script>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
             <img src="logofis.jpg" alt="Logofis" style="height: 40px; margin-right: 10px; margin-left: 15px;">
            <a class="navbar-brand ps-2" href="index.php">PT. Fan Indonesia Sejahtera</a>
            <!-- Sidebar Toggle-->
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stok barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Keluar
                            </a>
                             <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Barang keluar</h1>
                        <?php if (isset($_SESSION['msg'])): ?>
                        <div class="alert alert-<?= $_SESSION['msg']['type']; ?> alert-dismissible fade show" role="alert">
                            <?= $_SESSION['msg']['text']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <?= $_SESSION['success']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                            <?= $_SESSION['error']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                        <div class="card mb-4">
                            <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Barang keluar
                            </button>
                            <button type="button" class="btn btn-success" onclick="window.location.href='exportkeluar.php'">
                                Ekspor Data
                            </button>
                            <br>
                            <div class="row mt-4">
                                <div class="col">
                                    <form method="post" class="d-flex"><!-- karena bootsrap 5 gak bisa pakai form-inline -->
                                        <input type="date" name="tgl_mulai" class="form-control" style="width: 200px; margin-right: 10px;">
                                        <input type="date" name="tgl_selesai" class="form-control" style="width: 200px; margin-right: 10px;"><br>
                                        <button type="submit" name="filtertanggal" class="btn btn-info">Filter</button>
                                    </form>
                                </div>
                            </div>
                            </div>
                            <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Barang</th>
                                            <th  class="text-center">Jumlah</th>
                                            <th>Penerima</th>
                                            <th>Aksi</th>
                                        </tr>

                                    </thead>
                                    <tbody>

                                    <?php
                                        $ambilsemuadatastok = mysqli_query($conn,"select * from keluar k, stok s where s.idbarang = k.idbarang");
                                        while($data=mysqli_fetch_array($ambilsemuadatastok)){
                                            $idk=$data['idkeluar'];
                                            $id=$data['idbarang'];
                                            $tanggal=$data['tanggal'];
                                            $namabarang =$data['namabarang'];
                                            $qty =$data['qty'];
                                            $penerima=$data['penerima'];
                                        
                                        ?>
                                        <tr>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$namabarang;?></td>
                                            <td  class="text-center"><?=$qty;?></td>
                                            <td><?=$penerima;?></td>
                                            <td>
                                            <!-- Button to Open the Modal -->
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$idk;?>">
                                            edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idk;?>">
                                            Delete
                                            </button>
                                        </td>
                                        </tr>

                                        <!-- EDIT Modal Header -->
                                        <div class="modal fade" id="edit<?=$idk;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Barang</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <!-- Modal body -->
                                            <form method="post">
                                            <div class="modal-body">
                                            <label for="">Penerima Barang</label>
                                                <input type="text" name="penerima" value="<?=$penerima;?>" class="form-control"required><br>
                                                <label for="">Jumlah Barang</label>
                                                <input type="number" name="qty" value="<?=$qty;?>" class="form-control"required><br>
                                                <input type="hidden" name="id" value="<?=$id;?>">
                                                <input type="hidden" name="idk" value="<?=$idk;?>">
                                                <button type="submit" class="btn btn-primary" name="updatebarangkeluar">Simpan</button>
                                            </div>
                                            </form>
                                            </div>
                                        </div>
                                        </div>

                                        <!-- DELETE Modal Header -->
                                        <div class="modal fade" id="delete<?=$idk;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Barang ?</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <!-- Modal body -->
                                            <form method="post">
                                            <div class="modal-body">
                                                Apakah Anda Yakin ingin Hapus <?=$namabarang;?>?
                                                <input type="hidden" name="id" value="<?=$id;?>">
                                                <input type="hidden" name="kty" value="<?=$qty;?>">
                                                <input type="hidden" name="idk" value="<?=$idk;?>">
                                                <br>
                                                <br>
                                                <button type="submit" class="btn btn-danger" name="hapusbarangkeluar">hapus</button>
                                                <a href="keluar.php" class="btn btn-secondary">Batal</a>
                                            </div>
                                            </form>
                                            </div>
                                        </div>
                                        </div>
                                        <?php 
                                        };

                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; PT.Fan Indonesia Sejahtera Website 2025</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
      <!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Barang keluar</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
       <form method="post">
      <div class="modal-body">
      <select name="barangnya" class="form-control">
        <option value="" disabled selected>--pilih nama barang--</option>
        <?php
         $ambildatanya=mysqli_query($conn,"select* from stok");
         while($fetcharray=mysqli_fetch_array($ambildatanya)){
            $namabarang=$fetcharray['namabarang'];
            $idbarang=$fetcharray['idbarang'];
            ?>
            <option value="<?= $idbarang; ?>"><?= $namabarang; ?></option>
            <?php
         }
        ?>
        </select><br>
        
        <input type="number" name="qty" placeholder="quantity barang" class="form-control" required><br>
        <input type="text" name="penerima" placeholder="penerima barang" class="form-control" required><br>
        <button type="submit" class="btn btn-primary" name="addbarangkeluar">Kirim</button>
      </div>
      </form>

    </div>
  </div>
</div>
</html>