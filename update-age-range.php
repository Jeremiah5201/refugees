<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Update Age Range</h1>
      <div class="form-section">
        <?php
        if(!isset($_GET['age'])){ header('location:refugee-age-range.php'); exit; }
        $age_id=(int)$_GET['age'];
        if(isset($_POST['submit'])){
          $range=mysqli_real_escape_string($conn,$_POST['range']);
          $range_discription=mysqli_real_escape_string($conn,$_POST['range_discription']);
          $update=mysqli_query($conn,"update age_range set a_range='".$range."', description='".$range_discription."' where age_id='".$age_id."'");
          if($update){ echo "<div class='alert alert-success'>Age range updated successfully</div>"; }
          else{ echo "<div class='alert alert-error'>Failed to update age range</div>"; }
        }
        $row=mysqli_fetch_array(mysqli_query($conn,"select * from age_range where age_id='".$age_id."'"));
        if(!$row){ header('location:refugee-age-range.php'); exit; }
        ?>
        <form method="post">
            <input type="text" name="range" value="<?php echo htmlspecialchars($row['a_range']); ?>" required>
            <input type="text" name="range_discription" value="<?php echo htmlspecialchars($row['description']); ?>" required>
            <input type="submit" name="submit" value="Update Age Range" class="btn">
        </form>
      </div>
      <p><a class="btn-link" href="refugee-age-range.php">Back</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>
