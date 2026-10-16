<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Add Refugee Type</h1>
      <div class="form-section">
         <?php
        if(isset($_POST['submit'])){
          $refuge_type=mysqli_real_escape_string($conn,$_POST['refuge_type']);
          $select=mysqli_query($conn,"select * from refugee_type where type='".$refuge_type."'");
           if($row=mysqli_fetch_array($select)){
            echo "<div class='alert alert-error'>Oops $refuge_type already exists.</div>";
           }else{
            $insert=mysqli_query($conn,"insert into refugee_type(t_id,type) values(null,'".$refuge_type."')");
          if($insert){
            echo "<div class='alert alert-success'>$refuge_type created successfully</div>";
          }else{
                        echo "<div class='alert alert-error'>Oops $refuge_type failed to insert.</div>";
          }
           }
        }
        ?>
        <form action="" method="post">
            <input type="text" name="refuge_type" placeholder="Enter Refugee Type" required>
            <input type="submit" name="submit" value="Add Refugee Type" class="btn">
        </form>
      </div>
        <div class="table-section" id="list">
   <table>
        <tr>
          <th>#</th>
          <th>Refugee Type</th>
          <th>Action</th>
        </tr>
        <?php
        $select=mysqli_query($conn,"select * from refugee_type");
        $count=0;
        while($row=mysqli_fetch_array($select)){
          $count++;
          ?>
<tr>
          <td><?php echo $count; ?></td>
          <td><?php echo  htmlspecialchars($row['type']); ?></td>
          <td><div class="actions">
          <a href="update-refugee-type.php?t=<?php echo $row['t_id']; ?>"><div class="edit">Update</div></a>
           <a href="delete-refugee-type.php?t=<?php echo $row['t_id']; ?>" onclick="return confirm('Are you sure you want to delete');"><div class="delete">Delete</div></a>
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
