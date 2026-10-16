<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Update Location</h1>
      <div class="form-section">
        <?php
        if(!isset($_GET['l'])){
          header('location:add-location.php');
          exit;
        }
        $l_id=(int)$_GET['l'];
        if(isset($_POST['submit'])) {
            $location = mysqli_real_escape_string($conn,$_POST['location']);
            $update=mysqli_query($conn,"update location set l_name='".$location."' where l_id='".$l_id."'");
            if($update){
                echo "<div class='alert alert-success'>Location updated successfully</div>";
            }else{
                echo "<div class='alert alert-error'>Failed to update your location</div>";
            }
        }
        $select=mysqli_query($conn,"select * from location where l_id='".$l_id."'");
        $row=mysqli_fetch_array($select);
        if(!$row){
          header('location:add-location.php');
          exit;
        }
        ?>
        <form action="" method="post">
            <input type="text" name="location" value="<?php echo htmlspecialchars($row['l_name']); ?>" required>
            <input type="submit" value="Update Location" name="submit" class="btn">
        </form>
      </div>
      <p><a class="btn-link" href="add-location.php">Back to Locations</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>
