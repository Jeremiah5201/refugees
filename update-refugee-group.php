<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Update Refugee Group</h1>
      <div class="form-section">
        <?php
        if(!isset($_GET['g'])){ header('location:refugee-group.php'); exit; }
        $g_id=(int)$_GET['g'];
        if(isset($_POST['submit'])){
          $refugee_group=mysqli_real_escape_string($conn,$_POST['refugee_group']);
          $update=mysqli_query($conn,"update refugee_group set group_type='".$refugee_group."' where g_id='".$g_id."'");
          if($update){ echo "<div class='alert alert-success'>Refugee group updated successfully</div>"; }
          else{ echo "<div class='alert alert-error'>Failed to update refugee group</div>"; }
        }
        $row=mysqli_fetch_array(mysqli_query($conn,"select * from refugee_group where g_id='".$g_id."'"));
        if(!$row){ header('location:refugee-group.php'); exit; }
        ?>
        <form method="post">
            <input type="text" name="refugee_group" value="<?php echo htmlspecialchars($row['group_type']); ?>" required>
            <input type="submit" name="submit" value="Update Refugee Group" class="btn">
        </form>
      </div>
      <p><a class="btn-link" href="refugee-group.php">Back</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>
