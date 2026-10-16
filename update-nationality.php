<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Update Nationality</h1>
      <div class="form-section">
        <?php
        if(!isset($_GET['n'])){ header('location:add-nationality.php'); exit; }
        $n_id=(int)$_GET['n'];
        if(isset($_POST['submit'])){
          $nationality=mysqli_real_escape_string($conn,$_POST['natinality']);
          $update=mysqli_query($conn,"update nationality set nationality='".$nationality."' where n_id='".$n_id."'");
          if($update){ echo "<div class='alert alert-success'>Nationality updated successfully</div>"; }
          else{ echo "<div class='alert alert-error'>Failed to update nationality</div>"; }
        }
        $row=mysqli_fetch_array(mysqli_query($conn,"select * from nationality where n_id='".$n_id."'"));
        if(!$row){ header('location:add-nationality.php'); exit; }
        ?>
        <form method="post">
            <input type="text" name="natinality" value="<?php echo htmlspecialchars($row['nationality']); ?>" required>
            <input type="submit" name="submit" value="Update Nationality" class="btn">
        </form>
      </div>
      <p><a class="btn-link" href="add-nationality.php">Back</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>
