<style>
    body {
        font-family: poppins, sans-serif;
        background-color: #f2f2f2;
    }
    
    h3 {
        color: #333;
        text-align: center;
        margin-top: 20px;
    } 
    
    form {
        margin: 20px auto;
        width: 80%;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    
    table td {
        padding: 10px;
        border: 1px solid #ccc;
    }
    
    table th {
        padding: 10px;
        background-color: #3e4246;
        color: #fff;
        border: 1px solid #ccc;
    }
    
    input[type="text"] {
        padding: 5px;
        width: 100%;
        box-sizing: border-box;
    }
    
    input[type="submit"] {
        padding: 8px 20px;
        background-color: #333;
        color: #fff;
        border: none;
        cursor: pointer;
    }
    
    input[type="submit"]:hover {
        background-color: #555;
    }
    
    .tambah{
        padding: 7.5px 10px;
        background-color: #6eb0f1;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        margin-right: 5px;
        font-weight: bold;
    }
    
    .tambah:hover{
        background-color: #4877a7;
    }

    .cetak{
        padding: 7.5px 10px;
        background-color: #e4ac20;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        margin-left: 5px;
        font-weight: bold;
    }
    
    .cetak:hover{
        background-color: #c4941a;
    }

    .hapus {
        padding: 5px 7px;
        background-color: rgb(224, 224, 224);
        color: rgb(226, 42, 42);
        text-decoration: none;
        border-radius: 3px;
        margin-left: 20px;
    }

    .hapus:hover{
        background-color: rgb(226, 42, 42);
        color: rgb(224, 224, 224);

    }

    .edit {
        padding: 5px 6px;
        background-color: rgb(224, 224, 224);
        color: #3e4246;
        text-decoration: none;
        border-radius: 3px;
    }

    .edit:hover{
        background-color: #3e4246;
        color: rgb(224, 224, 224);
    }

    .kembali {
        text-decoration: none;
        color: #a0a0a0;
        font-weight: bold;
        display: inline-block;
        font-size: 20px;
    }

    .kembali:hover {
        color: #d6d6d6;
    }
</style>

<?php
    include '../koneksi.php';
    $query = mysqli_query($conn, "SELECT S.*, K.*, P.namakasir
    FROM service S
    INNER JOIN kendaraan K ON S.nopolisi = K.nopolisi  
    INNER JOIN kasir P ON S.idkasir = P.idkasir  
    WHERE S.noservice = '$_GET[noservice]'");
    $data = mysqli_fetch_array($query);      
?>

<form action="" method="post">
<table>
    <a class="kembali" href="../notapenjualan/notapenjualanmelihat.php"><i class="fa-solid fa-arrow-left"></i></a>
    <h4>DETAIL NOTA : <?php echo $data['noservice'];?> </h4>
    <tr>
        <td>No Service</td>
        <td> <?php echo $data['noservice'];?></td>
    </tr>
    <tr>
        <td>No Polisi</td>
        <td> <?php echo $data['nopolisi'];?> </td>
    </tr>
    <tr>
        <td>Kasir</td>
        <td> <?php echo $data['namakasir'];?> </td>
    </tr>
    <tr>
        <td>No WorkOrder</td>
        <td> <?php echo $data['noworkorder'];?> </td>
    </tr>
    <tr>
        <td>No OrderJob</td>
        <td> <?php echo $data['noorderjob'];?> </td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td> <?php echo $data['tanggalservice'];?> </td>
    </tr>
    <tr>
        <td>Total</td>
        <td> <?php echo $data['totalbayar'];?> </td>
    </tr>
    <tr>
        <td>Total Bayar</td>
        <td> <?php echo $data['kembalirp'];?> </td>
    </tr>
    <tr>
        <td>Return</td>
        <td> <?php echo $data['kembalirp'];?> </td>
    </tr>
</form>
</table>

<html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<body>
<h4> TABEL DETAIL NOTA</h4>
<a class="tambah" href="notadetailtambah.php?noservice=<?php echo $data['noservice'];?>">Tambah</a> | <a class="cetak" href="../notapenjualan/notacetak.php?noservice=<?php echo $data['noservice']; ?>">Cetak</a>
<table width='100%' border=1>
<tr style="background-color: green; color: white;" >
    <th><center>No</center></th>
    <th><center>Nomor Service</center></th>
    <th><center>ID Produk</center></th>
    <th><center>Nama Produk</center></th>
    <th><center>Qty</center></th>
    <th><center>Harga</center></th>
    <th><center>Jumlah</center></th>
    <th><center>Aksi</center></th>  
</tr>   
<tr>        
    <?php
        include '../koneksi.php';   
        $index = 1;
        $noservice = $_GET['noservice'];
        $query = mysqli_query($conn, "SELECT B.idproduk, B.namaproduk, B.harga ,DP.noservice, DP.qty, DP.jumlah, S.noservice
        FROM service S
        JOIN detail DP ON S.noservice = DP.noservice
        JOIN produk B ON DP.idproduk = B.idproduk
        WHERE S.noservice = '$noservice'");
            
        $Total = 0; // Inisialisasi grand total
            while ($data = mysqli_fetch_array($query)) {
                $jumlah = $data['harga'] * $data['qty'];
                $totalrp += $jumlah;
                mysqli_query($conn, "UPDATE service SET totalrp = '$totalrp' WHERE noservice = '$noservice'");
    ?>  
            <tr>
                <td><?php echo htmlspecialchars ($index++); ?></td>
                <td><?php echo $data['noservice'] ;?></td>
                <td><?php echo $data['idproduk'] ;?></td>
                <td><?php echo $data['namaproduk'] ;?></td>
                <td><?php echo $data['qty'] ;?></td>
                <td><?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                <td><?php echo number_format($jumlah, 0, ',', '.'); ?></td>
                <td><a class="hapus" href="notadetailhapus.php?noservice=<?php echo htmlspecialchars($noservice); ?>&idproduk=<?php echo htmlspecialchars($data['idproduk']); ?>" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
                | <a class="edit" href="notadetailedit.php?noservice=<?php echo htmlspecialchars($noservice); ?>&idproduk=<?php echo htmlspecialchars($data['idproduk']); ?>"><i class="fas fa-pencil-alt"></i></a>
                </td>
            </tr>
            <?php }
            ?>
            <tr>
                <td colspan="6" align="center"><strong>TOTAL</strong></td>
                <td><strong><?php echo number_format($totalrp, 0, ',', '.'); ?></strong></td>
                <td></td>
            </tr>
</body>
</html>
