<?php
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['admin']==""){
    header('location:staff-login.php');
    exit;
}
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refugee Management System</title>
    <link rel="shortcut icon" href="images/favicone.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <div class="nav">
        <button type="button" class="menu-toggle" id="menuToggle" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
        <div class="left">
          <a href="dashboard.php">REFUGEE MANAGEMENT SYSTEM</a>
        </div>
        <div class="right">
             <ul>
                <li class="user-menu"><?php echo htmlspecialchars($_SESSION['name']); ?>
                    <div class="subtab">
                        <ul>
                            <a href="dashboard.php"><li><img src="images/camp1.png" alt="Profile" width="120"></li></a>
                            <a href="admin.php"><li>Settings</li></a>
                            <a href="logout.php"><li>Logout</li></a>
                        </ul>
                    </div>
                </li>
             </ul>
        </div>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
