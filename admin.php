<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Create Admin Account</h1>
      <div class="form-section">
         <?php
        if(isset($_POST['submit'])){
          $a_name=mysqli_real_escape_string($conn,$_POST['a_name']);
          $a_contact=mysqli_real_escape_string($conn,$_POST['a_contact']);
          $a_email=mysqli_real_escape_string($conn,$_POST['a_email']);
          $password=$_POST['password'];
          $cpassword=$_POST['cpassword'];
         if($password == $cpassword){
          $select=mysqli_query($conn,"select * from admin where a_email='".$a_email."'");
          if($row=mysqli_fetch_array($select)){
       echo "<div class='alert alert-error'>Email already exists</div>";
          }else{
            $insert=mysqli_query($conn,"insert into admin(a_id,a_name,a_contact,a_email,password)
          values(null,'".$a_name."','".$a_contact."','".$a_email."','".md5($password)."')");
          if($insert){
           echo "<div class='alert alert-success'>Account created successfully</div>";
          }else{
          echo "<div class='alert alert-error'>Failed to create the account.</div>";
          }
          }
         }else{
       echo "<div class='alert alert-error'>Password does not match</div>";
         }
        }
        ?>
        <form action="" method="post">
            <input type="text" name="a_name" placeholder="Enter Admin Name" required>
            <input type="text" name="a_contact" placeholder="070000000" required>
            <input type="email" name="a_email" placeholder="example@gmail.com" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <input type="password" name="cpassword" placeholder="Confirm Password" required>
            <input type="submit" name="submit" value="Add Admin" class="btn">
        </form>
      </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
