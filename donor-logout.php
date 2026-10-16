<?php
session_start();
unset($_SESSION['donor']);
unset($_SESSION['donor_name']);
header('location:index.php');
exit;
?>
