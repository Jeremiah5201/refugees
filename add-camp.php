<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Add Camp</h1>
      <div class="form-section">
        <?php
        if(isset($_POST['submit'])){
            $camp=mysqli_real_escape_string($conn,$_POST['camp']);
            $registror=(int)$_POST['registror'];
            $location=(int)$_POST['location'];
            $fileName=$_FILES['file']['name'];
            $fileErr=$_FILES['file']['error'];
            $fileSize=$_FILES['file']['size'];
            $fileTmp=$_FILES['file']['tmp_name'];
            $fileExt=explode(".",$fileName);
            $fileActualExt=strtolower(end($fileExt));
            $fileAllowedExt=array('png','jpg','jpeg');
            if(in_array($fileActualExt,$fileAllowedExt)){
                 if($fileErr==0){
                 if($fileSize < 2000000){
                  $fileNewName=uniqid('', true).".".$fileActualExt;
                  $fileDestination='campIMG/'.$fileNewName;
                  $upload=move_uploaded_file($fileTmp,$fileDestination);
                  if($upload){
                    $insert=mysqli_query($conn,"insert into camp(c_id,campIMG,c_name,l_id,r_id)
                    values(null,'".$fileDestination."','".$camp."','".$location."','".$registror."')");
                    if($insert){
                    echo "<div class='alert alert-success'>Camp Created Successfully.</div>";
                    }else{
               echo "<div class='alert alert-error'>Failed to create the camp.</div>";
                    }
                  }else{
                   echo "<div class='alert alert-error'>File failed to upload.</div>";
                  }
                 }else{
                echo "<div class='alert alert-error'>The uploaded file is too big.</div>";
                 }
                 }else{
                echo "<div class='alert alert-error'>There was an error uploading your file, please try again.</div>";
                 }
            }else{
                echo "<div class='alert alert-error'>Unsupported file format.</div>";
            }
        }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <label>Camp Image</label>
            <input type="file" name="file" accept=".png,.jpg,.jpeg" required>
            <input type="text" name="camp" placeholder="Enter Camp Name" required>
            <select name="location" required>
                <option value="">Select Location</option>
                <?php
                $select=mysqli_query($conn,"select * from location");
                while($row=mysqli_fetch_assoc($select)){
                ?>
                <option value="<?php echo $row['l_id']; ?>"><?php echo htmlspecialchars($row['l_name']); ?></option>
                <?php } ?>
            </select>
            <select name="registror" required>
                <option value="">Select Camp Registror</option>
                <?php
                $select=mysqli_query($conn,"select * from registrar");
                while($row=mysqli_fetch_assoc($select)){
                ?>
                <option value="<?php echo $row['r_id']; ?>"><?php echo htmlspecialchars($row['r_name']); ?></option>
                <?php } ?>
            </select>
            <input type="submit" name="submit" value="Add Camp" class="btn">
        </form>
      </div>
      <div class="table-section" id="list">
   <table>
        <tr>
          <th>#</th>
          <th>Image</th>
          <th>Camp</th>
          <th>Location</th>
          <th>Registror</th>
          <th>Action</th>
        </tr>
        <?php
        $select=mysqli_query($conn,"select camp.*, location.l_name, registrar.r_name
         from camp
         left join location on camp.l_id=location.l_id
         left join registrar on camp.r_id=registrar.r_id
         order by camp.c_id desc");
        $count=0;
        while($row=mysqli_fetch_array($select)){
          $count++;
          ?>
<tr>
          <td><?php echo $count; ?></td>
          <td><img src="<?php echo  htmlspecialchars($row['campIMG']); ?>" alt=""></td>
          <td><?php echo  htmlspecialchars($row['c_name']); ?></td>
          <td><?php echo  htmlspecialchars($row['l_name']); ?></td>
          <td><?php echo  htmlspecialchars($row['r_name'] ? $row['r_name'] : 'Unassigned'); ?></td>
          <td><div class="actions">
          <a href="camp-details.php?c=<?php echo $row['c_id']; ?>"><div class="edit">View</div></a>
          <a href="update-camp.php?c=<?php echo $row['c_id']; ?>"><div class="edit">Update</div></a>
           <a href="delete-camp.php?c=<?php echo $row['c_id']; ?>" onclick="return confirm('Are you sure you want to delete');"><div class="delete">Delete</div></a>
          </div></td>
        </tr>
          <?php
        }
        ?>
      </table>
</div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
