<?php include "includes/header.php" ?>
<div class="container">
    <div class="sidebar">
<?php include "includes/sidebar.php"; ?>
    </div>
    <div class="main">
      <h1>My Camp Overview</h1>
      <?php
        $r_id=(int)$_SESSION['registrar'];
        $c_id=(int)$_SESSION['camp'];
        $camp=mysqli_fetch_array(mysqli_query($conn,"select camp.*, location.l_name from camp left join location on camp.l_id=location.l_id where camp.c_id='".$c_id."'"));
        $refugeeCount=mysqli_fetch_array(mysqli_query($conn,"select count(*) as total from refugee where c_id='".$c_id."'"));
        $needCount=mysqli_fetch_array(mysqli_query($conn,"select count(*) as total from camp_need where c_id='".$c_id."' and status='Open'"));
        $donationCount=mysqli_fetch_array(mysqli_query($conn,"select count(*) as total from donation where c_id='".$c_id."'"));
      ?>
      <div class="stats-row">
        <div class="stat-card"><span>Refugees</span><strong><?php echo (int)$refugeeCount['total']; ?></strong></div>
        <div class="stat-card"><span>Open Needs</span><strong><?php echo (int)$needCount['total']; ?></strong></div>
        <div class="stat-card"><span>Donations</span><strong><?php echo (int)$donationCount['total']; ?></strong></div>
        <div class="stat-card"><span>Camp</span><strong style="font-size:1.1rem"><?php echo htmlspecialchars($camp ? $camp['c_name'] : 'Unassigned'); ?></strong></div>
      </div>

      <?php if($camp){ ?>
      <div class="hero-camp">
        <img src="../<?php echo htmlspecialchars($camp['campIMG']); ?>" alt="<?php echo htmlspecialchars($camp['c_name']); ?>">
      </div>
      <div class="detail-grid">
        <div class="detail-card">
          <h3>Camp Info</h3>
          <p><strong>Name:</strong> <?php echo htmlspecialchars($camp['c_name']); ?></p>
          <p><strong>Location:</strong> <?php echo htmlspecialchars($camp['l_name'] ? $camp['l_name'] : 'N/A'); ?></p>
        </div>
        <div class="detail-card">
          <h3>Quick Actions</h3>
          <p><a class="btn-link" href="refugee.php">Register Refugee</a></p>
          <p style="margin-top:10px"><a class="btn-link" href="camp-needs.php">Post Camp Need</a></p>
          <p style="margin-top:10px"><a class="btn-link" href="donations.php">View Donations</a></p>
        </div>
      </div>
      <?php } else { ?>
        <div class="empty-state">No camp is assigned to your account. Contact an admin.</div>
      <?php } ?>

      <div class="table-section">
        <table>
          <tr>
            <th>#</th>
            <th>Open Need</th>
            <th>Resource</th>
            <th>Quantity</th>
            <th>Posted</th>
          </tr>
          <?php
          $select=mysqli_query($conn,"select camp_need.*, resources.resource from camp_need
          left join resources on camp_need.res_id=resources.res_id
          where camp_need.c_id='".$c_id."' and camp_need.status='Open'
          order by camp_need.need_id desc limit 5");
          $count=0;
          while($row=mysqli_fetch_array($select)){
            $count++;
          ?>
          <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td><?php echo htmlspecialchars($row['resource']); ?></td>
            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
            <td><?php echo htmlspecialchars($row['posted_date']); ?></td>
          </tr>
          <?php }
          if($count==0){ echo "<tr><td colspan='5' class='empty-state'>No open needs. <a href='camp-needs.php'>Post one</a>.</td></tr>"; }
          ?>
        </table>
      </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
