<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Add Location</h1>
      <div class="form-section">
        <?php
        if(isset($_POST['submit'])) {
            $location = mysqli_real_escape_string($conn,$_POST['location']);
            $select=mysqli_query($conn,"select * from location where l_name='".$location."'");
            if($row=mysqli_fetch_array($select)){
            echo "<div class='alert alert-error'>$location Already Exist</div>";
        }else{
            $sql = "INSERT INTO location (l_id,l_name) VALUES (null,'$location')";
            if (mysqli_query($conn, $sql)) {
            echo "<div class='alert alert-success'>Location added successfully!</div>";
            } else {
            echo "<div class='alert alert-error'>Error adding location: " . mysqli_error($conn) . "</div>";
            }
        }
        }
        ?>
        <form action="" method="post">
            <input type="text" name="location" placeholder="Enter Location" required>
            <input type="submit" value="Add Location" name="submit" class="btn">
        </form>
      </div>
      <div class="table-section" id="list">
   <table>
        <tr>
          <th>#</th>
          <th>Location</th>
          <th>Action</th>
        </tr>
        <?php
        $select=mysqli_query($conn,"select * from location");
        $count=0;
        while($row=mysqli_fetch_array($select)){
          $count++;
          ?>
<tr>
          <td><?php echo $count; ?></td>
          <td><?php echo  htmlspecialchars($row['l_name']); ?></td>
          <td><div class="actions">
          <a href="update-location.php?l=<?php echo $row['l_id']; ?>"><div class="edit">Update</div></a>
           <a href="delete-location.php?l=<?php echo $row['l_id']; ?>" onclick="return confirm('Are you sure you want to delete');"><div class="delete">Delete</div></a>
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
