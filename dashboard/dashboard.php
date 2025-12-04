<?php
// Pastikan koneksi.php sudah tersedia dan berfungsi
include '../koneksi.php';

// --- Query untuk menghitung jumlah data realtime ---

// 1. Total Transaksi (dari tabel 'service')
$queryTransaksi = "SELECT COUNT(noservice) AS total_transaksi FROM service";
$resultTransaksi = mysqli_query($conn, $queryTransaksi);
$totalTransaksi = ($resultTransaksi && mysqli_num_rows($resultTransaksi) > 0) ? mysqli_fetch_assoc($resultTransaksi)['total_transaksi'] : 0;

// 2. Total Customer (dari tabel 'customer')
$queryCustomerCount = "SELECT COUNT(idcust) AS total_customer FROM customer";
$resultCustomerCount = mysqli_query($conn, $queryCustomerCount);
$totalCustomer = ($resultCustomerCount && mysqli_num_rows($resultCustomerCount) > 0) ? mysqli_fetch_assoc($resultCustomerCount)['total_customer'] : 0;

// 3. Total Kasir (dari tabel 'kasir')
$queryKasirCount = "SELECT COUNT(idkasir) AS total_kasir FROM kasir";
$resultKasirCount = mysqli_query($conn, $queryKasirCount);
$totalKasir = ($resultKasirCount && mysqli_num_rows($resultKasirCount) > 0) ? mysqli_fetch_assoc($resultKasirCount)['total_kasir'] : 0;

// 4. Total Kendaraan (dari tabel 'kendaraan')
$queryKendaraanCount = "SELECT COUNT(nopolisi) AS total_kendaraan FROM kendaraan"; // Menggunakan nopolisi sebagai kolom unik
$resultKendaraanCount = mysqli_query($conn, $queryKendaraanCount);
$totalKendaraan = ($resultKendaraanCount && mysqli_num_rows($resultKendaraanCount) > 0) ? mysqli_fetch_assoc($resultKendaraanCount)['total_kendaraan'] : 0;

// 5. Total Produk (dari tabel 'produk')
$queryProdukCount = "SELECT COUNT(idproduk) AS total_produk FROM produk"; // Menggunakan idproduk sebagai kolom unik
$resultProdukCount = mysqli_query($conn, $queryProdukCount);
$totalProduk = ($resultProdukCount && mysqli_num_rows($resultProdukCount) > 0) ? mysqli_fetch_assoc($resultProdukCount)['total_produk'] : 0;

// --- Query untuk mengambil 5 transaksi service terakhir ---
$queryLatestTransactions = "
    SELECT
        s.noservice,
        s.tanggalservice,
        c.nama AS nama_customer,
        s.totalrp
    FROM
        service s
    JOIN
        kendaraan k ON s.nopolisi = k.nopolisi
    JOIN
        customer c ON k.idcust = c.idcust
    ORDER BY
        s.tanggalservice DESC, s.noservice DESC
    LIMIT 5
";
$resultLatestTransactions = mysqli_query($conn, $queryLatestTransactions);


// Tutup koneksi database jika sudah tidak diperlukan lagi di file ini
// mysqli_close($conn); // Pertimbangkan untuk menutup koneksi di akhir skrip PHP
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Amie Jaya Motor</title>
<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
  /* Style untuk Tata Letak Card */
  .dashboard-info-cards {
    display: flex;
    flex-wrap: wrap; /* Agar card bisa turun ke baris baru jika lebar tidak cukup */
    justify-content: center; /* Pusatkan kartu */
    padding: 20px;
    gap: 20px; /* Jarak antar kartu */
  }
  .info-card {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 25px;
    text-align: center;
    flex: 1 1 calc(33.333% - 40px); /* 3 kartu per baris, dengan memperhitungkan gap */
    max-width: 300px; /* Batasi lebar maksimum per kartu */
    box-sizing: border-box; /* Pastikan padding termasuk dalam lebar */
    min-width: 200px; /* Lebar minimum agar tidak terlalu kecil di layar sempit */
  }
  .info-card h3 {
    margin-top: 0;
    color: #333;
    font-size: 1.2em;
    white-space: nowrap; /* Mencegah judul patah baris */
  }
  .info-card p {
    font-size: 2.5em;
    font-weight: bold;
    color: #007bff; /* Warna biru untuk angka */
    margin-bottom: 0;
  }
  .info-card .icon {
    font-size: 3em;
    color: #007bff;
    margin-bottom: 10px;
  }

  /* Style untuk Tabel Transaksi Terbaru */
  .latest-transactions-section {
    padding: 20px;
    margin-top: 30px; /* Memberi jarak dari kartu di atas */
  }
  .latest-transactions-section h2 {
    color: #333;
    margin-bottom: 15px;
    text-align: center;
  }
  .latest-transactions-section table {
    width: 100%;
    border-collapse: collapse;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden; /* Memastikan border-radius diterapkan ke tabel */
  }
  .latest-transactions-section th,
  .latest-transactions-section td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
  }
  .latest-transactions-section th {
    background-color: #f2f2f2;
    font-weight: bold;
    color: #555;
  }
  .latest-transactions-section tbody tr:nth-child(even) {
    background-color: #f9f9f9;
  }
  .latest-transactions-section tbody tr:hover {
    background-color: #f1f1f1;
  }
  .latest-transactions-section td.no-data {
    text-align: center;
    font-style: italic;
    color: #888;
  }


  /* Media Queries untuk Responsif */
  @media (max-width: 992px) {
    .info-card {
      flex: 1 1 calc(50% - 40px); /* 2 kartu per baris pada tablet */
    }
  }

  @media (max-width: 576px) {
    .info-card {
      flex: 1 1 calc(100% - 40px); /* 1 kartu per baris pada mobile */
      max-width: 100%;
    }
  }
