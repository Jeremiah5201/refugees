<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Update Donation</h1>
      <div class="form-section">
        <?php
        if(!isset($_GET['don'])){ header('location:add-donation.php'); exit; }
        $don_id=(int)$_GET['don'];
        if(isset($_POST['submit'])){
          $donor=(int)$_POST['donor'];
          $resource=(int)$_POST['resource'];
          $camp=(int)$_POST['camp'];
          $quantity=mysqli_real_escape_string($conn,$_POST['quantity']);
          $donation_date=mysqli_real_escape_string($conn,$_POST['donation_date']);
          $status=mysqli_real_escape_string($conn,$_POST['status']);
          $update=mysqli_query($conn,"update donation set d_id='".$donor."', res_id='".$resource."', quantity='".$quantity."', donation_date='".$donation_date."', c_id='".$camp."', status='".$status."' where don_id='".$don_id."'");
          if($update){ echo "<div class='alert alert-success'>Donation updated successfully.</div>"; }
          else{ echo "<div class='alert alert-error'>Failed to update donation.</div>"; }
        }
        $row=mysqli_fetch_array(mysqli_query($conn,"select * from donation where don_id='".$don_id."'"));
        if(!$row){ header('location:add-donation.php'); exit; }
        ?>
        <form method="post">
            <select name="donor" required>
                <option value="">Select Donor</option>
                <?php $select=mysqli_query($conn,"select * from donnor order by d_name");
                while($opt=mysqli_fetch_assoc($select)){ $selected=$opt['d_id']==$row['d_id']?'selected':''; ?>
                <option value="<?php echo $opt['d_id']; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($opt['d_name']); ?></option>
                <?php } ?>
            </select>
            <select name="resource" required>
                <option value="">Select Resource</option>
                <?php $select=mysqli_query($conn,"select * from resources order by resource");
                while($opt=mysqli_fetch_assoc($select)){ $selected=$opt['res_id']==$row['res_id']?'selected':''; ?>
                <option value="<?php echo $opt['res_id']; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($opt['resource']); ?></option>
                <?php } ?>
            </select>
            <select name="camp" required>
                <option value="">Select Camp</option>
                <?php $select=mysqli_query($conn,"select * from camp order by c_name");
                while($opt=mysqli_fetch_assoc($select)){ $selected=$opt['c_id']==$row['c_id']?'selected':''; ?>
                <option value="<?php echo $opt['c_id']; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($opt['c_name']); ?></option>
                <?php } ?>
            </select>
            <input type="text" name="quantity" value="<?php echo htmlspecialchars($row['quantity']); ?>" required>
            <label>Donation Date</label>
            <input type="date" name="donation_date" value="<?php echo htmlspecialchars($row['donation_date']); ?>" required>
            <select name="status" required>
                <?php
                $statuses=array('Pending','Received','Distributed');
                foreach($statuses as $status){
                  $selected=$status==$row['status']?'selected':'';
                  echo "<option value='$status' $selected>$status</option>";
                }
                ?>
            </select>
            <input type="submit" name="submit" value="Update Donation" class="btn">
        </form>
      </div>
      <p><a class="btn-link" href="add-donation.php">Back</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>
