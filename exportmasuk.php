<?php
require 'function.php';
require 'cek.php';//untuk login 
?>
<html>
<head>
  <title>Laporan Barang Masuk</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
<div class="container">
  <h2 style="text-align: center;">Laporan Barang Masuk</h2>
  <img src="logofis.jpg" alt="Logofis" style="height: 80px; margin-right: 10px; margin-left: 15px;">
  <h4>PT. Fan Indonesia Sejahtera</h4>
  <div class="data-tables datatable-dark">
    <table id="mauexport" class="table table-bordered" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Nama Barang</th>
          <th>jumlah</th>
          <th>keterangan</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $ambilsemuadatastok = mysqli_query($conn,"SELECT * FROM masuk m, stok s WHERE s.idbarang = m.idbarang");
        $i=1;
        while($data=mysqli_fetch_array($ambilsemuadatastok)){
            $tanggal=$data['tanggal'];
            $namabarang = $data['namabarang'];
            $qty = $data['qty'];
            $keterangan = $data['keterangan'];
        ?>
        <tr>
        <td><?php echo $tanggal;?></td>
          <td><?php echo $namabarang;?></td>
          <td><?php echo $qty;?></td>
          <td><?php echo $keterangan;?></td>
        </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#mauexport').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
    });
});
</script>

<!-- Include additional JS libraries for buttons -->
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

</body>
</html>