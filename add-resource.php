<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Add Resource</h1>
      <div class="form-section">
        <?php
        if(isset($_POST['submit'])){
          $resource=mysqli_real_escape_string($conn,$_POST['resource']);
          $select=mysqli_query($conn,"select * from resources where resource='".$resource."'");
           if($row=mysqli_fetch_array($select)){
            echo "<div class='alert alert-error'>Oops $resource already exists.</div>";
           }else{
            $insert=mysqli_query($conn,"insert into resources(res_id,resource) values(null,'".$resource."')");
          if($insert){
            echo "<div class='alert alert-success'>$resource created successfully</div>";
          }else{
                        echo "<div class='alert alert-error'>Oops $resource failed to insert.</div>";
          }
           }
        }
        ?>
        <form method="post">
            <input type="text" name="resource" placeholder="Enter Resource" required>
            <input type="submit" name="submit" value="Add Resource" class="btn">
        </form>
      </div>
      <div class="table-section" id="list">
   <table>
        <tr>
          <th>#</th>
          <th>Resource</th>
          <th>Action</th>
        </tr>
        <?php
        $select=mysqli_query($conn,"select * from resources");
        $count=0;
        while($row=mysqli_fetch_array($select)){
          $count++;
          ?>
<tr>
          <td><?php echo $count; ?></td>
          <td><?php echo  htmlspecialchars($row['resource']); ?></td>
          <td><div class="actions">
          <a href="update-resource.php?res=<?php echo $row['res_id']; ?>"><div class="edit">Update</div></a>
           <a href="delete-resource.php?res=<?php echo $row['res_id']; ?>" onclick="return confirm('Are you sure you want to delete');"><div class="delete">Delete</div></a>
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
