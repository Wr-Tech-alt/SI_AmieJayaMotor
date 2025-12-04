<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['idkasir'])) {
    $idkasir=$_GET['idkasir'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM kasir WHERE idkasir='$idkasir'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:kasirlihat.php");
?>