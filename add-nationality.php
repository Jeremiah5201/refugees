<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Add Nationality</h1>
      <div class="form-section">
        <?php
        if(isset($_POST['submit'])){
          $nationality=mysqli_real_escape_string($conn,$_POST['natinality']);
          $select=mysqli_query($conn,"select * from nationality where nationality='".$nationality."'");
           if($row=mysqli_fetch_array($select)){
            echo "<div class='alert alert-error'>Oops $nationality already exists.</div>";
           }else{
            $insert=mysqli_query($conn,"insert into nationality(n_id,nationality) values(null,'".$nationality."')");
          if($insert){
            echo "<div class='alert alert-success'>$nationality created successfully</div>";
          }else{
                        echo "<div class='alert alert-error'>Oops $nationality failed to insert.</div>";
          }
           }
        }
        ?>
        <form action="" method="post">
            <input type="text" name="natinality" placeholder="Enter Nationality" required>
            <input type="submit" value="Add Nationality" class="btn" name="submit">
        </form>
      </div>
<div class="table-section" id="list">
   <table>
        <tr>
          <th>#</th>
          <th>Nationality</th>
          <th>Action</th>
        </tr>
        <?php
        $select=mysqli_query($conn,"select * from nationality");
        $count=0;
        while($row=mysqli_fetch_array($select)){
          $count++;
          ?>
<tr>
          <td><?php echo $count; ?></td>
          <td><?php echo  htmlspecialchars($row['nationality']); ?></td>
          <td><div class="actions">
          <a href="update-nationality.php?n=<?php echo $row['n_id']; ?>"><div class="edit">Update</div></a>
           <a href="delete-nationality.php?n=<?php echo $row['n_id']; ?>" onclick="return confirm('Are you sure you want to delete');"><div class="delete">Delete</div></a>
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
