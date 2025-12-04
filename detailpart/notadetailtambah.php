<?php
include '../koneksi.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['proses'])) {
    $noservice = $_POST['noservice'];
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];
    $jumlah = $_POST['jumlah'];

    // Validasi input
    if (empty($noservice) || empty($idproduk) || empty($qty) || empty($jumlah)) {
        echo "<script>alert('Pastikan semua field terisi!'); window.history.back();</script>";
        exit;
    }

    // Ambil total sebelumnya
    $query_total = "SELECT totalrp FROM service WHERE noservice = '$noservice'";
    $result_total = mysqli_query($conn, $query_total);
    if (!$result_total) {
        die("Query error: " . mysqli_error($conn));
    }

    $row_total = mysqli_fetch_assoc($result_total);
    $total_sebelumnya = $row_total['totalrp'];

    // Insert ke detail
    $query_insert = "INSERT INTO detail (idproduk, noservice, qty, jumlah) VALUES('$idproduk','$noservice','$qty','$jumlah')";
    $result_insert = mysqli_query($conn, $query_insert);

    if ($result_insert) {
        // Update total di service
        $Total = $total_sebelumnya + $jumlah;
        $query_update_total = "UPDATE service SET totalrp = '$Total' WHERE noservice = '$noservice'";
        $result_update_total = mysqli_query($conn, $query_update_total);
        if (!$result_update_total) {
            die("Update total gagal: " . mysqli_error($conn));
        }

        header("Location: notadetail.php?noservice=$noservice");
        exit;
    } else {
        die("Insert gagal: " . mysqli_error($conn));
    }
}

// Ambil data untuk form
$query = mysqli_query($conn, "SELECT * FROM service WHERE noservice = '$_GET[noservice]'");
$data = mysqli_fetch_array($query);
?>

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
            margin-top: 6%;
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

<form action="" method="post">
    <table>
        <a class="kembali" href="notadetail.php?noservice=<?php echo htmlspecialchars($data['noservice']); ?>"><i class="fa-solid fa-arrow-left"></i></a>
        <h4>FORM DETAIL NOTA : <?php echo htmlspecialchars($data['noservice']); ?></h4>
        <tr>
            <td>No Service</td>
            <td><input type="text" name="noservice" value="<?php echo htmlspecialchars($data['noservice']); ?>" readonly></td>
        </tr>
        <tr>
            <td>Nama Produk</td>
            <td>
                <select name="idproduk" required>
                    <option value="">--Pilih--</option>
                    <?php
                    $query_parts = mysqli_query($conn, "SELECT * FROM produk");
                    while ($data_parts = mysqli_fetch_array($query_parts)) {
                        echo "<option value='" . htmlspecialchars($data_parts['idproduk']) . "' data-harga='" . htmlspecialchars($data_parts['harga']) . "'>" .
                            htmlspecialchars($data_parts['idproduk']) . " - " . htmlspecialchars($data_parts['namaproduk']) . " - " . htmlspecialchars($data_parts['harga']) .
                            "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Qty</td>
            <td><input type="number" name="qty" min="1" required></td>
        </tr>
        <tr>
            <td>Jumlah</td>
            <td><input type="number" name="jumlah" readonly></td>
        </tr>
        <tr>
            <td><input type="submit" name="proses" value="Simpan"></td>
        </tr>
    </table>
</form>

<script>
    const selectBarang = document.querySelector("select[name='idproduk']");
    const inputQty = document.querySelector("input[name='qty']");
    const inputJumlah = document.querySelector("input[name='jumlah']");

    function hitungTotal() {
        const harga = parseInt(selectBarang.options[selectBarang.selectedIndex]?.getAttribute("data-harga")) || 0;
        const qty = parseInt(inputQty.value) || 0;
        inputJumlah.value = harga * qty;
    }
    selectBarang.addEventListener("change", hitungTotal);
    inputQty.addEventListener("input", hitungTotal);
</script>
</body>
</html>
