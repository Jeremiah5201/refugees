<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Update Resource</h1>
      <div class="form-section">
        <?php
        if(!isset($_GET['res'])){ header('location:add-resource.php'); exit; }
        $res_id=(int)$_GET['res'];
        if(isset($_POST['submit'])){
          $resource=mysqli_real_escape_string($conn,$_POST['resource']);
          $update=mysqli_query($conn,"update resources set resource='".$resource."' where res_id='".$res_id."'");
          if($update){ echo "<div class='alert alert-success'>Resource updated successfully</div>"; }
          else{ echo "<div class='alert alert-error'>Failed to update resource</div>"; }
        }
        $row=mysqli_fetch_array(mysqli_query($conn,"select * from resources where res_id='".$res_id."'"));
        if(!$row){ header('location:add-resource.php'); exit; }
        ?>
        <form method="post">
            <input type="text" name="resource" value="<?php echo htmlspecialchars($row['resource']); ?>" required>
            <input type="submit" name="submit" value="Update Resource" class="btn">
        </form>
      </div>
      <p><a class="btn-link" href="add-resource.php">Back</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>
