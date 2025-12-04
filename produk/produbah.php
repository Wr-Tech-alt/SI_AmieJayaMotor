<?php
    include '../koneksi.php';
    $query = mysqli_query($conn, "Select * from produk where idproduk = '$_GET[idproduk]'");
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
    <a class="kembali" href="prodlihat.php"><i class="fa-solid fa-arrow-left"></i></a>
    <h4>Edit Produk</h4>
    <tr>
        <td>ID Produk</td>
        <td> <input type="text" name="idproduk" value="<?php echo $data['idproduk'];?>" readonly> </td>
    </tr>
    <tr>
        <td>Nama Produk</td>
        <td> <input type="text" name="namaproduk" value="<?php echo $data['namaproduk'];?>"> </td>
    </tr>
    <tr>
        <td>Harga</td>
        <td> <input type="text" name="harga" value="<?php echo $data['harga'];?>"> </td>
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
    $idproduk = $_POST['idproduk'];
    $namaproduk = $_POST['namaproduk'];
    $harga = $_POST['harga'];

    mysqli_query($conn, "update produk set namaproduk='$namaproduk', harga='$harga' WHERE idproduk='$idproduk'");
    header("location:prodlihat.php");
    exit();
}
?>