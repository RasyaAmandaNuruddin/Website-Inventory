<?php 
session_start();
$conn=mysqli_connect("localhost","root","","stokbarang");

//menambah barang baru
if(isset($_POST['tambahdatabarang'])){
    $idbarang=$_POST['idbarang'];
    $namabarang=$_POST['namabarang'];
    $deskripsi=$_POST['deskripsi'];
    $satuan=$_POST['satuan'];
    $stok=$_POST['stok'];

     if (empty($satuan)) {
        $_SESSION['error'] = "Satuan harus dipilih!";
        header('location:index.php');
        exit();
    }

    $addtotable = mysqli_query($conn,"insert into stok(idbarang,namabarang,deskripsi,satuan,stok) values('$idbarang','$namabarang','$deskripsi','$satuan','$stok')");
    if($addtotable){
        $_SESSION['msg'] = ['type' => 'success', 'text' => 'Barang berhasil ditambahkan!'];
        header('location:index.php');
        exit();
    }else{
        $_SESSION['msg'] = ['type' => 'success', 'text' => 'Barang gagal ditambahkan!'];
        header('location:index.php');
        exit();
    }
};

//barang masuk
if(isset($_POST['barangmasuk'])){
    //$barangnya = $_POST['barangnya'];
    //$idbarang=$_POST['idbarang'];
    $idbarang=$_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty=$_POST['qty'];
/*
    $cekstocksekarang = mysqli_query($conn,"select*from stok where idbarang ='$idbarang'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stok'];
    $tambahkanstoksekarangdenganquantity= $stocksekarang+$qty;
*/
if (empty($idbarang)) {
        $_SESSION['error'] = "Nama Barang harus dipilih!";
        header('location:masuk.php');
        exit();
    }
    $addtomasuk = mysqli_query($conn,"insert into masuk(idbarang,keterangan,qty) values('$idbarang','$penerima','$qty')");
    //$updatestockmasuk= mysqli_query($conn,"update stok set stok='$tambahkanstoksekarangdenganquantity' where idbarang='$idbarang'");
    if($addtomasuk){
        $_SESSION['msg'] = ['type' => 'success', 'text' => 'Barang berhasil ditambahkan!'];
        header('location:masuk.php');
        exit;
    }else{
        $_SESSION['msg'] = ['type' => 'danger', 'text' => 'Gagal menambahkan barang.'];
        header('location:masuk.php');
        exit;
    }
}

//barangkeluar 
if(isset($_POST['addbarangkeluar'])){
    //$barangnya = $_POST['barangnya'];
    //$idbarang=$_POST['idbarang'];
    $idkeluar=$_POST['idkeluar'];
    $idbarang=$_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty=$_POST['qty'];

    if (empty($idbarang)) {
        $_SESSION['error'] = "Nama Barang harus dipilih!";
        header('location:keluar.php');
        exit();
    }
    /*
    $cekstocksekarang = mysqli_query($conn,"select*from stok where idbarang ='$idbarang'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stok'];
    if($stoksekarang >= $qty){
        //klo barang nya cukup
    
    $kurangkanstoksekarangdenganquantity= $stocksekarang-$qty;
*/
$stk=mysqli_fetch_array(mysqli_query($conn, "select stok from stok where idbarang='$idbarang'  "));   
$brngmsk=mysqli_fetch_array(mysqli_query($conn, "select sum(qty) as msk from masuk where idbarang='$idbarang'  "));   
$brngklr=mysqli_fetch_array(mysqli_query($conn, "select sum(qty) as klr from keluar where idbarang='$idbarang'  "));   
$ttk=$stk['stok']+$brngmsk['msk'];
$tkl=$brngklr['klr']+$qty;

if($tkl > $ttk){
    echo "<script>
    alert('Barang Keluar Melebihi dari Sisa Stok!');
    window.location.href = 'keluar.php';
  </script>";
  exit();
}

    $addtokeluar= mysqli_query($conn,"insert into keluar(idkeluar,idbarang,penerima,qty) values('$idkeluar','$idbarang','$penerima','$qty')");
    //$updatestockkeluar= mysqli_query($conn,"update stok set stok='$kurangkanstoksekarangdenganquantity' where idbarang='$idbarang'");
        if($addtokeluar){
            $_SESSION['msg'] = ['type' => 'success', 'text' => 'Barang berhasil dikeluarkan !'];
            header('location:keluar.php');
            exit;
        }else{
            $_SESSION['msg'] = ['type' => 'danger', 'text' => 'Gagal mengeluarkan barang.'];
            header('location:keluar.php');
            exit;
        }
/*
    }else{
        //kalau barang tidak cukup 
        echo'
        <script>
         alert ("stok saat ini tidak mencukupi");
         window.location.href="keluar.php";
        </script> 
        ';
    } */
}

//update info barang 
if(isset($_POST['updatebarang'])){
    $id=$_POST['id'];
    $namabarang=$_POST['namabarang'];
    $deskripsi=$_POST['deskripsi'];

    $update = mysqli_query($conn, "update stok set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang ='$id'");
    if($update){
        $_SESSION['success'] = "Data barang berhasil diperbarui.";
        header('location:index.php');
        exit();
    }
}

//hapus barang 
if(isset($_POST['hapusbarang'])){
    $id=$_POST['id'];

    $hapus=mysqli_query($conn,"delete from stok where idbarang='$id'");
    if($hapus){
        $_SESSION['success'] = "Data barang berhasil dihapus.";
        header('location:index.php');
        exit();
    }
}

