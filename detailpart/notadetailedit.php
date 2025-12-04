<?php
include '../koneksi.php';

// Ambil No_Penjualan dari parameter GET
$noservice = $_GET['noservice'];

// Ambil data nota penjualan berdasarkan No_Penjualan
$queryNota = "SELECT * FROM service WHERE noservice = '$noservice'";
$resultNota = mysqli_query($conn, $queryNota);
$dataNota = mysqli_fetch_assoc($resultNota);

$idproduk = $_GET['idproduk'];
$queryDetail = "SELECT dp.*, p.namaproduk, p.harga
                FROM detail dp
                JOIN produk p ON dp.idproduk = p.idproduk
                WHERE dp.noservice = '$noservice' AND dp.idproduk = '$idproduk'";
$resultDetail = mysqli_query($conn, $queryDetail);
$dataDetail = mysqli_fetch_assoc($resultDetail);

// Proses saat tombol Ubah di-submit
if (isset($_POST['proses'])) {
    $qty = $_POST['qty'];
    $jumlah = $dataDetail['harga'] * $qty;

    // Lakukan update ke database untuk detail_part
    $queryUpdate = "UPDATE detail
                    SET qty = '$qty', jumlah = '$jumlah'
                    WHERE noservice = '$noservice' AND idproduk = '$idproduk'";
    $resultUpdate = mysqli_query($conn, $queryUpdate);

    if ($resultUpdate) {
        // Mengupdate nilai total pada nota_penjualan setelah detail_part diupdate
        $queryUpdateTotal = "UPDATE service
                             SET totalrp = (SELECT SUM(jumlah) FROM detail WHERE noservice = '$noservice')
                             WHERE noservice = '$noservice'";
        $resultUpdateTotal = mysqli_query($conn, $queryUpdateTotal);

        if ($resultUpdateTotal) {
            // Redirect ke halaman notadetail.php setelah proses berhasil
            header("Location: notadetail.php?noservice=$noservice");
            exit;
        } else {
            echo "Error updating Total: " . mysqli_error($conn);
        }
    } else {
        echo "Error updating detail_part: " . mysqli_error($conn);
    }
}
?>
<?php
    include '../koneksi.php';
    $query = mysqli_query($conn, "SELECT S.*, C.*, K.namakasir
    FROM service S
    INNER JOIN kendaraan C ON S.nopolisi = C.nopolisi
    INNER JOIN kasir K ON S.idkasir = K.idkasir
    WHERE S.noservice = '$_GET[noservice]'");
    $data = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Detail Nota</title>
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
            margin-top: 2%;
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

        table.bordered th, table.bordered td {
            border: 1px solid #ccc;
        }
        table.bordered {
            margin-bottom: 30px; /* Menambahkan margin atas untuk tabel pertama */
        }

        input[type="text"], select, input[type="date"], input[type="number"] {
            padding: 10px;
            width: 450px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            float: right;
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
    <div>
        <form action="" method="post">
        <table class="bordered">
    <a class="kembali" href="notadetail.php?noservice=<?php echo htmlspecialchars($data['noservice']); ?>"><i class="fa-solid fa-arrow-left"></i></a>
    <h4>DETAIL NOTA : <?php echo htmlspecialchars($data['noservice']); ?></h4>
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
        <td> <?php echo $data['idkasir'];?> </td>
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
        <td> <?php echo $data['totalrp'];?> </td>
    </tr>
    <tr>
        <td>Total Bayar</td>
        <td> <?php echo $data['totalbayar'];?> </td>
    </tr>
    <tr>
        <td>Return</td>
        <td> <?php echo $data['kembalirp'];?> </td>
    </tr>
</table>
            <table>
            <h4>FORM DETAIL NOTA : <?php echo htmlspecialchars($data['noservice']); ?></h4>
                <tr>
                    <td>No Service</td>
                    <td><input type="text" name="noservice" value="<?php echo htmlspecialchars($dataNota['noservice']); ?>" readonly></td>
                </tr>
                <tr>
                    <td>ID Produk</td>
                    <td><input type="text" name="idproduk" value="<?php echo htmlspecialchars($dataDetail['idproduk'] . ' - ' . $dataDetail['idproduk'] . ' - ' . $dataDetail['harga']); ?>" readonly></td>
                </tr>
                <tr>
                    <td>Nama Produk</td>
                    <td><input type="text" name="namaproduk" value="<?php echo htmlspecialchars($dataDetail['namaproduk']); ?>" readonly></td>
                </tr>
                <tr>
                    <td>Qty</td>
                    <td><input type="number" name="qty" value="<?php echo htmlspecialchars($dataDetail['qty']); ?>"></td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td><input type="number" name="harga" value="<?php echo htmlspecialchars($dataDetail['harga']); ?>" readonly></td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td><input type="number" name="jumlah" value="<?php echo htmlspecialchars($dataDetail['jumlah']); ?>" readonly></td>
                </tr>
                <tr>
                    <td><input type="submit" name="proses" value="Ubah"></td>
                </tr>
            </table>
        </form>
    </div>

    <script>
        // Dapatkan elemen yang diperlukan menggunakan JavaScript
        var inputqty = document.querySelector("input[name='qty']");
        var inputjumlah = document.querySelector("input[name='jumlah']");

        // Fungsi untuk menghitung jumlah berdasarkan perubahan Qty
        function hitungJumlah() {
            var harga = <?php echo $dataDetail['harga']; ?>;
            var qty = inputqty.value;
            var jumlah = harga * qty;
            inputjumlah.value = jumlah;
        }

        // Panggil fungsi hitungJumlah saat nilai input berubah
        inputqty.addEventListener("input", hitungJumlah);
    </script>
</body>
</html>