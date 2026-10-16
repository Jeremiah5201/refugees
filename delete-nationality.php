<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['admin']==""){ header('location:staff-login.php'); exit; }
$n_id=(int)$_GET['n'];
$delete=mysqli_query($conn,"delete from nationality where n_id='".$n_id."'");
if($delete){ header('location:add-nationality.php'); }
else{ echo "Failed to delete nationality. It may be linked to other records."; }
?>
