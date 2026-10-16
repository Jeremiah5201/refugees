<?php
include 'includes/config.php';
session_start();
if(isset($_SESSION['donor']) && $_SESSION['donor']!=""){
  header('location:donor-dashboard.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Register | Refugee Management System</title>
    <link rel="shortcut icon" href="images/favicone.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/home.css">
</head>
<body class="auth-page">
    <div class="auth-card">
        <h1>Become a Donor</h1>
        <p class="sub">Create an account to support camp needs</p>
        <?php
        if(isset($_POST['submit'])){
          $d_name=mysqli_real_escape_string($conn,$_POST['d_name']);
          $d_contact=mysqli_real_escape_string($conn,$_POST['d_contact']);
          $d_email=mysqli_real_escape_string($conn,$_POST['d_email']);
          $nationality=(int)$_POST['nationality'];
          $password=$_POST['password'];
          $cpassword=$_POST['cpassword'];
          if($password !== $cpassword){
            echo "<div class='alert alert-error'>Passwords do not match.</div>";
          }else{
            $check=mysqli_query($conn,"select * from donnor where d_email='".$d_email."'");
            if(mysqli_fetch_array($check)){
              echo "<div class='alert alert-error'>Email already exists.</div>";
            }else{
              $insert=mysqli_query($conn,"insert into donnor(d_id,d_name,d_contact,d_email,n_id,password)
              values(null,'".$d_name."','".$d_contact."','".$d_email."','".$nationality."','".md5($password)."')");
              if($insert){
                $_SESSION['donor']=mysqli_insert_id($conn);
                $_SESSION['donor_name']=$d_name;
                header('location:donate.php');
                exit;
              }else{
                echo "<div class='alert alert-error'>Failed to create account.</div>";
              }
            }
          }
        }
        ?>
        <form method="post">
            <label>Full Name</label>
            <input type="text" name="d_name" required>
            <label>Contact</label>
            <input type="text" name="d_contact" required>
            <label>Email</label>
            <input type="email" name="d_email" required>
            <label>Nationality</label>
            <select name="nationality" required>
                <option value="">Select Nationality</option>
                <?php
                $select=mysqli_query($conn,"select * from nationality order by nationality");
                while($row=mysqli_fetch_assoc($select)){
                  echo "<option value='".$row['n_id']."'>".htmlspecialchars($row['nationality'])."</option>";
                }
                ?>
            </select>
            <label>Password</label>
            <input type="password" name="password" required>
            <label>Confirm Password</label>
            <input type="password" name="cpassword" required>
            <button type="submit" name="submit" class="btn">Create Account</button>
        </form>
        <p class="links">Already a donor? <a href="donor-login.php">Login</a> · <a href="index.php">Home</a></p>
    </div>
</body>
</html>
