<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Amie Jaya Motor</title>
<link rel="stylesheet" href="css/notapenjualanmelihat.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
  <div class="sidebar">
    <div class="logo">
      <img src="../pict/yamaha.png" alt="SMG Logo">
      <h1>Amie Jaya Motor</h1>
    </div>
    <ul class="menu">
      <li><a href="../dashboard/dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
        <li><a href="../customer/custlihat.php"><i class="fa-solid fa-user"></i>Customer</a></li>
        <li><a href="../kasir/kasirlihat.php"><i class="fas fa-clipboard-user"></i>Kasir</a></li>
        <li><a href="../kendaraan/kendlihat.php"><i class="fa-solid fa-car"></i> Kendaraan</a></li>
        <li><a href="../produk/prodlihat.php"><i class="fa-solid fa-puzzle-piece"></i>Produk</a></li>
        <li><a href="#" class="active"><i class="fas fa-file-invoice"></i>Nota Service</a></li>
        <li><a class="setting" href="../index.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
      </ul>
  </div> 
  <div class="content">
    <div class="header">
      <h2>Data Nota Service</h2>
      <div class="user-profile">
        <img src="../pict/admin.png" alt="User Profile">
        <div class="user-info">
          <p>Mang Winrat</p>
          <span>Admin</span>
        </div>
      </div>
    </div>
    <div class="top-bar">
      <button class="add-button"><a href="notapenjualanmenambah.php">Tambah</a></button>
        <div class="search-container">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Cari Service...">
      </div>
    </div>
    <table class="data-table">
      <thead>
        <tr>
          <th>No Service</th>
          <th>No Polisi</th>
          <th>Kasir</th>
          <th>No WO</th>
          <th>NO JO</th>
          <th>Tanggal</th>
          <th>Total</th>
          <th>Total<br>Bayar</th>
          <th>Total<br>Kembali</th>
          <th>Action</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
      <tr>
    <?php
            include '../koneksi.php';
            // Pagination
            $limit = 10; // Jumlah baris per halaman
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($page - 1) * $limit;
            $query = mysqli_query($conn, "SELECT service.noservice, 
            service.noworkorder, 
            service.noorderjob, 
            service.tanggalservice, 
            service.totalrp, 
            service.totalbayar, 
            service.kembalirp, 
            kendaraan.nopolisi,
            kasir.namakasir
            FROM service
            INNER JOIN kendaraan ON service.nopolisi = kendaraan.nopolisi 
            INNER JOIN kasir ON service.idkasir = kasir.idkasir   
            LIMIT $start, $limit");
            while ($data = mysqli_fetch_array($query)) {
                ?>
                <tr>
                <td><?php echo $data['noservice'] ;?></td>
                <td><?php echo $data['nopolisi'];?></td>
                <td><?php echo $data['namakasir'];?></td>
                <td><?php echo $data['noworkorder'];?></td>
                <td><?php echo $data['noorderjob'] ;?></td>
                <td><?php echo $data['tanggalservice'] ;?></td>
                <td><?php echo $data['totalrp'] ;?></td>
                <td><?php echo $data['totalbayar'] ;?></td>
                <td><?php echo $data['kembalirp'] ;?></td>
                <td>
                  <a class="edit-button" href="notapenjualanmerubah.php?noservice=<?php echo $data['noservice'];?>" ><i class="fas fa-pencil-alt"></i></a> |
                  <a class="delete-button" href="notapenjualanmenghapus.php?noservice=<?php echo $data['noservice']; ?>" onclick="return confirm('yakin hapus?')"><i class="fas fa-trash"></i></a>
                </td>
                <td>	
                    <a class="edit-button" href="../detailpart/notadetail.php?noservice=<?php echo $data['noservice']; ?>"><i class="fa-solid fa-file"></i></a>	|
                    <a class="delete-button" href="notacetak.php?noservice=<?php echo $data['noservice']; ?>"><i class="fa-solid fa-print"></i></a>	
                </td>	
            </tr>
            <?php }
             ?>
      </tbody>
    </table>
  </div>
  <script>
  document.getElementById("searchInput").addEventListener("keyup", function () {
    const input = this.value.toLowerCase();
    const rows = document.querySelectorAll(".data-table tbody tr");

    rows.forEach((row) => {
      const rowText = row.innerText.toLowerCase();
      if (rowText.includes(input)) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });
</script>
</body>
</html>
