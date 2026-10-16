<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['admin']==""){ header('location:staff-login.php'); exit; }
$g_id=(int)$_GET['g'];
$delete=mysqli_query($conn,"delete from refugee_group where g_id='".$g_id."'");
if($delete){ header('location:refugee-group.php'); }
else{ echo "Failed to delete refugee group. It may be linked to other records."; }
?>
