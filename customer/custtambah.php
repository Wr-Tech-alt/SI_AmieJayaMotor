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
    <a class="kembali" href="custlihat.php"><i class="fa-solid fa-arrow-left"></i></a>
    <h4>Tambah Customer</h4>
    <tr>
        <td>ID Customer</td>
        <td> <input type="text" name="idcust" placeholder="Masukkan ID Customer"> </td>
    </tr>
    <tr>
        <td>Nama Customer</td>
        <td> <input type="text" name="nama" placeholder="Masukkan Nama Customer"> </td>
    </tr>
    <tr>
        <td><input type="submit" name="proses" value="Simpan Data"> </td>
    </tr>
</table>
</form>
</html>

<?php
if (isset($_POST['proses'])){
    include '../koneksi.php';
    $idcust = $_POST['idcust'];
    $nama = $_POST['nama'];

    mysqli_query($conn, "INSERT INTO customer VALUES('$idcust','$nama')");
    header("location:custlihat.php");
    exit();
}
?>