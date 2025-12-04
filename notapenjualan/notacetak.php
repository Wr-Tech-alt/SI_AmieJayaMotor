<?php
include '../koneksi.php';

$noservice = $_GET['noservice'];

// Ambil data nota service
$queryNota = mysqli_query($conn, "SELECT * FROM service WHERE noservice = '$noservice'");
$dataNota = mysqli_fetch_assoc($queryNota);

$nopolisi = $dataNota['nopolisi'];

// *** FIX 1: Ambil 'nama' dari tabel customer ***
$queryCustomer = mysqli_query($conn, "SELECT cust.nama FROM kendaraan
JOIN customer cust ON kendaraan.idcust = cust.idcust
WHERE kendaraan.nopolisi = '$nopolisi'");
$dataCustomer = mysqli_fetch_assoc($queryCustomer);

// *** FIX 2: Ambil semua data detail part ke dalam array sekaligus untuk display dan total ***
$detailParts = [];
$totalrp = 0;
$queryDetailParts = mysqli_query($conn, "
    SELECT DP.idproduk, P.namaproduk, DP.qty, P.harga, DP.jumlah
    FROM detail DP
    JOIN produk P ON DP.idproduk = P.idproduk
    WHERE DP.noservice = '$noservice'
");

while ($data = mysqli_fetch_assoc($queryDetailParts)) {
    $detailParts[] = $data; // Simpan setiap baris detail ke dalam array
    $totalrp += $data['jumlah']; // Hitung total
}

// Update total harga di tabel 'service'
// Ini akan selalu mengupdate total setiap kali halaman ini diakses,
// pastikan ini adalah perilaku yang diinginkan.
$queryUpdateTotal = "UPDATE service SET totalrp = '$totalrp' WHERE noservice = '$noservice'";
mysqli_query($conn, $queryUpdateTotal);

// Query untuk mengambil nama kasir
$queryKasir = mysqli_query($conn, "SELECT namakasir FROM kasir WHERE idkasir = '{$dataNota['idkasir']}'");
$dataKasir = mysqli_fetch_assoc($queryKasir);

// Variabel untuk pengirim kargo tidak didefinisikan dalam kode Anda.
// Jika ada data untuk ini, Anda perlu menambahkan query di sini, contoh:
// $dataPengirimKargo = ['namakasir' => 'Nama Pengirim Kargo']; // Contoh hardcode jika ada data
// Jika tidak ada data, maka akan tetap kosong.
$dataPengirimKargo = null; // Inisialisasi sebagai null jika tidak ada query untuknya
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bengkel Motor Amie Jaya</title>
    <style>
        body {
            font-family: Poppins, Arial, sans-serif;
            background-color: white;
            margin: 10px;
            padding: 0;
        }
        .container {
            width: 20cm;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header .title {
            text-align: center;
            flex: 1;
        }
        .header .title h1 {
            margin: 0;
            font-size: 15px;
        }
        .header .logo img {
            width: 120px;
        }
        .company-info {
            display: flex;
            flex-direction: column;
            font-size: 15px;
        }
        .company-info .pt {
            margin-bottom: 0;
        }
        .cabang {
            font-size: 5px;
        }
        .cabang p {
            margin: 0;
        }
        .judul {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }
        .table-container {
            margin-top: 20px;
            position: relative;
        }
        .no-penjualan {
            position: absolute;
            right: 5px;
            top: -50px;
            font-size: 20px;
        }
        .info-bar {
            display: flex;
            margin-bottom: 0;
            font-size: 14px; /* Menambah ukuran font agar lebih mudah dibaca */
        }
        .info-bar div {
            flex: 1;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .info-bar .nama {
            flex: 0 0 auto;
            text-align: left;
        }
        .info-bar div p {
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        .totals {
            text-align: right;
            margin-top: 20px;
        }
        .signatures {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        .signatures div {
            text-align: center;
        }
        .buttons {
            margin-top: 20px;
            text-align: center;
        }
        .buttons button {
            padding: 10px 20px;
            margin-right: 10px;
            font-size: 14px;
            cursor: pointer;
        }
        @media print {
            .buttons {
                display: none; /* Menyembunyikan tombol saat mencetak */
            }
        }
    </style>
        <script>
        // JavaScript untuk mengontrol tampilan tombol saat mencetak
        window.onload = function() {
            window.onbeforeprint = function() {
                document.querySelector('.buttons').style.display = 'none';
            }
            window.onafterprint = function() {
                document.querySelector('.buttons').style.display = 'block';
            }
        };
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="company-info">
                <p class="pt"><strong>Bengkel Motor Amie Jaya</strong></p>
                <div class="cabang">
                    <p>Jl. Danau Sunter Selatan Blok 0/III No.51-52 Jakarta Utara. Telp: 021 12345678 Fax: (021) 12345678</p>
                    <p>Jl. Daan Mogot No.116 A Jakarta Barat. Telp: 021 12345678 Fax: (021) 12345678</p>
                    <p>Jl. Kramat Raya No.24 Kebayoran Lama, Jakarta Selatan. Telp: 021 12345678 Fax: (021) 12345678</p>
                    <p>Jl. Raya Parung No.144 Parung Bogor. Telp: 021 12345678 Fax: (021) 12345678</p>
                    <p>Jl. KH. Hasyim Ashari No.5 Cipondoh-Tangerang. Telp: 021 12345678 Fax: (021) 12345678</p>
                    <p>Jl. Raya Pasar Kemis Ruko Buana Subur Blok A No.1-2 Duta Jaya, Tangerang. Telp: 021 12345678 Fax: (021) 12345678</p>
                    <p>Jl. Jatiwaringin No.98 Rt.03 Rw.02 Pondok Gede, Bekasi. Telp: 021 12345678 Fax: (021) 12345678</p>
                    <p>Jl. Swatantra IV No.63 Rt.04 Rw.04 Jatiasih Bekasi. Telp: 021 12345678 Fax: (021) 12345678</p>
                    <p>Jl. Kolonel Sugiyono No.20 Duren Sawit Jakarta Timur. Telp: 021 12345678 Fax: (021) 12345678</p>
                    <p>Jl. Raya Cileutik No.2 cisauk-Tangerang. Telp: 021 12345678 Fax: (021) 12345678</p>
                </div>
            </div>
            <div class="title">
                <h1>NOTA SERVICE MOTOR</h1>
            </div>
            <div class="logo">
                <img src="../pict/ami.png" alt="Logo Perusahaan">
            </div>
        </div>
        
        <div class="table-container">
            <div class="no-penjualan">
                <p><strong>NO. <?php echo htmlspecialchars($dataNota['noservice']); ?></strong></p>
            </div>
            <div class="info-bar">
                <div class="nama"><p>Nama: <?php echo htmlspecialchars($dataCustomer['nama'] ?? ''); ?></p></div>
                <div class="nopol"><p>No. Polisi: <?php echo htmlspecialchars($dataNota['nopolisi']); ?></p></div>
                <div class="nowo"><p>No. W0: <?php echo htmlspecialchars($dataNota['noworkorder']); ?></p></div>
            </div>
            <table>
                <tr>
                    <th><center>No</center></th>
                    <th><center>ID Produk</center></th>
                    <th><center>Nama produk</center></th>
                    <th><center>Qty</center></th>
                    <th><center>Harga</center></th>
                    <th><center>Jumlah</center></th>
                </tr>
                <?php
                $index = 1;
                // *** FIX 2: Loop melalui array $detailParts yang sudah diisi ***
                foreach ($detailParts as $data) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars ($index++); ?></td>
                    <td><?php echo htmlspecialchars($data['idproduk']); ?></td>
                    <td><?php echo htmlspecialchars($data['namaproduk']); ?></td>
                    <td><?php echo htmlspecialchars($data['qty']); ?></td>
                    <td><?php echo htmlspecialchars(number_format($data['harga'], 0, ',', '.')); ?></td>
                    <td><?php echo htmlspecialchars(number_format($data['jumlah'], 0, ',', '.')); ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="5" align="right"> <strong> TOTAL </strong> </td>
                    <td> <?php echo htmlspecialchars(number_format($totalrp, 0, ',', '.')); ?></td>
                </tr>
            </table>
            <div class="tanggal"><p>Tanggal: <?php echo htmlspecialchars($dataNota['tanggalservice']); ?></p></div>
            <table style="margin-top: 20px;">
                <tr>
                    <th><center>Dibuat Oleh</center></th>
                    <th><center>Diserahkan Oleh</center></th>
                    <th><center>Diterima Oleh</center></th>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($dataKasir['namakasir'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($dataKasir['namakasir'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($dataCustomer['nama'] ?? ''); ?></td> </tr>
            </table>
        </div>
    </div>
            <div class="buttons">
                <button onclick="window.print()">Print</button>
                <button onclick="window.history.back()">Kembali</button>
            </div>
</body>
</html>