<?php
session_start();

//Membuat Koneksi ke database
$conn = mysqli_connect("localhost","root","","stockbarang");


//Menambah barang baru
if (isset($_POST["addnewbarang"])) {
    $nama_barang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn, "INSERT INTO stock (namabarang, deskripsi, stock) VALUES ('$nama_barang', '$deskripsi', '$stock')");
    if ($addtotable) {
        header('Location: index.php');
        exit(); // Menghentikan eksekusi setelah header redirect
    } else {
        echo 'Gagal';
        header('Location: index.php');
        exit(); // Menghentikan eksekusi setelah header redirect
    }
}


// Menambah barang masuk
if (isset($_POST['barang_masuk'])) { 
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
    $stocksekarang = $ambildatanya['stock'];

    $tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;

    $addtomasuk = mysqli_query($conn, "INSERT INTO masuk (idbarang, keterangan, qty) VALUES ('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'");

    if ($addtomasuk && $updatestockmasuk) {
        header("location: masuk.php");
    } else {
        echo 'Gagal';
        header("location: masuk.php");
    }
}

// Menambah barang keluar
if (isset($_POST['addbarangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
    $stocksekarang = $ambildatanya['stock'];

    $tambahkanstocksekarangdenganquantity = $stocksekarang - $qty;

    $addtokeluar = mysqli_query($conn, "INSERT INTO keluar (idbarang, penerima, qty) VALUES ('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'");

    if ($addtokeluar && $updatestockmasuk) {
        header("location: keluar.php");
    } else {
        echo 'Gagal';
        header("location: keluar.php");
    }
}

// Update info barang dari stock
if(isset($_POST['update_barang'])){
    $id_barang = $_POST['idbarang'];
    $nama_barang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($conn, "UPDATE stock SET namabarang='$nama_barang', deskripsi='$deskripsi' WHERE idbarang='$id_barang'");

    if($update){
        header("location: index.php");
    } else {
        echo "Gagal";
        header('location: index.php');
    }
}

// Menghapus barang dari stock
if(isset($_POST['hapus_barang'])) {
    $id_barang = $_POST['idbarang'];
    $hapus = mysqli_query($conn, "DELETE FROM stock WHERE idbarang='$id_barang'");

    if($hapus) {
        header('location: index.php');
    } else {
        echo 'Gagal';
        header('location: index.php');
    }
}

// Update info barang masuk
if(isset($_POST['update_barang_masuk'])) {
    $id_barang = $_POST['idbarang'];
    $id_masuk = $_POST['idmasuk'];
    $nama_barang = $_POST['namabarang'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST["qty"];

    $lihat_stock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$id_barang'");
    $stocknya = mysqli_fetch_array($lihat_stock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$id_masuk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qty_skrg = $qtynya['qty'];

    if($qty > $qty_skrg) {
        $kurang = $qty - $qty_skrg;
        $tambah = $stockskrg + $kurang;

        $tambah_stocknya = mysqli_query($conn, "UPDATE stock SET stock='$tambah' WHERE idbarang='$id_barang'");
        $update_qty = mysqli_query($conn, "UPDATE masuk SET qty='$qty' WHERE idmasuk='$id_masuk'");

        if($tambah_stocknya && $update_qty) {
            header('Location: masuk.php');
            exit;
        } else {
            echo 'Gagal melakukan pembaruan';
        }
    } else {
        echo 'Qty baru harus lebih besar dari Qty sebelumnya';
    }
}

//Menghapus barang masuk
if(isset($_POST["hapus_barang_masuk"])) {
    $id_barang = $_POST['idbarang'];
    $id_masuk = $_POST['idmasuk'];

    $qtyskrg = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$id_masuk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qty = $qtynya['qty'];
    
    $getdata_stock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$id_barang'");
    $data = mysqli_fetch_array($getdata_stock);
    $stock = $data['stock'];

    $selisih = $stock - $qty;

    $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$id_barang'");
    $hapus_data = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk='$id_masuk'");

    if($update && $hapus_data) {
        header('Location: masuk.php');
        exit;
    } else {
        echo 'Gagal menghapus data masuk atau mengupdate stok';
        
    }
}

// Update info barang keluar
if(isset($_POST['update_barang_keluar'])) {
    $id_barang = $_POST['idbarang'];
    $id_keluar = $_POST['idkeluar'];
    $nama_barang = $_POST['namabarang'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST["qty"];

    $lihat_stock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$id_barang'");
    $stocknya = mysqli_fetch_array($lihat_stock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar='$id_keluar'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qty_skrg = $qtynya['qty'];

    if($qty < $qty_skrg) {
        $kurang = $qty_skrg - $qty;
        $tambah = $stockskrg + $kurang;

        $tambah_stocknya = mysqli_query($conn, "UPDATE stock SET stock='$tambah' WHERE idbarang='$id_barang'");
        $update_qty = mysqli_query($conn, "UPDATE keluar SET qty='$qty' WHERE idkeluar='$id_keluar'");

        if($tambah_stocknya && $update_qty) {
            header('Location: keluar.php');
            exit;
        } else {
            echo 'Gagal melakukan pembaruan';
        }
    } else {
        echo 'Qty baru harus lebih kecil dari Qty sebelumnya';
    }
}

//Menghapus barang keluar
if(isset($_POST["hapus_barang_keluar"])) {
    $id_barang = $_POST['idbarang'];
    $id_keluar = $_POST['idkeluar'];

    $qtyskrg = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar='$id_keluar'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qty = $qtynya['qty'];
    
    $getdata_stock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$id_barang'");
    $data = mysqli_fetch_array($getdata_stock);
    $stock = $data['stock'];

    $jumlah = $stock + $qty;

    $update = mysqli_query($conn, "UPDATE stock SET stock='$jumlah' WHERE idbarang='$id_barang'");
    $hapus_data = mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar='$id_keluar'");

    if($update && $hapus_data) {
        header('Location: keluar.php');
        exit;
    } else {
        echo 'Gagal menghapus data masuk atau mengupdate stok';
        
    }
}





?>
