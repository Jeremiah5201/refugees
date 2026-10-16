<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['admin']==""){ header('location:staff-login.php'); exit; }
$r_id=(int)$_GET['r'];
$delete=mysqli_query($conn,"delete from registrar where r_id='".$r_id."'");
if($delete){ header('location:add-registror.php'); }
else{ echo "Failed to delete registror. It may be linked to refugees or camps."; }
?>
