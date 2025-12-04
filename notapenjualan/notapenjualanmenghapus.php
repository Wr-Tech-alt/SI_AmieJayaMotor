<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['noservice'])) {
    $noservice=$_GET['noservice'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM service WHERE noservice='$noservice'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:notapenjualanmelihat.php");
?>