</style>
</head>
<body>
  <div class="sidebar">
    <div class="logo">
      <img src="../pict/yamaha.png" alt="Amie Jaya Motor Logo">
      <h1>Amie Jaya Motor</h1>
    </div>
    <ul class="menu">
      <li><a href="#" class="active"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
        <li><a href="../customer/custlihat.php"><i class="fa-solid fa-user"></i>Customer</a></li>
        <li><a href="../kasir/kasirlihat.php"><i class="fas fa-clipboard-user"></i>Kasir</a></li>
        <li><a href="../kendaraan/kendlihat.php"><i class="fa-solid fa-car"></i> Kendaraan</a></li>
        <li><a href="../produk/prodlihat.php"><i class="fa-solid fa-puzzle-piece"></i>Produk</a></li>
        <li><a href="../notapenjualan/notapenjualanmelihat.php"><i class="fas fa-file-invoice"></i>Nota Service</a></li>
        <li><a class="setting" href="../index.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
      </ul>
  </div>
  <div class="content">
    <div class="header">
      <h2>Dashboard</h2>
      <div class="user-profile">
        <img src="../pict/admin.png" alt="User Profile">
        <div class="user-info">
          <p>Mang Winrat</p>
          <span>Admin</span>
        </div>
      </div>
    </div>

    <div class="dashboard-info-cards">
      <div class="info-card">
        <div class="icon"><i class="fas fa-receipt"></i></div>
        <h3>Total Transaksi</h3>
        <p><?php echo htmlspecialchars($totalTransaksi); ?></p>
      </div>

      <div class="info-card">
        <div class="icon"><i class="fa-solid fa-user"></i></div>
        <h3>Total Customer</h3>
        <p><?php echo htmlspecialchars($totalCustomer); ?></p>
      </div>

      <div class="info-card">
        <div class="icon"><i class="fas fa-clipboard-user"></i></div>
        <h3>Total Kasir</h3>
        <p><?php echo htmlspecialchars($totalKasir); ?></p>
      </div>

      <div class="info-card">
        <div class="icon"><i class="fa-solid fa-car"></i></div>
        <h3>Total Kendaraan</h3>
        <p><?php echo htmlspecialchars($totalKendaraan); ?></p>
      </div>

      <div class="info-card">
        <div class="icon"><i class="fa-solid fa-puzzle-piece"></i></div>
        <h3>Total Produk</h3>
        <p><?php echo htmlspecialchars($totalProduk); ?></p>
      </div>
    </div>

    <div class="latest-transactions-section">
      <h2>Transaksi Terbaru</h2>
      <table>
        <thead>
          <tr>
            <th>No. Service</th>
            <th>Tanggal</th>
            <th>Customer</th>
            <th>Total (Rp)</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($resultLatestTransactions && mysqli_num_rows($resultLatestTransactions) > 0) {
              while ($row = mysqli_fetch_assoc($resultLatestTransactions)) { ?>
              <tr>
                <td><?php echo htmlspecialchars($row['noservice']); ?></td>
                <td><?php echo htmlspecialchars($row['tanggalservice']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_customer']); ?></td>
                <td style="text-align: right;"><?php echo htmlspecialchars(number_format($row['totalrp'], 0, ',', '.')); ?></td>
              </tr>
          <?php }
          } else { ?>
              <tr>
                <td colspan="4" class="no-data">Tidak ada transaksi terbaru.</td>
              </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    </div>
</body>
</html>