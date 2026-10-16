<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Update Camp</h1>
      <div class="form-section">
        <?php
        if(!isset($_GET['c'])){ header('location:add-camp.php'); exit; }
        $c_id=(int)$_GET['c'];
        if(isset($_POST['submit'])){
            $camp=mysqli_real_escape_string($conn,$_POST['camp']);
            $registror=(int)$_POST['registror'];
            $location=(int)$_POST['location'];
            $current=mysqli_fetch_array(mysqli_query($conn,"select * from camp where c_id='".$c_id."'"));
            $fileDestination=$current['campIMG'];

            if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=""){
              $fileName=$_FILES['file']['name'];
              $fileErr=$_FILES['file']['error'];
              $fileSize=$_FILES['file']['size'];
              $fileTmp=$_FILES['file']['tmp_name'];
              $fileExt=explode(".",$fileName);
              $fileActualExt=strtolower(end($fileExt));
              $fileAllowedExt=array('png','jpg','jpeg');
              if(in_array($fileActualExt,$fileAllowedExt) && $fileErr==0 && $fileSize < 2000000){
                $fileNewName=uniqid('', true).".".$fileActualExt;
                $fileDestination='campIMG/'.$fileNewName;
                move_uploaded_file($fileTmp,$fileDestination);
              }
            }

            $update=mysqli_query($conn,"update camp set campIMG='".$fileDestination."', c_name='".$camp."', l_id='".$location."', r_id='".$registror."' where c_id='".$c_id."'");
            if($update){ echo "<div class='alert alert-success'>Camp updated successfully.</div>"; }
            else{ echo "<div class='alert alert-error'>Failed to update camp.</div>"; }
        }
        $row=mysqli_fetch_array(mysqli_query($conn,"select * from camp where c_id='".$c_id."'"));
        if(!$row){ header('location:add-camp.php'); exit; }
        ?>
        <form method="post" enctype="multipart/form-data">
            <label>Current Image</label>
            <div style="padding:0 10px 10px"><img src="<?php echo htmlspecialchars($row['campIMG']); ?>" alt="" style="width:120px;border-radius:10px"></div>
            <label>Change Image (optional)</label>
            <input type="file" name="file" accept=".png,.jpg,.jpeg">
            <input type="text" name="camp" value="<?php echo htmlspecialchars($row['c_name']); ?>" required>
            <select name="location" required>
                <option value="">Select Location</option>
                <?php
                $select=mysqli_query($conn,"select * from location");
                while($opt=mysqli_fetch_assoc($select)){
                  $selected=$opt['l_id']==$row['l_id']?'selected':'';
                ?>
                <option value="<?php echo $opt['l_id']; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($opt['l_name']); ?></option>
                <?php } ?>
            </select>
            <select name="registror" required>
                <option value="">Select Camp Registror</option>
                <?php
                $select=mysqli_query($conn,"select * from registrar");
                while($opt=mysqli_fetch_assoc($select)){
                  $selected=$opt['r_id']==$row['r_id']?'selected':'';
                ?>
                <option value="<?php echo $opt['r_id']; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($opt['r_name']); ?></option>
                <?php } ?>
            </select>
            <input type="submit" name="submit" value="Update Camp" class="btn">
        </form>
      </div>
      <p><a class="btn-link" href="add-camp.php">Back</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>
