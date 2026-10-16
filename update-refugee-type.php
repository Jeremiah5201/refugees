<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Update Refugee Type</h1>
      <div class="form-section">
        <?php
        if(!isset($_GET['t'])){ header('location:refugee-type.php'); exit; }
        $t_id=(int)$_GET['t'];
        if(isset($_POST['submit'])){
          $refuge_type=mysqli_real_escape_string($conn,$_POST['refuge_type']);
          $update=mysqli_query($conn,"update refugee_type set type='".$refuge_type."' where t_id='".$t_id."'");
          if($update){ echo "<div class='alert alert-success'>Refugee type updated successfully</div>"; }
          else{ echo "<div class='alert alert-error'>Failed to update refugee type</div>"; }
        }
        $row=mysqli_fetch_array(mysqli_query($conn,"select * from refugee_type where t_id='".$t_id."'"));
        if(!$row){ header('location:refugee-type.php'); exit; }
        ?>
        <form method="post">
            <input type="text" name="refuge_type" value="<?php echo htmlspecialchars($row['type']); ?>" required>
            <input type="submit" name="submit" value="Update Refugee Type" class="btn">
        </form>
      </div>
      <p><a class="btn-link" href="refugee-type.php">Back</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>