//mengubah data barang masuk 
if(isset($_POST['updatebarangmasuk'])){
    $id=$_POST['id'];
    $idm=$_POST['idm'];
    $deskripsi=$_POST['keterangan'];
    $qty=$_POST['qty'];

    if ($qty == 0) {
        $_SESSION['error'] = "Jumlah barang masuk tidak boleh 0!";
        header('location:masuk.php');
        exit();
    }

    /*
    $lihatstok =mysqli_query($conn,"select * from stok where idbarang='$id'");
    $stoknya =mysqli_fetch_array($lihatstok);
    $stocksekarang=$stoknya['stok'];

    $qtysekarang =mysqli_query($conn,"select * from masuk where idmasuk='$idm'");
    $qtynya =mysqli_fetch_array($qtysekarang);
    $qtysekarang =$qtynya['qty'];

    if($qty > $qtysekarang){//qty = yang di inputkan 
        $selisih = $qty - $qtysekarang;
        $kurangin = $stoksekarang - $selisih;
        $kurangistoknya = mysqli_query($conn, "update stok set stok='$kurangin' where idbarang='$id'");

        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
        
        if($kurangistoknya&&$updatenya){
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
        
    } else {
        $selisih = $qtysekarang - $qty;
        $kurangin = $stoksekarang + $selisih;
        $kurangistoknya = mysqli_query($conn, "update stok set stok='$kurangin' where idbarang='$id'");
*/
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
        
        if ($updatenya) {
            $_SESSION['success'] = "Data barang berhasil diperbarui.";
            header('location:masuk.php');
            exit(); 
        } else {
            $_SESSION['success'] = "Data barang gagal diperbarui.";
            header('location:masuk.php');
            exit(); 
}
    //}
}

// Menghapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $id = $_POST['id'];
    $qty = $_POST['qty'];
    $idm = $_POST['idm'];

    $getdatastok = mysqli_query($conn, "select * from stok where idbarang='$id'");
    $data = mysqli_fetch_array($getdatastok);
    $stok = $data['stok'];

    $selisih = $stok+$brngmsk['msk'] - $qty;

    $update = mysqli_query($conn, "update stok set stok='$selisih' where idbarang='$id'");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

    if($update && $hapusdata){
        $_SESSION['success'] = "Data barang berhasil dihapus.";
        header('location:masuk.php');
        exit();
    } else {
        $_SESSION['error'] = "Data barang gagal dihapus.";
        header('location:masuk.php');
        exit();
    }
}

//mengubah data barang keluar 
if(isset($_POST['updatebarangkeluar'])){
    $id=$_POST['id'];
    $idk=$_POST['idk'];
    $penerima=$_POST['penerima'];
    $qty=$_POST['qty'];

    if ($qty == 0) {
        $_SESSION['error'] = "Jumlah barang keluar tidak boleh 0!";
        header('location:keluar.php');
        exit();
    }
/*
    $lihatstok =mysqli_query($conn,"select * from stok where idbarang='$id'");
    $stoknya =mysqli_fetch_array($lihatstok);
    $stocksekarang=$stoknya['stok'];

    $qtysekarang =mysqli_query($conn,"select * from keluar where idkeluar='$idk'");
    $qtynya =mysqli_fetch_array($qtysekarang);
    $qtysekarang =$qtynya['qty'];

    if($qty > $qtysekarang){
        $selisih = $qty - $qtysekarang;
        $kurangin = $stoksekarang - $selisih;
        $kurangistoknya = mysqli_query($conn, "update stok set stok='$kurangin' where idbarang='$id'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
        
        if($kurangistoknya && $updatenya){
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
        
    } else {
        $selisih = $qtysekarang - $qty;
        $kurangin = $stoksekarang + $selisih;
        $kurangistoknya = mysqli_query($conn, "update stok set stok='$kurangin' where idbarang='$id'");
*/
$stk=mysqli_fetch_array(mysqli_query($conn, "select stok from stok where idbarang='$id'  "));   
$brngmsk=mysqli_fetch_array(mysqli_query($conn, "select sum(qty) as msk from masuk where idbarang='$id'  "));   
$brngklr=mysqli_fetch_array(mysqli_query($conn, "select sum(qty) as klr from keluar where idbarang='$id' and idkeluar != '$idk'  "));   
$ttk=$stk['stok']+$brngmsk['msk'];
$tkl=$brngklr['klr']+$qty;

if($tkl > $ttk){
    echo "<script>
    alert('Barang Keluar Melebihi dari Sisa Stok!');
    window.location.href = 'keluar.php';
  </script>";
  exit();
}

        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
        
        if($updatenya){
            $_SESSION['success'] = "Data barang berhasil diperbarui.";
            header('location:keluar.php');
            exit();
        } else {
            $_SESSION['success'] = "Data barang gagal diperbarui.";
            header('location:keluar.php');
            exit();
        }
    //}
}

// Menghapus barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $id = $_POST['id'];
    $qty = $_POST['qty'];
    $idk = $_POST['idk'];

    $getdatastok = mysqli_query($conn, "select * from stok where idbarang='$id'");
    $data = mysqli_fetch_array($getdatastok);
    $stok = $data['stok'];

    $selisih = $stok - $brngklr['klr']+$qty;

    $update = mysqli_query($conn, "update stok set stok='$selisih' where idbarang='$id'");
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");

    if($update && $hapusdata){
        $_SESSION['success'] = "Data barang berhasil dihapus.";
        header('location:keluar.php');
        exit();
    } else {
        $_SESSION['success'] = "Data barang gagal dihapus.";
        header('location:keluar.php');
        exit();
    }
}
?>