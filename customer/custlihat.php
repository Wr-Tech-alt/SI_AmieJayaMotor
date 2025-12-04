<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Amie Jaya Motor</title>
<link rel="stylesheet" href="css/style.css">
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
        <li><a href="#" class="active"><i class="fa-solid fa-user"></i>Customer</a></li>
        <li><a href="../kasir/kasirlihat.php"><i class="fas fa-clipboard-user"></i>Kasir</a></li>
        <li><a href="../kendaraan/kendlihat.php"><i class="fa-solid fa-car"></i> Kendaraan</a></li>
        <li><a href="../produk/prodlihat.php"><i class="fa-solid fa-puzzle-piece"></i>Produk</a></li>
        <li><a href="../notapenjualan/notapenjualanmelihat.php"><i class="fas fa-file-invoice"></i>Nota Service</a></li>
        <li><a class="setting" href="../index.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
      </ul>
  </div> 
  <div class="content">
    <div class="header">
      <h2>Data Customer</h2>
      <div class="user-profile">
        <img src="../pict/admin.png" alt="User Profile">
        <div class="user-info">
          <p>Mang Winrat</p>
          <span>Admin</span>
        </div>
      </div>
    </div>
    <div class="top-bar">
      <button class="add-button"><a href="custtambah.php">Tambah</a></button>
        <div class="search-container">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Cari Customer...">
      </div>
    </div>
    <table class="data-table">
      <thead>
        <tr>
          <th>ID Customer</th>
          <th>Nama Customer</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <tr>
      <?php
        include '../koneksi.php';
        $limit = 10; // Jumlah baris per halaman
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $start = ($page - 1) * $limit;

        // Ambil data produk dengan limit dan offset
        $query = mysqli_query($conn, "SELECT * FROM customer LIMIT $start, $limit");

        // Ambil total data untuk menghitung pagination
        $totalQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM customer");
        $totalData = mysqli_fetch_assoc($totalQuery)['total'];
        $totalPage = ceil($totalData / $limit);
        $showingFrom = $totalData > 0 ? $start + 1 : 0;
        $showingTo = min($start + $limit, $totalData);

        while ($data = mysqli_fetch_array($query)) {
        ?>
          <tr>
            <td><?= $data['idcust'] ?></td>
            <td><?= $data['nama'] ?></td>
            <td>
              <a class="edit-button" href="custubah.php?idcust=<?= $data['idcust'] ?>"><i class="fas fa-pencil-alt"></i></a> |
              <a class="delete-button" href="custhapus.php?idcust=<?= $data['idcust'] ?>" onclick="return confirm('yakin hapus?')"><i class="fas fa-trash"></i></a>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
    <div class="footer-info">
  <p class="entry-info">Menampilkan <?= $showingFrom ?> sampai <?= $showingTo ?> dari <?= $totalData ?> data</p>

  <?php if ($totalPage > 1): ?>
    <div class="pagination">
      <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>" class="btn-pagination">Previous</a>
      <?php endif; ?>
      <?php if ($page < $totalPage): ?>
        <a href="?page=<?= $page + 1 ?>" class="btn-pagination">Next</a>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>
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
