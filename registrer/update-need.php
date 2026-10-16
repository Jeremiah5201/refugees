<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Update Camp Need</h1>
      <div class="form-section">
        <?php
        if(!isset($_GET['need'])){ header('location:camp-needs.php'); exit; }
        $need_id=(int)$_GET['need'];
        $c_id=(int)$_SESSION['camp'];
        $row=mysqli_fetch_array(mysqli_query($conn,"select * from camp_need where need_id='".$need_id."' and c_id='".$c_id."'"));
        if(!$row){ header('location:camp-needs.php'); exit; }

        if(isset($_POST['submit'])){
          $resource=(int)$_POST['resource'];
          $quantity=mysqli_real_escape_string($conn,$_POST['quantity']);
          $description=mysqli_real_escape_string($conn,$_POST['description']);
          $status=mysqli_real_escape_string($conn,$_POST['status']);
          $update=mysqli_query($conn,"update camp_need set res_id='".$resource."', quantity='".$quantity."', description='".$description."', status='".$status."' where need_id='".$need_id."' and c_id='".$c_id."'");
          if($update){ echo "<div class='alert alert-success'>Need updated.</div>"; }
          else{ echo "<div class='alert alert-error'>Failed to update need.</div>"; }
          $row=mysqli_fetch_array(mysqli_query($conn,"select * from camp_need where need_id='".$need_id."'"));
        }
        ?>
        <form method="post">
            <select name="resource" required>
                <?php $select=mysqli_query($conn,"select * from resources");
                while($opt=mysqli_fetch_assoc($select)){ $sel=$opt['res_id']==$row['res_id']?'selected':''; ?>
                <option value="<?php echo $opt['res_id']; ?>" <?php echo $sel; ?>><?php echo htmlspecialchars($opt['resource']); ?></option>
                <?php } ?>
            </select>
            <input type="text" name="quantity" value="<?php echo htmlspecialchars($row['quantity']); ?>" required>
            <textarea name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea>
            <select name="status" required>
                <?php foreach(array('Open','Closed','Fulfilled') as $st){
                  $sel=$st==$row['status']?'selected':'';
                  echo "<option value='$st' $sel>$st</option>";
                } ?>
            </select>
            <input type="submit" name="submit" value="Update Need" class="btn">
        </form>
      </div>
      <p><a class="btn-link" href="camp-needs.php">Back</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>
