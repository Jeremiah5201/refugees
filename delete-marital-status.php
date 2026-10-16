<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['admin']==""){ header('location:staff-login.php'); exit; }
$m_id=(int)$_GET['m'];
$delete=mysqli_query($conn,"delete from marital_status where m_id='".$m_id."'");
if($delete){ header('location:marital-status.php'); }
else{ echo "Failed to delete marital status. It may be linked to other records."; }
?>
