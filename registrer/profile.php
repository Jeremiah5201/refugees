<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>My Profile</h1>
      <?php
      $r_id=(int)$_SESSION['registrar'];
      if(isset($_POST['submit'])){
        $r_name=mysqli_real_escape_string($conn,$_POST['r_name']);
        $r_contact=mysqli_real_escape_string($conn,$_POST['r_contact']);
        $update=mysqli_query($conn,"update registrar set r_name='".$r_name."', r_contact='".$r_contact."' where r_id='".$r_id."'");
        if($update){
          $_SESSION['name']=$r_name;
          echo "<div class='alert alert-success'>Profile updated.</div>";
        }else{
          echo "<div class='alert alert-error'>Failed to update profile.</div>";
        }
      }
      $row=mysqli_fetch_array(mysqli_query($conn,"select registrar.*, nationality.nationality, location.l_name, camp.c_name
      from registrar
      left join nationality on registrar.n_id=nationality.n_id
      left join location on registrar.l_id=location.l_id
      left join camp on registrar.c_id=camp.c_id
      where registrar.r_id='".$r_id."'"));
      ?>
      <div class="detail-grid">
        <div class="detail-card">
          <h3>Assigned Details</h3>
          <p><strong>Email:</strong> <?php echo htmlspecialchars($row['r_email']); ?></p>
          <p><strong>Camp:</strong> <?php echo htmlspecialchars($row['c_name'] ? $row['c_name'] : 'N/A'); ?></p>
          <p><strong>Location:</strong> <?php echo htmlspecialchars($row['l_name'] ? $row['l_name'] : 'N/A'); ?></p>
          <p><strong>Nationality:</strong> <?php echo htmlspecialchars($row['nationality'] ? $row['nationality'] : 'N/A'); ?></p>
        </div>
      </div>
      <div class="form-section">
        <form method="post">
            <label>Name</label>
            <input type="text" name="r_name" value="<?php echo htmlspecialchars($row['r_name']); ?>" required>
            <label>Contact</label>
            <input type="text" name="r_contact" value="<?php echo htmlspecialchars($row['r_contact']); ?>" required>
            <input type="submit" name="submit" value="Save Profile" class="btn">
        </form>
      </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
