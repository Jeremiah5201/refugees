<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Add Donation</h1>
      <div class="form-section">
        <?php
        if(isset($_POST['submit'])){
          $donor=(int)$_POST['donor'];
          $resource=(int)$_POST['resource'];
          $camp=(int)$_POST['camp'];
          $quantity=mysqli_real_escape_string($conn,$_POST['quantity']);
          $donation_date=mysqli_real_escape_string($conn,$_POST['donation_date']);
          $status=mysqli_real_escape_string($conn,$_POST['status']);

          $insert=mysqli_query($conn,"insert into donation(don_id,d_id,res_id,quantity,donation_date,c_id,status)
          values(null,'".$donor."','".$resource."','".$quantity."','".$donation_date."','".$camp."','".$status."')");
          if($insert){
            echo "<div class='alert alert-success'>Donation recorded successfully.</div>";
          }else{
            echo "<div class='alert alert-error'>Failed to record donation: ".mysqli_error($conn)."</div>";
          }
        }
        ?>
        <form method="post">
            <select name="donor" required>
                <option value="">Select Donor</option>
                <?php
                $select=mysqli_query($conn,"select * from donnor order by d_name");
                while($row=mysqli_fetch_assoc($select)){
                ?>
                <option value="<?php echo $row['d_id']; ?>"><?php echo htmlspecialchars($row['d_name']); ?></option>
                <?php } ?>
            </select>
            <select name="resource" required>
                <option value="">Select Resource</option>
                <?php
                $select=mysqli_query($conn,"select * from resources order by resource");
                while($row=mysqli_fetch_assoc($select)){
                ?>
                <option value="<?php echo $row['res_id']; ?>"><?php echo htmlspecialchars($row['resource']); ?></option>
                <?php } ?>
            </select>
            <select name="camp" required>
                <option value="">Select Camp</option>
                <?php
                $select=mysqli_query($conn,"select * from camp order by c_name");
                while($row=mysqli_fetch_assoc($select)){
                ?>
                <option value="<?php echo $row['c_id']; ?>"><?php echo htmlspecialchars($row['c_name']); ?></option>
                <?php } ?>
            </select>
            <input type="text" name="quantity" placeholder="Quantity" required>
            <label>Donation Date</label>
            <input type="date" name="donation_date" value="<?php echo date('Y-m-d'); ?>" required>
            <select name="status" required>
                <option value="Pending">Pending</option>
                <option value="Received">Received</option>
                <option value="Distributed">Distributed</option>
            </select>
            <input type="submit" name="submit" value="Add Donation" class="btn">
        </form>
      </div>

      <div class="table-section" id="list">
   <table>
        <tr>
          <th>#</th>
          <th>Donor</th>
          <th>Resource</th>
          <th>Camp</th>
          <th>Quantity</th>
          <th>Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
        <?php
        $select=mysqli_query($conn,"select donation.*, donnor.d_name, resources.resource, camp.c_name
        from donation
        left join donnor on donation.d_id=donnor.d_id
        left join resources on donation.res_id=resources.res_id
        left join camp on donation.c_id=camp.c_id
        order by donation.don_id desc");
        $count=0;
        while($row=mysqli_fetch_array($select)){
          $count++;
          ?>
<tr>
          <td><?php echo $count; ?></td>
          <td><?php echo htmlspecialchars($row['d_name']); ?></td>
          <td><?php echo htmlspecialchars($row['resource']); ?></td>
          <td><?php echo htmlspecialchars($row['c_name']); ?></td>
          <td><?php echo htmlspecialchars($row['quantity']); ?></td>
          <td><?php echo htmlspecialchars($row['donation_date']); ?></td>
          <td><?php echo htmlspecialchars($row['status']); ?></td>
          <td><div class="actions">
           <a href="update-donation.php?don=<?php echo $row['don_id']; ?>"><div class="edit">Update</div></a>
           <a href="delete-donation.php?don=<?php echo $row['don_id']; ?>" onclick="return confirm('Are you sure you want to delete');"><div class="delete">Delete</div></a>
          </div></td>
        </tr>
          <?php
        }
        if($count==0){
          echo "<tr><td colspan='8' class='empty-state'>No donations recorded yet.</td></tr>";
        }
        ?>
      </table>
</div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
