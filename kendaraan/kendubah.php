<?php
    include '../koneksi.php';
    $query = mysqli_query($conn, "Select * from kendaraan where nopolisi = '$_GET[nopolisi]'");
    $data = mysqli_fetch_array($query);
?>
  
<html>
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
        margin-top: 10%;
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
<form action="" method="post">
<table>
    <a class="kembali" href="kendlihat.php"><i class="fa-solid fa-arrow-left"></i></a>
    <h4>Edit Kendaraan</h4>
    <tr>
        <td>No Polisi</td>
        <td> <input type="text" name="nopolisi" value="<?php echo $data['nopolisi'];?>" readonly> </td>
    </tr>
    <tr>
        <td>No Mesin</td>
        <td> <input type="text" name="nomesin" value="<?php echo $data['nomesin'];?>"> </td>
    </tr>
    <tr>
        <td>Tipe</td>
        <td> <input type="text" name="tipe" value="<?php echo $data['tipe'];?>"> </td>
    </tr>
    <tr>
        <td>Kilometer</td>
        <td> <input type="text" name="km" value="<?php echo $data['km'];?>"> </td>
    </tr>
    <tr>
        <tr><td> 
        Customer
        <td><select name="idcust" style="width:170px;">
        <?php
        include '../koneksi.php';
        $ambilpelanggan=mysqli_query($conn, "SELECT * FROM customer");
        while ($pelanggan = mysqli_fetch_array($ambilpelanggan)) {
            $selected = ($data['idcust'] == $pelanggan['idcust']) ? 'selected' : '';
            echo "<option value='$pelanggan[idcust]' $selected>$pelanggan[nama]</option>";
        }
        ?></td>
        </select>
        </td></tr>
        <tr>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" name="proses" value="Ubah"></td>
    </tr>
</form>
</table>
</html>

<?php
if (isset($_POST['proses'])){
    include '../koneksi.php';
    $nopolisi = $_POST['nopolisi'];
    $nomesin = $_POST['nomesin'];
    $tipe = $_POST['tipe'];
    $km = $_POST['km'];
    $idcust = $_POST['idcust'];

    mysqli_query($conn, "update kendaraan set nomesin='$nomesin', tipe='$tipe', km='$km', idcust='$idcust' WHERE nopolisi='$nopolisi'");
    header("location:kendlihat.php");
    exit();
}
?>