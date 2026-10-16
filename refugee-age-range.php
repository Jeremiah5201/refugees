<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Add Refugee Age Range</h1>
      <div class="form-section">
        <?php
        if(isset($_POST['submit'])){
          $range=mysqli_real_escape_string($conn,$_POST['range']);
           $range_discription=mysqli_real_escape_string($conn,$_POST['range_discription']);
          $select=mysqli_query($conn,"select * from age_range where a_range='".$range."'");
           if($row=mysqli_fetch_array($select)){
            echo "<div class='alert alert-error'>Oops $range already exists.</div>";
           }else{
            $insert=mysqli_query($conn,"insert into age_range(age_id,a_range,description) values(null,'".$range."','".$range_discription."')");
          if($insert){
            echo "<div class='alert alert-success'>$range created successfully</div>";
          }else{
                        echo "<div class='alert alert-error'>Oops $range failed to insert.</div>";
          }
           }
        }
        ?>
        <form method="post">
            <input type="text" name="range" placeholder="1-5" required>
            <input type="text" name="range_discription" placeholder="Enter Description" required>
            <input type="submit" name="submit" value="Add Refugee Age Range" class="btn">
        </form>
      </div>
       <div class="table-section" id="list">
   <table>
        <tr>
          <th>#</th>
          <th>Age Range</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
        <?php
        $select=mysqli_query($conn,"select * from age_range");
        $count=0;
        while($row=mysqli_fetch_array($select)){
          $count++;
          ?>
<tr>
          <td><?php echo $count; ?></td>
          <td><?php echo  htmlspecialchars($row['a_range']); ?></td>
          <td><?php echo  htmlspecialchars($row['description']); ?></td>
          <td><div class="actions">
          <a href="update-age-range.php?age=<?php echo $row['age_id']; ?>"><div class="edit">Update</div></a>
           <a href="delete-age-range.php?age=<?php echo $row['age_id']; ?>" onclick="return confirm('Are you sure you want to delete');"><div class="delete">Delete</div></a>
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
