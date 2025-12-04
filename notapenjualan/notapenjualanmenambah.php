<?php
if (isset($_POST['proses'])){
    include '../koneksi.php';
    $noservice = $_POST['noservice'];
    $nopolisi = $_POST['nopolisi'];
    $idkasir = $_POST['idkasir'];
    $noworkorder = $_POST['noworkorder'];
    $noorderjob = $_POST['noorderjob'];
    $tanggalservice = $_POST['tanggalservice'];
    $totalrp = $_POST['totalrp'];
    $totalbayar = $_POST['totalbayar'];
    $kembalirp = $_POST['kembalirp'];
    
    mysqli_query($conn, "INSERT INTO service VALUES('$noservice','$nopolisi','$idkasir','$noworkorder','$noorderjob','$tanggalservice','$totalrp','$totalbayar','$kembalirp')");
    header("location:notapenjualanmelihat.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h4 {
            color: #333;
            text-align: center;
            margin-top: 10px;
            font-size: 25px;
            margin-bottom: 20px;
        }

        form {
            margin: 0 auto;
            width: 50%;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table td {
            padding: 10px;
        }

        table th {
            padding: 15px;
            background-color: #007BFF;
            color: #fff;
            border: 1px solid #ccc;
            text-align: left;
        }

        input[type="text"], select, input[type="date"] {
            padding: 10px;
            width: 450px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px 10px;
            background-color: #d6af00;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
            font-size: 16px;
            transition: background-color 0.3s ease;
            text-align: right;
        }

        input[type="submit"]:hover {
            background-color: #8b7c38;
        }

        .kembali {
            text-decoration: none;
            color: #a0a0a0;
            margin-top: 1px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .kembali:hover {
            color: #d6d6d6;
        }
    </style>
</head>
<body>
<form action="" method="post">
    <table>
        <a class="kembali" href="notapenjualanmelihat.php"><i class="fa-solid fa-arrow-left"></i></a> 
        <h4>Tambah Nota Penjualan</h4>
        <tr>
            <td>No Service</td>
            <td> <input type="text" name="noservice" placeholder="Masukkan No Service"> </td>
        </tr>
        <tr>
            <td>No Polisi<td><select name="nopolisi">
            <option value="">--Pilih--</option>
            <?php
            include '../koneksi.php';
            $query=mysqli_query($conn, "SELECT * FROM kendaraan");
           
            while ($data = mysqli_fetch_array($query)) {
            ?>
                
                <option value="<?php echo $data['nopolisi'];?>" >
                <?php echo $data['nopolisi'];?></option>
            <?php
            }
            ?></td>
            </select>
            </td>
        </tr>
        <tr>
            <td>Kasir<td><select name="idkasir">
            <option value="">--Pilih--</option>
            <?php
            include '../koneksi.php';
            $query=mysqli_query($conn, "SELECT * FROM kasir");
           
            while ($data = mysqli_fetch_array($query)) {
            ?>
                
                <option value="<?php echo $data['idkasir'];?>" >
                <?php echo $data['namakasir'];?></option>
            <?php
            }
            ?></td>
            </select>
            </td>
        </tr>
        <tr>
            <td>No WorkOrder</td>
            <td> <input type="text" name="noworkorder" placeholder="Masukkan No WorkOrder"> </td>
        </tr>
        <tr>
            <td>No OrderJob</td>
            <td> <input type="text" name="noorderjob" placeholder="Masukkan No OrderJob"> </td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td> <input type="date" name="tanggalservice"> </td>
        </tr>
        <tr>
            <td>Total </td>
            <td> <input type="number" name="totalrp" placeholder="RP."> </td>
        </tr>
        <tr>
            <td>Bayar</td>
            <td> <input type="number" name="totalbayar" placeholder="RP."> </td>
        </tr>
        <tr>
            <td>Return</td>
            <td> <input type="number" name="kembalirp" placeholder="RP."> </td>
        </tr>
        <tr>
            <td><input type="submit" name="proses" value="Simpan Data"> </td>
        </tr>
    </table>
</form>
</body>
</html>
