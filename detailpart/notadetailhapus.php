<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['noservice'])) {
    $noservice=$_GET['noservice'];
}

if (isset($_GET['idproduk'])) {
    $idproduk=$_GET['idproduk'];
}

 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM detail
WHERE noservice = '$noservice' AND idproduk = '$idproduk'");
 
// Calculate new total price after deletion
$query = "SELECT SUM(jumlah) AS Total FROM detail WHERE noservice = '$noservice'";
$totalResult = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($totalResult);
$totalHargaBaru = $row['Total'];

// Update total price in nota table
mysqli_query($conn, "UPDATE service SET totalrp = '$totalHargaBaru' WHERE noservice = '$noservice'");

// After delete redirect to Home, so that latest user list will be displayed.
if(isset($_GET['noservice'])){
    $noservice = $_GET['noservice'];
    // Gunakan nilai $kodenota untuk keperluan selanjutnya
    header("Location: notadetail.php?noservice=$noservice");
}
?>