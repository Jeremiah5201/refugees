<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['admin']==""){ header('location:staff-login.php'); exit; }
$don_id=(int)$_GET['don'];
$delete=mysqli_query($conn,"delete from donation where don_id='".$don_id."'");
if($delete){ header('location:add-donation.php'); }
else{ echo "Failed to delete donation."; }
?>
