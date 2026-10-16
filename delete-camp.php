<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['admin']==""){ header('location:staff-login.php'); exit; }
$c_id=(int)$_GET['c'];
$delete=mysqli_query($conn,"delete from camp where c_id='".$c_id."'");
if($delete){ header('location:add-camp.php'); }
else{ echo "Failed to delete camp. It may be linked to refugees, donations or registrors."; }
?>
