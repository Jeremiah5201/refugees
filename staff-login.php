<?php
// Move previous admin login here; public site uses index.php
include 'includes/config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login | Refugee Management System</title>
    <link rel="shortcut icon" href="images/favicone.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <fieldset>
            <h1>Staff Login</h1>
            <p class="brand-sub">Admin access to the management console</p>

            <?php
            if(isset($_POST['submit'])){
                $email=mysqli_real_escape_string($conn,$_POST['email']);
                $password=md5($_POST['password']);
                $select=mysqli_query($conn,"select * from admin where a_email='".$email."' and password='".$password."'");
                if($row=mysqli_fetch_array($select)){
                    $_SESSION['admin']=$row['a_id'];
                    $_SESSION['name']=$row['a_name'];
                    header('location:dashboard.php');
                    exit;
                }else{
                    echo "<div class='login-msg'>Password or Email is incorrect.</div>";
                }
            }
            ?>
            <form method="post">
                <input type="email" name="email" placeholder="Admin Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="submit" value="Login" class="btn">
            </form>
            <p class="brand-sub" style="margin-top:18px">
                Camp Registror? <a href="registrer/index.php" style="color:#3d4fc4;font-weight:700">Login here</a>
            </p>
            <p class="brand-sub">
                <a href="index.php" style="color:#5b6785">Back to home</a>
            </p>
        </fieldset>
    </div>
</body>
</html>
