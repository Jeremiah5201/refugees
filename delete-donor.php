<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['admin']==""){ header('location:staff-login.php'); exit; }
$d_id=(int)$_GET['d'];
$delete=mysqli_query($conn,"delete from donnor where d_id='".$d_id."'");
if($delete){ header('location:add-donor.php'); }
else{ echo "Failed to delete donor. It may be linked to donations."; }
?>
