<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['idcust'])) {
    $idcust=$_GET['idcust'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM customer WHERE idcust='$idcust'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:custlihat.php");
?>