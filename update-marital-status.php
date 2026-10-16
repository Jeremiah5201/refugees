<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Update Marital Status</h1>
      <div class="form-section">
        <?php
        if(!isset($_GET['m'])){ header('location:marital-status.php'); exit; }
        $m_id=(int)$_GET['m'];
        if(isset($_POST['submit'])){
          $mstatus=mysqli_real_escape_string($conn,$_POST['mstatus']);
          $update=mysqli_query($conn,"update marital_status set status='".$mstatus."' where m_id='".$m_id."'");
          if($update){ echo "<div class='alert alert-success'>Marital status updated successfully</div>"; }
          else{ echo "<div class='alert alert-error'>Failed to update marital status</div>"; }
        }
        $row=mysqli_fetch_array(mysqli_query($conn,"select * from marital_status where m_id='".$m_id."'"));
        if(!$row){ header('location:marital-status.php'); exit; }
        ?>
        <form method="post">
            <input type="text" name="mstatus" value="<?php echo htmlspecialchars($row['status']); ?>" required>
            <input type="submit" name="submit" value="Update Marital Status" class="btn">
        </form>
      </div>
      <p><a class="btn-link" href="marital-status.php">Back</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>
