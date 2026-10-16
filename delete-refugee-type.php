<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['admin']==""){ header('location:staff-login.php'); exit; }
$t_id=(int)$_GET['t'];
$delete=mysqli_query($conn,"delete from refugee_type where t_id='".$t_id."'");
if($delete){ header('location:refugee-type.php'); }
else{ echo "Failed to delete refugee type. It may be linked to other records."; }
?>
