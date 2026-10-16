<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Add Marital Status</h1>
      <?php
        if(isset($_POST['submit'])){
          $malitalstatus=mysqli_real_escape_string($conn,$_POST['mstatus']);
          $select=mysqli_query($conn,"select * from marital_status where status='".$malitalstatus."'");
           if($row=mysqli_fetch_array($select)){
            echo "<div class='alert alert-error'>Oops $malitalstatus already exists.</div>";
           }else{
            $insert=mysqli_query($conn,"insert into marital_status(m_id,status) values(null,'".$malitalstatus."')");
          if($insert){
            echo "<div class='alert alert-success'>$malitalstatus created successfully</div>";
          }else{
                        echo "<div class='alert alert-error'>Oops $malitalstatus failed to insert.</div>";
          }
           }
        }
        ?>
      <div class="form-section">
        <form method="post">
            <input type="text" name="mstatus" placeholder="Enter Marital Status" required>
            <input type="submit" name="submit" value="Add Marital Status" class="btn">
        </form>
      </div>
      <div class="table-section" id="list">
   <table>
        <tr>
          <th>#</th>
          <th>Marital Status</th>
          <th>Action</th>
        </tr>
        <?php
        $select=mysqli_query($conn,"select * from marital_status");
        $count=0;
        while($row=mysqli_fetch_array($select)){
          $count++;
          ?>
<tr>
          <td><?php echo $count; ?></td>
          <td><?php echo  htmlspecialchars($row['status']); ?></td>
          <td><div class="actions">
          <a href="update-marital-status.php?m=<?php echo $row['m_id']; ?>"><div class="edit">Update</div></a>
           <a href="delete-marital-status.php?m=<?php echo $row['m_id']; ?>" onclick="return confirm('Are you sure you want to delete');"><div class="delete">Delete</div></a>
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
