<?php
require 'function.php';
require 'cek.php';
$no =1;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Stock Barang</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">Kelompok 11(ST)</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
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
                    <div class="container-fluid">
                        <h1 class="mt-4">Barang Masuk</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Tambah Barang
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Supplier</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $ambil_semua_data_stock = mysqli_query($conn, "SELECT * FROM masuk m, stock s where s.idbarang = m.idbarang");
                                            while ($data = mysqli_fetch_array($ambil_semua_data_stock)) {
                                                $id_masuk = $data['idmasuk'];
                                                $id_barang = $data['idbarang'];
                                                $tanggal = $data['tanggal']; 
                                                $nama_barang = $data['namabarang']; 
                                                $qty = $data['qty'];
                                                $keterangan = $data['keterangan'];
                                                ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $nama_barang; ?></td>
                                                    <td><?= $qty; ?></td>
                                                    <td><?= $keterangan; ?></td>
                                                    <td><?= $tanggal; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $id_barang; ?>">
                                                        Edit
                                                        </button>
                                                        <input type="hidden" name="idbarangyangakandihapus" value="<?=$id_barang;?>">
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $id_barang; ?>">
                                                        Delete
                                                        </button>
                                                    </td>
                                                    
                                                </tr>
                                                     <!-- Edit Modal -->
                                                        <div class="modal fade" id="edit<?= $id_barang; ?>">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <!-- Modal Header -->
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Edit Barang Masuk</h4>
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>
                                                                    <!-- Modal body -->
                                                                    <form method="post">
                                                                        <div class="modal-body">
                                                                            <input type="text" name="namabarang" value="<?= $nama_barang; ?>" class="form-control" required>
                                                                            <br>
                                                                            <input type="text" name="keterangan" value="<?= $keterangan; ?>" class="form-control" required>
                                                                            <br>
                                                                            <input type="text" name="qty" value="<?= $qty; ?>" class="form-control" required>
                                                                            <br>
                                                                            <button type="submit" class="btn btn-primary" name="update_barang_masuk">Submit</button>
                                                                            <input type="hidden" name="idbarang" value="<?= $id_barang; ?>">
                                                                            <input type="hidden" name="idmasuk" value="<?= $id_masuk; ?>">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                        
                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete<?= $id_barang; ?>">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Hapus Barang Masuk?</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <!-- Modal body -->
                                                                <form method="post">
                                                                    <div class="modal-body">
                                                                        Apakah Anda yakin ingin menghapus <?= $nama_barang; ?>?
                                                                        <br>
                                                                        <br>
                                                                        <input type="hidden" value="<?= $id_barang; ?>" name="idbarang">
                                                                        <input type="hidden" value="<?= $id_masuk; ?>" name="idmasuk">
                                                                        <button type="submit" class="btn btn-danger" name="hapus_barang_masuk">Hapus</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                 

                                                <?php
                                                $no++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
    <!-- The Modal -->
    <div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Tambah Barang Masuk</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form method="post">
            <div class="modal-body">
                <select name="barangnya" class="form-control">
                    <?php
                    // Mengambil semua data dari tabel 'stock'
                    $result = mysqli_query($conn, "SELECT * FROM stock");
                    while ($row = mysqli_fetch_array($result)) {
                        $namabarang = $row['namabarang'];
                        $idbarang = $row['idbarang'];
                    ?>
                        <option value="<?= $idbarang; ?>"><?= $namabarang; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <br>
                <input type="number" name="qty" class="form-control" placeholder="Quantity" required>
                <br>
                <input type="text" name="penerima" class="form-control" placeholder="Nama Supplier" required>
                <br>
                <button type="submit" class="btn btn-primary" name="barang_masuk">Submit</button>
            </div>
        </form>

</html>
