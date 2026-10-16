<?php
include 'includes/config.php';
session_start();
if(isset($_SESSION['donor']) && $_SESSION['donor']!=""){
  $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'donor-dashboard.php';
  header('location:'.$redirect);
  exit;
}
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'donor-dashboard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Login | Refugee Management System</title>
    <link rel="shortcut icon" href="images/favicone.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/home.css">
</head>
<body class="auth-page">
    <div class="auth-card">
        <h1>Donor Login</h1>
        <p class="sub">Access your donations and support camps</p>
        <?php
        if(isset($_POST['submit'])){
          $email=mysqli_real_escape_string($conn,$_POST['email']);
          $password=md5($_POST['password']);
          $redirect=mysqli_real_escape_string($conn,$_POST['redirect']);
          $select=mysqli_query($conn,"select * from donnor where d_email='".$email."' and password='".$password."'");
          if($row=mysqli_fetch_array($select)){
            $_SESSION['donor']=$row['d_id'];
            $_SESSION['donor_name']=$row['d_name'];
            $go = $redirect != "" ? $redirect : 'donor-dashboard.php';
            // only allow relative redirects
            if(strpos($go,'http')===0 || strpos($go,'//')===0){ $go='donor-dashboard.php'; }
            header('location:'.$go);
            exit;
          }else{
            echo "<div class='alert alert-error'>Email or password is incorrect.</div>";
          }
        }
        ?>
        <form method="post">
            <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <button type="submit" name="submit" class="btn">Login</button>
        </form>
        <p class="links">New here? <a href="donor-register.php">Create account</a> · <a href="index.php">Home</a></p>
    </div>
</body>
</html>
