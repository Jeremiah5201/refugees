<?php
include 'includes/config.php';
session_start();
if(isset($_SESSION['registrar']) && $_SESSION['registrar']!=""){
  header('location:dashboard.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registror Login</title>
    <link rel="shortcut icon" href="../images/favicone.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <fieldset>
            <h1>Registror Login</h1>
            <p class="brand-sub">Camp registror portal</p>
            <?php
            if(isset($_POST['submit'])){
                $email=mysqli_real_escape_string($conn,$_POST['email']);
                $raw=$_POST['password'];
                $password=md5($raw);
                $select=mysqli_query($conn,"select * from registrar where r_email='".$email."' and (password='".$password."' or password='".mysqli_real_escape_string($conn,$raw)."')");
                if($row=mysqli_fetch_array($select)){
                    $_SESSION['registrar']=$row['r_id'];
                    $_SESSION['name']=$row['r_name'];
                    $_SESSION['camp']=$row['c_id'];
                    $_SESSION['location']=$row['l_id'];
                    header('location:dashboard.php');
                    exit;
                }else{
                    echo "<div class='login-msg'>Password or Email is incorrect.</div>";
                }
            }
            ?>
            <form method="post">
                <input type="email" name="email" placeholder="Registror Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="submit" value="Login" class="btn">
            </form>
            <p class="brand-sub" style="margin-top:18px">
                Admin? <a href="../staff-login.php" style="color:#3d4fc4;font-weight:700">Staff login</a>
            </p>
            <p class="brand-sub"><a href="../index.php" style="color:#5b6785">Back to home</a></p>
        </fieldset>
    </div>
</body>
</html>
