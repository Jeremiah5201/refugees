<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Update Registror</h1>
      <div class="form-section">
        <?php
        if(!isset($_GET['r'])){ header('location:add-registror.php'); exit; }
        $r_id=(int)$_GET['r'];
        if(isset($_POST['submit'])){
          $r_name=mysqli_real_escape_string($conn,$_POST['r_name']);
          $r_contact=mysqli_real_escape_string($conn,$_POST['r_contact']);
          $r_email=mysqli_real_escape_string($conn,$_POST['r_email']);
          $nationality=(int)$_POST['nationality'];
          $location=(int)$_POST['location'];
          $camp=(int)$_POST['camp'];
          $update=mysqli_query($conn,"update registrar set r_name='".$r_name."', r_contact='".$r_contact."', r_email='".$r_email."', n_id='".$nationality."', l_id='".$location."', c_id='".$camp."' where r_id='".$r_id."'");
          if($update){
            mysqli_query($conn,"update camp set r_id='".$r_id."' where c_id='".$camp."'");
            echo "<div class='alert alert-success'>Registror updated successfully.</div>";
          }else{
            echo "<div class='alert alert-error'>Failed to update registror.</div>";
          }
        }
        $row=mysqli_fetch_array(mysqli_query($conn,"select * from registrar where r_id='".$r_id."'"));
        if(!$row){ header('location:add-registror.php'); exit; }
        ?>
        <form method="post">
            <input type="text" name="r_name" value="<?php echo htmlspecialchars($row['r_name']); ?>" required>
            <input type="text" name="r_contact" value="<?php echo htmlspecialchars($row['r_contact']); ?>" required>
            <input type="email" name="r_email" value="<?php echo htmlspecialchars($row['r_email']); ?>" required>
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
            <select name="location" required>
                <option value="">Select Location</option>
                <?php
                $select=mysqli_query($conn,"select * from location order by l_name");
                while($opt=mysqli_fetch_assoc($select)){
                  $selected=$opt['l_id']==$row['l_id']?'selected':'';
                ?>
                <option value="<?php echo $opt['l_id']; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($opt['l_name']); ?></option>
                <?php } ?>
            </select>
            <select name="camp" required>
                <option value="">Select Camp</option>
                <?php
                $select=mysqli_query($conn,"select * from camp order by c_name");
                while($opt=mysqli_fetch_assoc($select)){
                  $selected=$opt['c_id']==$row['c_id']?'selected':'';
                ?>
                <option value="<?php echo $opt['c_id']; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($opt['c_name']); ?></option>
                <?php } ?>
            </select>
            <input type="submit" name="submit" value="Update Registror" class="btn">
        </form>
      </div>
      <p><a class="btn-link" href="add-registror.php">Back</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>
