<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>Camp Donations</h1>
      <?php
      $c_id=(int)$_SESSION['camp'];
      if(isset($_POST['update_status'])){
        $don_id=(int)$_POST['don_id'];
        $status=mysqli_real_escape_string($conn,$_POST['status']);
        $update=mysqli_query($conn,"update donation set status='".$status."' where don_id='".$don_id."' and c_id='".$c_id."'");
        if($update){ echo "<div class='alert alert-success'>Donation status updated.</div>"; }
        else{ echo "<div class='alert alert-error'>Failed to update status.</div>"; }
      }
      ?>
      <div class="table-section">
        <table>
          <tr>
            <th>#</th>
            <th>Donor</th>
            <th>Resource</th>
            <th>Quantity</th>
            <th>Date</th>
            <th>Need</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          <?php
          $select=mysqli_query($conn,"select donation.*, donnor.d_name, resources.resource, camp_need.description
          from donation
          left join donnor on donation.d_id=donnor.d_id
          left join resources on donation.res_id=resources.res_id
          left join camp_need on donation.need_id=camp_need.need_id
          where donation.c_id='".$c_id."'
          order by donation.don_id desc");
          $count=0;
          while($row=mysqli_fetch_array($select)){
            $count++;
          ?>
          <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo htmlspecialchars($row['d_name']); ?></td>
            <td><?php echo htmlspecialchars($row['resource']); ?></td>
            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
            <td><?php echo htmlspecialchars($row['donation_date']); ?></td>
            <td><?php echo $row['description'] ? htmlspecialchars($row['description']) : '-'; ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td>
              <form method="post" style="display:flex;gap:6px;align-items:center;flex-wrap:wrap">
                <input type="hidden" name="don_id" value="<?php echo (int)$row['don_id']; ?>">
                <select name="status">
                  <?php
                  foreach(array('Pending','Received','Distributed') as $st){
                    $sel = $st==$row['status']?'selected':'';
                    echo "<option value='$st' $sel>$st</option>";
                  }
                  ?>
                </select>
                <button type="submit" name="update_status" class="edit" style="border:0;cursor:pointer">Save</button>
              </form>
            </td>
          </tr>
          <?php }
          if($count==0){ echo "<tr><td colspan='8' class='empty-state'>No donations for your camp yet.</td></tr>"; }
          ?>
        </table>
      </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
