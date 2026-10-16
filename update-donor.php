<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Update Donor</h1>
      <div class="form-section">
        <?php
        if(!isset($_GET['d'])){ header('location:add-donor.php'); exit; }
        $d_id=(int)$_GET['d'];
        if(isset($_POST['submit'])){
          $d_name=mysqli_real_escape_string($conn,$_POST['d_name']);
          $d_contact=mysqli_real_escape_string($conn,$_POST['d_contact']);
          $d_email=mysqli_real_escape_string($conn,$_POST['d_email']);
          $nationality=(int)$_POST['nationality'];
          $update=mysqli_query($conn,"update donnor set d_name='".$d_name."', d_contact='".$d_contact."', d_email='".$d_email."', n_id='".$nationality."' where d_id='".$d_id."'");
          if($update){ echo "<div class='alert alert-success'>Donor updated successfully.</div>"; }
          else{ echo "<div class='alert alert-error'>Failed to update donor.</div>"; }
        }
        $row=mysqli_fetch_array(mysqli_query($conn,"select * from donnor where d_id='".$d_id."'"));
        if(!$row){ header('location:add-donor.php'); exit; }
        ?>
        <form method="post">
            <input type="text" name="d_name" value="<?php echo htmlspecialchars($row['d_name']); ?>" required>
            <input type="text" name="d_contact" value="<?php echo htmlspecialchars($row['d_contact']); ?>" required>
            <input type="email" name="d_email" value="<?php echo htmlspecialchars($row['d_email']); ?>" required>
            <select name="nationality" required>
                <option value="">Select Nationality</option>
                <?php
                $select=mysqli_query($conn,"select * from nationality order by nationality");
                while($opt=mysqli_fetch_assoc($select)){
                  $selected=$opt['n_id']==$row['n_id']?'selected':'';
                ?>
                <option value="<?php echo $opt['n_id']; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($opt['nationality']); ?></option>
                <?php } ?>
            </select>
            <input type="submit" name="submit" value="Update Donor" class="btn">
        </form>
      </div>
      <p><a class="btn-link" href="add-donor.php">Back</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>
