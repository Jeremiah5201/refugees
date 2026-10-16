<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Add Refugee Group</h1>
      <div class="form-section">
        <?php
        if(isset($_POST['submit'])){
          $refugee_group=mysqli_real_escape_string($conn,$_POST['refugee_group']);
          $select=mysqli_query($conn,"select * from refugee_group where group_type='".$refugee_group."'");
           if($row=mysqli_fetch_array($select)){
            echo "<div class='alert alert-error'>Oops $refugee_group already exists.</div>";
           }else{
            $insert=mysqli_query($conn,"insert into refugee_group(g_id,group_type) values(null,'".$refugee_group."')");
          if($insert){
            echo "<div class='alert alert-success'>$refugee_group created successfully</div>";
          }else{
                        echo "<div class='alert alert-error'>Oops $refugee_group failed to insert.</div>";
          }
           }
        }
        ?>
        <form action="" method="post">
            <input type="text" name="refugee_group" placeholder="Enter Refugee Group" required>
            <input type="submit" name="submit" value="Add Refugee Group" class="btn">
        </form>
      </div>
      <div class="table-section" id="list">
   <table>
        <tr>
          <th>#</th>
          <th>Refugee Group Type</th>
          <th>Action</th>
        </tr>
        <?php
        $select=mysqli_query($conn,"select * from refugee_group");
        $count=0;
        while($row=mysqli_fetch_array($select)){
          $count++;
          ?>
<tr>
          <td><?php echo $count; ?></td>
          <td><?php echo  htmlspecialchars($row['group_type']); ?></td>
          <td><div class="actions">
          <a href="update-refugee-group.php?g=<?php echo $row['g_id']; ?>"><div class="edit">Update</div></a>
           <a href="delete-refugee-group.php?g=<?php echo $row['g_id']; ?>" onclick="return confirm('Are you sure you want to delete');"><div class="delete">Delete</div></a>
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
