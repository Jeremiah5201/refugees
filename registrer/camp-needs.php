<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Camp Needs</h1>
      <div class="form-section">
        <?php
        $r_id=(int)$_SESSION['registrar'];
        $c_id=(int)$_SESSION['camp'];

        if(isset($_POST['submit'])){
          $resource=(int)$_POST['resource'];
          $quantity=mysqli_real_escape_string($conn,$_POST['quantity']);
          $description=mysqli_real_escape_string($conn,$_POST['description']);
          $posted_date=date('Y-m-d');
          if($c_id < 1){
            echo "<div class='alert alert-error'>No camp assigned to your account.</div>";
          }else{
            $insert=mysqli_query($conn,"insert into camp_need(need_id,c_id,r_id,res_id,quantity,description,status,posted_date)
            values(null,'".$c_id."','".$r_id."','".$resource."','".$quantity."','".$description."','Open','".$posted_date."')");
            if($insert){
              echo "<div class='alert alert-success'>Camp need posted. It now appears on the public homepage.</div>";
            }else{
              echo "<div class='alert alert-error'>Failed to post need: ".mysqli_error($conn)."</div>";
            }
          }
        }
        ?>
        <form method="post">
            <select name="resource" required>
                <option value="">Select Resource Needed</option>
                <?php
                $select=mysqli_query($conn,"select * from resources order by resource");
                while($row=mysqli_fetch_assoc($select)){
                ?>
                <option value="<?php echo $row['res_id']; ?>"><?php echo htmlspecialchars($row['resource']); ?></option>
                <?php } ?>
            </select>
            <input type="text" name="quantity" placeholder="Quantity needed (e.g. 100 packs)" required>
            <textarea name="description" placeholder="Describe the need for donors..." required></textarea>
            <input type="submit" name="submit" value="Post Camp Need" class="btn">
        </form>
      </div>

      <div class="table-section" id="list">
        <table>
          <tr>
            <th>#</th>
            <th>Resource</th>
            <th>Quantity</th>
            <th>Description</th>
            <th>Status</th>
            <th>Posted</th>
            <th>Action</th>
          </tr>
          <?php
          $select=mysqli_query($conn,"select camp_need.*, resources.resource from camp_need
          left join resources on camp_need.res_id=resources.res_id
          where camp_need.c_id='".$c_id."'
          order by camp_need.need_id desc");
          $count=0;
          while($row=mysqli_fetch_array($select)){
            $count++;
          ?>
          <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo htmlspecialchars($row['resource']); ?></td>
            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td><?php echo htmlspecialchars($row['posted_date']); ?></td>
            <td><div class="actions">
              <a href="update-need.php?need=<?php echo $row['need_id']; ?>"><div class="edit">Update</div></a>
              <?php if($row['status']=='Open'){ ?>
              <a href="close-need.php?need=<?php echo $row['need_id']; ?>" onclick="return confirm('Close this need?');"><div class="edit">Close</div></a>
              <?php } ?>
              <a href="delete-need.php?need=<?php echo $row['need_id']; ?>" onclick="return confirm('Delete this need?');"><div class="delete">Delete</div></a>
            </div></td>
          </tr>
          <?php }
          if($count==0){ echo "<tr><td colspan='7' class='empty-state'>No needs posted yet.</td></tr>"; }
          ?>
        </table>
      </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
